<?php

namespace App\Support;

class TicketQrSigner
{
    public static function signPayload(string $payloadJson): string
    {
        $secret = config('services.ticket_qr.secret');

        return hash_hmac('sha256', $payloadJson, $secret);
    }

    public static function verify(string $payloadJson, string $signature): bool
    {
        $expected = self::signPayload($payloadJson);

        return hash_equals($expected, $signature);
    }
}
