<?php
function errMsg($errcode)
{
    switch ($errcode) {
        case 400:
            $msg = "Bad Request. Please contact the systems administrator.";
            break;
        case 401:
            $msg = "Unauthorized user.";
            break;
        case 403:
            $msg = "Forbidden. Please contact the systems administrator.";
            break;
        default:
            $msg = "Request Not Found.";
            break;
    }
    http_response_code($errcode);
    return json_encode(array("status" => array("remarks" => "failed", "message" => $msg), "timestamp" => date_create()));
}

function generateRandomString($length = 64)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function generate_jwt($headers, $payload, $secret = SECRET)
{
    $headers_encoded = base64url_encode(json_encode($headers));
    $payload_encoded = base64url_encode(json_encode($payload));

    $signature = hash_hmac('SHA256', "$headers_encoded.$payload_encoded", $secret, true);
    $signature_encoded = base64url_encode($signature);

    $jwt = "$headers_encoded.$payload_encoded.$signature_encoded";

    return $jwt;
}

function base64url_encode($str)
{
    return rtrim(strtr(base64_encode($str), '+/', '-_'), '=');
}

function isAuthorized($data)
{
    $token = $data;
    $tokenParts = explode('.', $token);
    $header = base64_decode($tokenParts[0]);
    $payload = base64_decode($tokenParts[1]);
    $signature_provided = $tokenParts[2];

    $expiration = json_decode($payload)->exp;
    $is_token_expired = ($expiration - time()) < 0;

    $base64_url_header = base64url_encode($header);
    $base64_url_payload = base64url_encode($payload);

    $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, SECRET, true);
    $base64_url_signature = base64url_encode($signature);

    $is_signature_valid = ($base64_url_signature === $signature_provided);

    if ($is_token_expired || !$is_signature_valid) {
        return false;
    } else {
        return true;
    }
}
