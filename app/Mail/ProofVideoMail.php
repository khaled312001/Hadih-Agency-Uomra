<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Video;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProofVideoMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $video;

    public function __construct(Order $order, Video $video)
    {
        $this->order = $order;
        $this->video = $video;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'فيديو إثبات أداء العمرة - طلب رقم ' . $this->order->order_number,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.proof_video',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
