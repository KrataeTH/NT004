<?php

$client_id = "U97a61a586643b348e67d1f52a0ebbe69";
$redirect_uri = "https://09e8-125-26-7-18.ngrok-free.app/NT005/line_bot/callback.php"; // Callback เมื่อ Login เสร็จ
$state = uniqid(); // ใช้ตรวจสอบว่า Request มาจากบอทจริง

// URL สำหรับให้ผู้ใช้ Login ผ่าน LINE
$login_url = "https://access.line.me/oauth2/v2.1/authorize?response_type=code"
    . "&client_id=" . $client_id
    . "&redirect_uri=" . urlencode($redirect_uri)
    . "&state=" . $state
    . "&scope=profile%20openid";

// Redirect ไปยัง LINE Login
header("Location: " . $login_url);
exit();

?>