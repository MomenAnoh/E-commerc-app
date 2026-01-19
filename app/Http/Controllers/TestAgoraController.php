<?php

namespace App\Http\Controllers;

use App\Services\Agora\AgoraService;
use Illuminate\Http\Request;

class TestAgoraController extends Controller
{
    protected $agoraService;
    public function __construct(AgoraService $agoraService)
    {
        $this->agoraService = $agoraService;
    }
   public function getAgoraToken(Request $request)
   {

    // $request->validate([
    //     'channel_name' => 'required|string',
    //     'uid' => 'nullable|integer',
    // ]);
        $channelName = 'test_channel';
        return response()->json([
            'appId' => env('AGORA_APP_ID'),
            'channel' =>$channelName,
            'uid' => $request->uid ?? 0,
            'token' => $this->agoraService->generateToken(
                $channelName,
                $request->uid ?? 0
            ),
        ]);
   }
}
