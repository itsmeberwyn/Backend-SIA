<?php
require_once("./config/Config.php");
require_once("./modules/Procedural.php");
require_once("./modules/Global.php");
require_once("./modules/Get.php");
require_once("./modules/Post.php");


$db = new Connection();
$pdo = $db->connect();
$get = new Get($pdo);
$post = new Post($pdo);


if (isset($_REQUEST['request'])) {
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
} else {
    $req = array("errorcatcher");
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $d = json_decode(file_get_contents("php://input"));
        switch ($req[0]) {
            case 'gettesting':
                if (sizeof($req) > 1) {
                    // http://localhost/backend-sia/testing/test
                    echo json_encode($get->testGet($req[1]));
                } else {
                    echo json_encode($get->testGet(null));
                }
                break;
            case 'posttesting':
                echo json_encode($post->testPost($d));
                break;
            default:
                echo errmsg(400);
                break;
        }
        break;
    default:
        echo errmsg(403);
}
