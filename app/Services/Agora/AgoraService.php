<?php

namespace App\Services\Agora;

use Carbon\Carbon;
use App\Services\Agora\RtcTokenBuilder;

class AgoraService
{

    public static function generateToken(string $channelName, int $uid = 0): string
    {
        $appId = env('AGORA_APP_ID');
        $appCertificate = env('AGORA_APP_CERTIFICATE');

        $expireTime = 360000;
        $currentTs = Carbon::now()->timestamp;
        $expireTs = $currentTs + $expireTime;

        return RtcTokenBuilder::buildTokenWithUid(
            $appId,
            $appCertificate,
            $channelName,
            $uid,
            RtcTokenBuilder::RolePublisher,
            $expireTs
        );
    }
}
