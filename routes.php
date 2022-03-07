<?php
// require_once("./config/Config.php");

// $db = new Connection();
// $pdo = $db->connect();

if (isset($_REQUEST['request'])) {
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
} else {
    $req = array("errorcatcher");
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $d = json_decode(file_get_contents("php://input"));
        switch ($req[0]) {
            case 'testing':
                echo "testing..";
                break;
            default:
                // echo errmsg(400);
                break;
        }
        break;
    default:
        // echo errmsg(403);
}
