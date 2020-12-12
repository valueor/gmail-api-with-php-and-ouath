<?php
$client_id = '';
$client_secret = '';
$api_key = '';
if (isset($_GET['code'])) {
    // try to get an access token
    $code = $_GET['code'];
    $url = 'https://accounts.google.com/o/oauth2/token';
    $params = array(
        "code" => $code,
        "client_id" => $client_id,
        "client_secret" => $client_secret,
        "redirect_uri" => 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"],
        "grant_type" => "authorization_code"
    );


    $ch = curl_init();
    curl_setopt($ch, constant("CURLOPT_" . 'URL'), $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
    curl_setopt($ch, constant("CURLOPT_" . 'POST'), true);
    curl_setopt($ch, constant("CURLOPT_" . 'POSTFIELDS'), $params);
    $token_result = curl_exec($ch);
    $info = curl_getinfo($ch);
    curl_close($ch);
    if ($info['http_code'] === 200) {
        header('Content-Type: ' . $info['content_type']);

        # send mail
        $token_result = json_decode($token_result, true);
        $email = "";
        $from_email = "";

        $headers   = array();
        $headers[] = "To: {$email}";
        $headers[] = "From: Gmail API <{$from_email}>";
        $headers[] = "Subject: Hello by gmail";
        $headers[] = "X-Mailer: PHP/".phpversion();
        $headers[] = "MIME-Version: 1.0";
        $headers[] = "Content-type: text/html; charset=UTF-8";

        $output   = array();
        $output[] = "--".md5(time());
        $output[] = "Content-type: text/html; charset=\"utf-8\"";
        $output[] = "Content-Transfer-Encoding: 8bit";
        $output[] = "";
        $output[] = "안녕하세요? 저는 개발자입니다.";
        $output[] = "";

        $raw = base64_encode(implode("\n", $headers) . implode("\n", $output));

        $url = "https://gmail.googleapis.com/gmail/v1/users/me/messages/send?key={$api_key}";
        $ch = curl_init();
        $headers = [
            "Authorization: Bearer {$token_result['access_token']}",
            "Accept: application/json",
            "Content-Type: application/json",
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array('raw' => $raw,)));
        curl_setopt($ch, CURLOPT_POST, true);

        $response = curl_exec($ch);
        curl_close($ch);

        echo '<pre>';
        var_dump($token_result);
        var_dump(json_decode($response, true));
        echo '</pre>';

    } else {
        echo 'An error happened';
    }
} else {

    $url = "https://accounts.google.com/o/oauth2/v2/auth";
    $params = array(
        "scope" => 'https://mail.google.com/',
        "access_type" => "offline",
        "response_type" => "code",
        "redirect_uri" => 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER["PHP_SELF"],
        "client_id" => $client_id,
    );

    $request_to = $url . '?' . http_build_query($params);
    header("Location: " . $request_to);
}
