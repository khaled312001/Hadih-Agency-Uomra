<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\UmrahPackage;
use App\Models\Payment;
use App\Models\Message;
use App\Models\Video;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function dashboard()
    {
        // الإحصائيات الأساسية
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_packages' => UmrahPackage::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'active_packages' => UmrahPackage::where('is_active', true)->count(),
            'total_messages' => Message::count(),
            'total_videos' => Video::count(),
        ];

        // إحصائيات الطلبات حسب الحالة
        $orders_by_status = Order::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        // إحصائيات الطلبات حسب الشهر (آخر 6 أشهر)
        $orders_by_month = Order::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        // إحصائيات الإيرادات حسب الشهر
        $revenue_by_month = Payment::select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('sum(amount) as total')
            )
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month')
            ->toArray();

        // أكثر الحزم طلباً
        $popular_packages = UmrahPackage::withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->take(5)
            ->get();

        // إحصائيات المستخدمين الجدد (آخر 30 يوم)
        $new_users = User::where('created_at', '>=', Carbon::now()->subDays(30))->count();

        // إحصائيات الطلبات اليومية (آخر 7 أيام)
        $daily_orders = Order::select(
                DB::raw('date(created_at) as date'),
                DB::raw('count(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date')
            ->toArray();

        // إحصائيات المدفوعات حسب الطريقة
        $payments_by_method = Payment::select('payment_method', DB::raw('count(*) as count'))
            ->groupBy('payment_method')
            ->pluck('count', 'payment_method')
            ->toArray();

        // الطلبات الأخيرة
        $recent_orders = Order::with(['user', 'umrahPackage'])
            ->latest()
            ->take(10)
            ->get();

        // المستخدمين النشطين (آخر 7 أيام)
        $active_users = User::whereHas('orders', function($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        })->count();

        // متوسط قيمة الطلب
        $average_order_value = Order::avg('total_amount');

        // معدل إكمال الطلبات
        $completion_rate = Order::count() > 0 ? 
            (Order::where('status', 'completed')->count() / Order::count()) * 100 : 0;

        return view('admin.dashboard', compact(
            'stats',
            'orders_by_status',
            'orders_by_month',
            'revenue_by_month',
            'popular_packages',
            'new_users',
            'daily_orders',
            'payments_by_method',
            'recent_orders',
            'active_users',
            'average_order_value',
            'completion_rate'
        ));
    }

    public function profile()
    {
        $user = auth()->user();
        return view('admin.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('admin.profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')->with('success', 'تم تحديث كلمة المرور بنجاح');
    }
}
