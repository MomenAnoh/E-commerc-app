<?php

namespace App\Services\Front;
class AgoraService
{

    public function getAgoraCredentials()
    {
        return [
            'done by' => 'agora service',
            'agora_app_id' => env('AGORA_APP_ID'),
            'agora_app_certificate' => env('AGORA_APP_CERTIFICATE'),
        ];
    }
}
