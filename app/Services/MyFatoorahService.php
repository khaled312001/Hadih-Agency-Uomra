<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MyFatoorahService
{
    protected $token;
    protected $baseUrl;

    public function __construct()
    {
        $this->token = config('services.myfatoorah.token');
        $this->baseUrl = config('services.myfatoorah.base_url');
    }

    /**
     * Execute a payment request
     */
    public function executePayment($data)
    {
        try {
            $response = Http::withToken($this->token)
                ->post($this->baseUrl . '/v2/ExecutePayment', $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('MyFatoorah ExecutePayment Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return ['IsSuccess' => false, 'Message' => $response->json('Message') ?? 'Unknown error'];
        } catch (\Exception $e) {
            Log::error('MyFatoorah ExecutePayment Exception', ['message' => $e->getMessage()]);
            return ['IsSuccess' => false, 'Message' => $e->getMessage()];
        }
    }

    /**
     * Get payment status
     */
    public function getPaymentStatus($key, $keyType = 'PaymentId')
    {
        try {
            $data = [
                'Key' => $key,
                'KeyType' => $keyType
            ];

            $response = Http::withToken($this->token)
                ->post($this->baseUrl . '/v2/GetPaymentStatus', $data);

            if ($response->successful()) {
                return $response->json();
            }

            Log::error('MyFatoorah GetPaymentStatus Error', [
                'status' => $response->status(),
                'body' => $response->body()
            ]);

            return ['IsSuccess' => false, 'Message' => $response->json('Message') ?? 'Unknown error'];
        } catch (\Exception $e) {
            Log::error('MyFatoorah GetPaymentStatus Exception', ['message' => $e->getMessage()]);
            return ['IsSuccess' => false, 'Message' => $e->getMessage()];
        }
    }
}
