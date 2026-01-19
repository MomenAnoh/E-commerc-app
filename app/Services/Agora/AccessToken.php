<?php

namespace App\Services\Agora;

use DateTime;
use DateTimeZone;

class Message
{
    public $salt;
    public $ts;
    public $privileges;

    public function __construct()
    {
        $this->salt = rand(0, 100000);

        $date = new DateTime("now", new DateTimeZone('UTC'));
        $this->ts = $date->getTimestamp() + 24 * 3600;

        $this->privileges = [];
    }

    public function packContent()
    {
        $buffer = unpack("C*", pack("V", $this->salt));
        $buffer = array_merge($buffer, unpack("C*", pack("V", $this->ts)));
        $buffer = array_merge($buffer, unpack("C*", pack("v", count($this->privileges))));

        foreach ($this->privileges as $key => $value) {
            $buffer = array_merge($buffer, unpack("C*", pack("v", $key)));
            $buffer = array_merge($buffer, unpack("C*", pack("V", $value)));
        }
        return $buffer;
    }

    public function unpackContent($msg)
    {
        $pos = 0;
        $this->salt = unpack("V", substr($msg, $pos, 4))[1];
        $pos += 4;
        $this->ts = unpack("V", substr($msg, $pos, 4))[1];
        $pos += 4;
        $size = unpack("v", substr($msg, $pos, 2))[1];
        $pos += 2;

        $this->privileges = [];
        for ($i = 0; $i < $size; $i++) {
            $key = unpack("v", substr($msg, $pos, 2))[1];
            $pos += 2;
            $value = unpack("V", substr($msg, $pos, 4))[1];
            $pos += 4;
            $this->privileges[$key] = $value;
        }
    }
}

class AccessToken
{
    const Privileges = [
        "kJoinChannel" => 1,
        "kPublishAudioStream" => 2,
        "kPublishVideoStream" => 3,
        "kPublishDataStream" => 4,
        "kRtmLogin" => 1000,
    ];

    public $appID, $appCertificate, $channelName, $uid;
    public $message;

    public function __construct()
    {
        $this->message = new Message();
    }

    public static function init($appID, $appCertificate, $channelName, $uid)
    {
        $token = new self();

        if (!$token->isNonEmpty("appID", $appID) ||
            !$token->isNonEmpty("appCertificate", $appCertificate) ||
            !$token->isNonEmpty("channelName", $channelName)) {
            return null;
        }

        $token->appID = $appID;
        $token->appCertificate = $appCertificate;
        $token->channelName = $channelName;
        $token->uid = $uid == 0 ? "" : (string) $uid;

        return $token;
    }

    public function addPrivilege($key, $expireTimestamp)
    {
        $this->message->privileges[$key] = $expireTimestamp;
        return $this;
    }

    private function isNonEmpty($name, $value)
    {
        return is_string($value) && $value !== "";
    }

    public function build()
    {
        $msg = $this->message->packContent();
        $val = array_merge(
            unpack("C*", $this->appID),
            unpack("C*", $this->channelName),
            unpack("C*", $this->uid),
            $msg
        );

        $sig = hash_hmac('sha256', implode(array_map("chr", $val)), $this->appCertificate, true);

        $crcChannel = crc32($this->channelName) & 0xffffffff;
        $crcUid = crc32($this->uid) & 0xffffffff;

        $content = array_merge(
            unpack("C*", packString($sig)),
            unpack("C*", pack("V", $crcChannel)),
            unpack("C*", pack("V", $crcUid)),
            unpack("C*", pack("v", count($msg))),
            $msg
        );

        return "006" . $this->appID . base64_encode(implode(array_map("chr", $content)));
    }
}

function packString($value)
{
    return pack("v", strlen($value)) . $value;
}

