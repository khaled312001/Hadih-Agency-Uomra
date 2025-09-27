<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Message;

class NewMessageNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $sender = $this->message->sender;
        $subject = $this->message->subject ?: 'رسالة جديدة من ' . $sender->name;
        
        return (new MailMessage)
            ->subject($subject)
            ->greeting('مرحباً ' . $notifiable->name)
            ->line('لقد تلقيت رسالة جديدة من ' . $sender->name)
            ->line('الرسالة: ' . $this->message->message)
            ->action('عرض الرسالة', url('/messages/' . $this->message->id))
            ->line('شكراً لاستخدامك تطبيق هدية!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'sender_id' => $this->message->sender_id,
            'sender_name' => $this->message->sender->name,
            'subject' => $this->message->subject,
            'message_preview' => \Str::limit($this->message->message, 100),
            'order_id' => $this->message->order_id,
            'order_number' => $this->message->order ? $this->message->order->order_number : null,
            'type' => $this->message->type,
            'created_at' => $this->message->created_at,
        ];
    }
}
