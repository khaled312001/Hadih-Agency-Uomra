<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewMessageNotification;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            // Admin can see all messages
            $messages = Message::with(['sender', 'receiver', 'order'])
                ->latest()
                ->paginate(15);
            return view('admin.messages.index', compact('messages'));
        } else {
            // Regular users see only their messages
            $messages = Message::where('receiver_id', $user->id)
                ->orWhere('sender_id', $user->id)
                ->with(['sender', 'receiver', 'order'])
                ->latest()
                ->paginate(15);
            return view('messages.index', compact('messages'));
        }
    }

    public function create(Request $request)
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            // Admin can message any user
            $orders = Order::with('user')->latest()->get();
            $users = User::where('id', '!=', $user->id)->get();
            $selectedOrder = null;
            if ($request->has('order')) {
                $selectedOrder = Order::find($request->order);
            }
            return view('admin.messages.create', compact('orders', 'users', 'selectedOrder'));
        } else {
            // Regular users can only message admins
            $orders = $user->orders()->latest()->get();
            $companyUsers = User::where('role', 'admin')->get();
            $selectedOrder = null;
            if ($request->has('order')) {
                $selectedOrder = Order::find($request->order);
            }
            return view('messages.create', compact('orders', 'companyUsers', 'selectedOrder'));
        }
    }

    public function store(Request $request)
    {

        $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'receiver_id' => 'required|exists:users,id',
            'message' => 'nullable|string|max:1000',
            'type' => 'required|in:text,image,video,file',
            'subject' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Handle file upload
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            if ($file->isValid()) {
                $attachmentPath = $file->store('message-attachments', 'public');
            } else {
                return back()->withErrors(['attachment' => 'الملف المرفوع غير صالح.'])->withInput();
            }
        }

        // Validate that either message content or attachment is provided
        if (empty($request->message) && !$request->hasFile('attachment')) {
            return back()->withErrors(['message' => 'يجب كتابة محتوى الرسالة أو رفع ملف.'])->withInput();
        }

        // Create the message
        $message = Message::create([
            'order_id' => $request->order_id,
            'sender_id' => auth()->id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'type' => $request->type,
            'subject' => $request->subject,
            'attachment' => $attachmentPath,
        ]);

        // Send email notifications
        $this->sendEmailNotifications($message);

        // Send real-time notification
        $receiver = User::find($request->receiver_id);
        if ($receiver) {
            $receiver->notify(new NewMessageNotification($message));
        }

        // Redirect based on user role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.messages.index')
                ->with('success', 'تم إرسال الرسالة بنجاح');
        } else {
            return redirect()->route('messages.index')
                ->with('success', 'تم إرسال الرسالة بنجاح');
        }
    }

    private function sendEmailNotifications($message)
    {
        $sender = $message->sender;
        $receiver = $message->receiver;
        
        // Email to receiver
        Mail::send('emails.message-received', [
            'messageData' => $message,
            'sender' => $sender,
            'receiver' => $receiver
        ], function ($mail) use ($receiver, $sender, $message) {
            $mail->to($receiver->email, $receiver->name)
                 ->subject('رسالة جديدة من ' . $sender->name . ' - هدية');
        });

        // Email copy to sender
        Mail::send('emails.message-sent', [
            'messageData' => $message,
            'sender' => $sender,
            'receiver' => $receiver
        ], function ($mail) use ($sender, $receiver, $message) {
            $mail->to($sender->email, $sender->name)
                 ->subject('نسخة من رسالتك إلى ' . $receiver->name . ' - هدية');
        });
    }

    public function show(Message $message)
    {
        // Mark as read if receiver is current user
        if ($message->receiver_id === auth()->id() && !$message->is_read) {
            $message->update([
                'is_read' => true,
                'read_at' => now(),
            ]);
        }

        // Check if this is an admin request
        if (request()->is('admin/*')) {
            return view('admin.messages.show', compact('message'));
        }
        
        return view('messages.show', compact('message'));
    }

    public function edit(Message $message)
    {
        // Check if this is an admin request
        if (request()->is('admin/*')) {
            return view('admin.messages.edit', compact('message'));
        }
        
        return view('messages.edit', compact('message'));
    }

    public function update(Request $request, Message $message)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'subject' => 'nullable|string|max:255',
            'attachment' => 'nullable|file|max:10240', // 10MB max
        ]);

        // Handle file upload
        $attachmentPath = $message->attachment; // Keep existing attachment
        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($message->attachment && Storage::disk('public')->exists($message->attachment)) {
                Storage::disk('public')->delete($message->attachment);
            }
            
            $file = $request->file('attachment');
            $attachmentPath = $file->store('message-attachments', 'public');
        }

        // Validate that either message content or attachment is provided
        if (empty($request->message) && !$request->hasFile('attachment') && !$message->attachment) {
            return back()->withErrors(['message' => 'يجب كتابة محتوى الرسالة أو رفع ملف.'])->withInput();
        }

        $message->update([
            'message' => $request->message,
            'subject' => $request->subject,
            'attachment' => $attachmentPath,
        ]);

        // Redirect based on user role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.messages.index')
                ->with('success', 'تم تحديث الرسالة بنجاح');
        } else {
            return redirect()->route('messages.index')
                ->with('success', 'تم تحديث الرسالة بنجاح');
        }
    }

    public function destroy(Message $message)
    {
        $message->delete();
        
        // Redirect based on user role
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.messages.index')
                ->with('success', 'تم حذف الرسالة بنجاح');
        } else {
            return redirect()->route('messages.index')
                ->with('success', 'تم حذف الرسالة بنجاح');
        }
    }
}
