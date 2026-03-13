<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Video;
use App\Mail\ProofVideoMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrderVideoController extends Controller
{
    public function store(Request $request, Order $order)
    {
        $request->validate([
            'video' => 'required|file|mimes:mp4,mov,ogg,qt|max:51200', // 50MB limit
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('proof-videos', 'public');

            $video = Video::create([
                'order_id' => $order->id,
                'title' => $request->title,
                'description' => $request->description,
                'video_path' => $path,
                'is_approved' => true, // Admin uploaded, so pre-approved
            ]);

            // Notify customer via email
            if ($order->customer_email) {
                try {
                    Mail::to($order->customer_email)->send(new ProofVideoMail($order, $video));
                } catch (\Exception $e) {
                    \Log::error('Failed to send proof video email: ' . $e->getMessage());
                }
            }

            return back()->with('success', 'تم رفع فيديو الإثبات بنجاح وإشعار العميل.');
        }

        return back()->with('error', 'فشل رفع الفيديو.');
    }

    public function destroy(Video $video)
    {
        Storage::disk('public')->delete($video->video_path);
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        $video->delete();

        return back()->with('success', 'تم حذف الفيديو بنجاح.');
    }
}
