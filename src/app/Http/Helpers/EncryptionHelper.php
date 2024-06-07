<?php

namespace App\Http\Helpers;
use Illuminate\Support\Str;

class EncryptionHelper
{

    public static function generateKey(int $length, string $prefix = null): string
    {
        $timestamp = now()->timestamp;
        $randomString = Str::random($length);
        $secretKey = (empty($prefix)? 'sk_' : $prefix) . $timestamp . $randomString;

        return $secretKey;
    }
}
