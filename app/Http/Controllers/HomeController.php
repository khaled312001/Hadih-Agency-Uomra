<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\UmrahPackage;
use App\Models\Order;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Show the landing page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $packages = UmrahPackage::active()->ordered()->get();
        $stats = [
            'total_orders' => Order::count() > 0 ? Order::count() : 1247,
            'total_users' => User::count() > 0 ? User::count() : 892,
            'completed_orders' => Order::where('status', 'completed')->count() > 0 ? Order::where('status', 'completed')->count() : 1156,
        ];
        
        
        return view('welcome', compact('packages', 'stats'));
    }

    /**
     * Show the user home page.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function home()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)->latest()->take(5)->get();
        
        return view('home', compact('orders'));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Get user's orders with statistics
        $userOrders = Order::where('user_id', $user->id);
        $totalOrders = $userOrders->count();
        $pendingOrders = $userOrders->where('status', 'pending')->count();
        $completedOrders = $userOrders->where('status', 'completed')->count();
        $cancelledOrders = $userOrders->where('status', 'cancelled')->count();
        
        // Recent orders
        $recentOrders = $userOrders->with(['umrahPackage'])
            ->latest()
            ->take(10)
            ->get();
        
        // Monthly order statistics for chart
        $monthlyOrders = $userOrders->selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('count', 'month')
            ->toArray();
        
        // Fill missing months with 0
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyData[] = $monthlyOrders[$i] ?? 0;
        }
        
        // Order status distribution
        $statusData = [
            'pending' => $pendingOrders,
            'completed' => $completedOrders,
            'cancelled' => $cancelledOrders
        ];
        
        // Recent messages
        $recentMessages = $user->receivedMessages()
            ->with('sender')
            ->latest()
            ->take(5)
            ->get();
        
        // Available packages
        $availablePackages = UmrahPackage::active()->take(6)->get();
        
        // User statistics
        $userStats = [
            'total_orders' => $totalOrders,
            'pending_orders' => $pendingOrders,
            'completed_orders' => $completedOrders,
            'cancelled_orders' => $cancelledOrders,
            'total_messages' => $user->receivedMessages()->count(),
            'unread_messages' => $user->receivedMessages()->where('is_read', false)->count(),
        ];
        
        return view('dashboard', compact(
            'user', 'recentOrders', 'recentMessages', 'availablePackages', 
            'userStats', 'monthlyData', 'statusData'
        ));
    }

    /**
     * Show the user profile.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function profile()
    {
        $user = Auth::user();
        return view('profile', compact('user'));
    }

    /**
     * Update the user profile.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|unique:users,phone,' . $user->id,
            'country_code' => 'required|string|max:5',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'country_code']));

        return redirect()->route('profile')->with('success', 'تم تحديث الملف الشخصي بنجاح');
    }

    /**
     * Update the user password.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return redirect()->route('profile')->with('success', 'تم تغيير كلمة المرور بنجاح');
    }
}
