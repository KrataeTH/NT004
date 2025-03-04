<?php

$client_id = "U97a61a586643b348e67d1f52a0ebbe69";
$client_secret = "5a4cfdc8e9bd2cb2f5fc5bb025efa2d1";
$redirect_uri = " https://4a35-125-26-7-18.ngrok-free.app/NT004/line_bot/callback.php";
$line_bot_token = "B8AzbBkCr10BHDCpTxeSPBRiiPefrRjwkdY0b6ChBiTaxMk99Jd3QjcyVwXsC7Nv+ErF90h0GAEaGsIdMo/eh0Hb+zcIMkSG43ItQgp7sX3FyLCIMD1yl+4CMBrGnlZW5KcijlCTZcjg5GzJWWVoYwdB04t89/1O/w1cDnyilFU="; // Access Token ของ LINE Bot

if (!isset($_GET['code'])) {
    die("No code received.");
}

$code = $_GET['code'];

// ส่ง Request ไปแลก Access Token
$token_url = "https://api.line.me/oauth2/v2.1/token";
$data = [
    "grant_type" => "authorization_code",
    "code" => $code,
    "redirect_uri" => $redirect_uri,
    "client_id" => $client_id,
    "client_secret" => $client_secret
];

$options = [
    "http" => [
        "header"  => "Content-Type: application/x-www-form-urlencoded\r\n",
        "method"  => "POST",
        "content" => http_build_query($data)
    ]
];

$context = stream_context_create($options);
$response = file_get_contents($token_url, false, $context);
$res = json_decode($response, true);

$access_token = $res['access_token'];

// ดึงข้อมูลโปรไฟล์ผู้ใช้
$profile_url = "https://api.line.me/v2/profile";
$options = ["http" => ["header" => "Authorization: Bearer " . $access_token]];
$context = stream_context_create($options);
$profile = json_decode(file_get_contents($profile_url, false, $context), true);

// ส่งข้อความทักทายไปที่ LINE Bot
$user_id = $profile['userId'];
$user_name = $profile['displayName'];

sendMessage($user_id, "สวัสดีคุณ " . $user_name, $line_bot_token);
sendMenu($user_id, $line_bot_token);

function sendMessage($userId, $message, $token) {
    $url = "https://api.line.me/v2/bot/message/push";
    $data = ["to" => $userId, "messages" => [["type" => "text", "text" => $message]]];

    $headers = ["Content-Type: application/json", "Authorization: Bearer " . $token];
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

function sendMenu($userId, $token) {
    $menu = [
        "type" => "template",
        "altText" => "กรุณาเลือกเมนู",
        "template" => [
            "type" => "buttons",
            "text" => "กรุณาเลือกเมนู",
            "actions" => [
                ["type" => "message", "label" => "📞 Contact Customer", "text" => "Contact Customer"],
                ["type" => "message", "label" => "📜 พิมพ์รหัสบิล", "text" => "พิมพ์รหัสบิล"]
            ]
        ]
    ];
    
    $data = ["to" => $userId, "messages" => [$menu]];
    $headers = ["Content-Type: application/json", "Authorization: Bearer " . $token];

    $ch = curl_init("https://api.line.me/v2/bot/message/push");
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_exec($ch);
    curl_close($ch);
}

?>