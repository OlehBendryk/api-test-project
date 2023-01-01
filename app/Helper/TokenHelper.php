<?php

namespace App\Helper;


use Carbon\Carbon;
use Illuminate\Support\Arr;


class TokenHelper
{

    public function getRegistrationToken(): string
    {
        $token = [
            'type' => 'registration',
            'expired_at' => Carbon::now()->addSeconds(40),
        ];

        return encrypt($token);
    }

    public function decryptToken(string $string)
    {
        $token = decrypt($string);

        if (!Arr::has($token, ['type', 'expired_at'])) {
            return false;
        }

        if (Carbon::parse($token['expired_at'])->isPast()) {
            return false;
        }

        return true;
    }

}
