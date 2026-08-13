<?php

namespace App\Traits;

use App\Models\ApiLog;

trait LogsApiCalls
{
    /**
     * Write a row to api_logs. Never throws — a logging failure must not
     * break the calling request (same philosophy as logPayment()).
     *
     * Expected keys in $data:
     *   method             string   default 'POST'
     *   endpoint           string   required
     *   service            string   required (Razorpay, reCAPTCHA, MSG91, ...)
     *   status_code        int|null
     *   response_time_ms   int|null
     *   request_payload    array|null
     *   response_payload   array|null
     *   error_message      string|null
     *   ip_address         string|null   default request()->ip()
     */
    protected function logApiCall(array $data): void
    {
        try {
            ApiLog::create([
                'method' => $data['method'] ?? 'POST',
                'endpoint' => $data['endpoint'],
                'service' => $data['service'],
                'status_code' => $data['status_code'] ?? null,
                'response_time_ms' => $data['response_time_ms'] ?? null,
                'request_payload' => $data['request_payload'] ?? null,
                'response_payload' => $data['response_payload'] ?? null,
                'error_message' => $data['error_message'] ?? null,
                'ip_address' => $data['ip_address'] ?? request()->ip(),
            ]);
        } catch (\Exception $e) {
            \Log::warning('API log write failed: ' . $e->getMessage());
        }
    }
}