<?php

namespace App\Services;

class WhatsAppService
{
    /**
     * Generate a WhatsApp direct link for a message.
     */
    public static function generateLink($phone, $message)
    {
        // Remove non-numeric characters from phone
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        $encodedMessage = urlencode($message);
        
        return "https://wa.me/{$phone}?text={$encodedMessage}";
    }
}
