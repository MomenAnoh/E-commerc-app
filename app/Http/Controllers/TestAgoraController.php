<?php

namespace App\Http\Controllers;

use App\Services\Front\AgoraService;
use Illuminate\Http\Request;

class TestAgoraController extends Controller
{
    protected $agoraAppId;
    protected $agoraAppCertificate;
    protected $agoraService;
    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;

    }
    public function getAgoraToken()
    {

           return $this->agoraService->getAgoraCredentials();
    }
}
