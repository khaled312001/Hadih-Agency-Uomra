<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\UmrahPackage;
use App\Models\Payment;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function __construct()
    {
        // Middleware is now handled in web.php for specific routes
    }

    protected function getPaymentService()
    {
        return new \App\Services\MyFatoorahService();
    }

    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $orders = Order::with(['user', 'umrahPackage'])
                ->latest()
                ->paginate(15);
            return view('admin.orders.index', compact('orders'));
        } else {
            $orders = Order::where('user_id', $user->id)
                ->with(['umrahPackage'])
                ->latest()
                ->paginate(15);
        }

        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $packages = UmrahPackage::active()->ordered()->get();
        
        // Check if this is an admin request
        if (request()->is('admin/*')) {
            return view('admin.orders.create', compact('packages'));
        }
        
        return view('orders.create', compact('packages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'umrah_package_id' => 'required|exists:umrah_packages,id',
            'user_id' => 'nullable|exists:users,id',
            'customer_name' => auth()->check() ? 'nullable|string|max:255' : 'required|string|max:255',
            'customer_email' => auth()->check() ? 'nullable|email' : 'required|email',
            'customer_phone' => auth()->check() ? 'nullable|string|max:20' : 'required|string|max:20',
            'beneficiary_name' => 'required|string|max:255',
            'beneficiary_phone' => 'required|string|max:20',
            'whatsapp_country_code' => 'required|string|max:5',
            'whatsapp_phone' => 'required|string|max:20',
            'beneficiary_address' => 'nullable|string',
            'beneficiary_type' => 'required|in:deceased,sick,elderly,disabled',
            'beneficiary_details' => 'nullable|string',
            'status' => 'nullable|in:pending,assigned,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $package = UmrahPackage::findOrFail($request->umrah_package_id);
        
        // Determine user ID - admin can create orders for any user
        $userId = $request->user_id ?? auth()->id();
        
        $order = Order::create([
            'order_number' => $this->generateOrderNumber(),
            'user_id' => $userId,
            'customer_name' => $request->customer_name ?? (auth()->check() ? auth()->user()->name : null),
            'customer_email' => $request->customer_email ?? (auth()->check() ? auth()->user()->email : null),
            'customer_phone' => $request->customer_phone ?? (auth()->check() ? auth()->user()->phone : null),
            'umrah_package_id' => $package->id,
            'beneficiary_name' => $request->beneficiary_name,
            'beneficiary_phone' => $request->beneficiary_phone,
            'whatsapp_country_code' => $request->whatsapp_country_code,
            'whatsapp_phone' => $request->whatsapp_phone,
            'beneficiary_address' => $request->beneficiary_address,
            'beneficiary_type' => $request->beneficiary_type,
            'beneficiary_details' => $request->beneficiary_details,
            'total_amount' => $package->price,
            'currency' => $package->currency,
            'status' => $request->status ?? 'pending',
            'notes' => $request->notes,
        ]);

        // Initialize payment record
        $paymentRecord = Payment::create([
            'order_id' => $order->id,
            'payment_id' => 'INIT-' . Str::random(10),
            'amount' => $package->price,
            'currency' => $package->currency,
            'status' => 'pending',
        ]);

        // If guest checkout, store order number in session to allow them to view it later
        if (!auth()->check()) {
            session()->push('guest_orders', $order->id);
        }

        // MyFatoorah Integration
        $paymentData = [
            'CustomerName'       => $order->customer_name ?? 'Guest',
            'NotificationOption' => 'LNK',
            'InvoiceValue'       => $order->total_amount,
            'DisplayCurrencyIso' => $order->currency,
            'CallBackUrl'        => route('orders.payment.callback'),
            'ErrorUrl'           => route('orders.payment.error'),
            'Language'           => 'ar',
            'CustomerEmail'      => $order->customer_email,
            'CustomerMobile'     => $order->customer_phone,
            'CustomerReference'  => $order->order_number,
            'SourceInfo'         => 'Laravel ' . app()->version(),
        ];

        $paymentService = $this->getPaymentService();
        $paymentResponse = $paymentService->executePayment($paymentData);

        if (isset($paymentResponse['IsSuccess']) && $paymentResponse['IsSuccess']) {
            $paymentUrl = $paymentResponse['Data']['PaymentURL'];
            $invoiceId = $paymentResponse['Data']['InvoiceId'];
            
            $paymentRecord->update(['payment_id' => $invoiceId]);
            
            return redirect()->away($paymentUrl);
        }

        // Redirect based on request type if payment initiation fails
        if (request()->is('admin/*')) {
            return redirect()->route('admin.orders.show', $order)
                ->with('error', 'حدث خطأ في بوابة الدفع: ' . ($paymentResponse['Message'] ?? 'خطأ غير معروف'));
        }

        return redirect()->route('orders.show', $order)
            ->with('error', 'حدث خطأ في بوابة الدفع: ' . ($paymentResponse['Message'] ?? 'خطأ غير معروف'));
    }

    public function handlePaymentCallback(Request $request)
    {
        $paymentId = $request->paymentId;
        $paymentService = $this->getPaymentService();
        $statusResponse = $paymentService->getPaymentStatus($paymentId);

        if (isset($statusResponse['IsSuccess']) && $statusResponse['IsSuccess']) {
            $statusData = $statusResponse['Data'];
            $orderNumber = $statusData['CustomerReference'];
            $order = Order::where('order_number', $orderNumber)->first();

            if ($order) {
                if ($statusData['InvoiceStatus'] === 'Paid') {
                    $order->update(['status' => 'confirmed']);
                    $order->payments()->where('payment_id', $statusData['InvoiceId'])->update([
                        'status' => 'completed',
                        'paid_at' => now(),
                        'gateway_response' => $statusData
                    ]);

                    return redirect()->route('orders.show', $order)
                        ->with('success', 'تم دفع الطلب بنجاح وهو الآن قيد التأكيد');
                }
            }
        }

        return redirect()->route('orders.payment.error')
            ->with('error', 'فشلت عملية الدفع أو لم تكتمل');
    }

    public function handlePaymentError(Request $request)
    {
        return redirect()->route((auth()->check() ? 'dashboard' : 'welcome'))
            ->with('error', 'حدث خطأ أثناء عملية الدفع. يرجى المحاولة مرة أخرى');
    }

    public function show(Order $order)
    {
        $this->authorize('view', $order);
        
        $order->load(['user', 'umrahPackage', 'payments', 'messages', 'videos']);
        
        // Check if this is an admin request
        if (request()->is('admin/*')) {
            return view('admin.orders.show', compact('order'));
        }
        
        return view('orders.show', compact('order'));
    }

    public function edit(Order $order)
    {
        $this->authorize('update', $order);
        
        $packages = UmrahPackage::active()->ordered()->get();
        
        // Check if this is an admin request
        if (request()->is('admin/*')) {
            return view('admin.orders.edit', compact('order', 'packages'));
        }
        
        return view('orders.edit', compact('order', 'packages'));
    }

    public function update(Request $request, Order $order)
    {
        $this->authorize('update', $order);
        
        $request->validate([
            'status' => 'required|in:pending,assigned,in_progress,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $order->update($request->only(['status', 'notes']));

        if ($request->status === 'assigned') {
            $order->update(['assigned_at' => now()]);
        }

        if ($request->status === 'completed') {
            $order->update(['completed_at' => now()]);
        }

        // Redirect based on request type
        if (request()->is('admin/*')) {
            return redirect()->route('admin.orders.show', $order)
                ->with('success', 'تم تحديث الطلب بنجاح');
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'تم تحديث الطلب بنجاح');
    }

    public function destroy(Order $order)
    {
        $this->authorize('delete', $order);
        
        $order->delete();
        
        // Redirect based on request type
        if (request()->is('admin/*')) {
            return redirect()->route('admin.orders.index')
                ->with('success', 'تم حذف الطلب بنجاح');
        }

        return redirect()->route('orders.index')
            ->with('success', 'تم حذف الطلب بنجاح');
    }

    private function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Ymd') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (Order::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }
}
