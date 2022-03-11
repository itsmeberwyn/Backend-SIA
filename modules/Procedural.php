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
