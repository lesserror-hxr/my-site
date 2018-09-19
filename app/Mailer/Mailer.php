<?php

namespace App\Mailer;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class Mailer
{
    protected $url = 'http://api.sendcloud.net/apiv2/mail/sendtemplate';

    public function sendTo($user,$subject,$view,$data = [])
    {
        $vars = json_encode(['to' => [$user->email], 'sub' => $data]);
        $param = [
            'apiUser'            => env('SENDCLOUD_API_USER'), # 使用api_user和api_key进行验证
            'apiKey'             => env('SENDCLOUD_API_KEY'),
            'from'               => config('mail')['from']['address'], # 发信人，用正确邮件地址替代
            'fromName'           => config('mail')['from']['name'],
            'xsmtpapi'           => $vars,
            'subject'            => $subject,
            'templateInvokeName' => $view,
            'respEmailId'        => 'true'
        ];
        $sendData = http_build_query($param);
        $options = [
            'http' => [
                'method'  => 'POST',
                'header'  => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $sendData
            ]];
        $context = stream_context_create($options);

        dd("黄向荣");
        return file_get_contents($this->url, FILE_TEXT, $context);

    }
}