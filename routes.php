<?php
require_once("./config/Config.php");
require_once("./modules/Procedural.php");
require_once("./modules/Global.php");
require_once("./modules/Get.php");
require_once("./modules/Post.php");
require_once("./modules/Patch.php");
require_once("./modules/Remove.php");


$db = new Connection();
$pdo = $db->connect();
$get = new Get($pdo);
$post = new Post($pdo);
$patch = new Patch($pdo);
$remove = new Remove($pdo);


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

                // news CRUD
            case 'createnews':
                echo json_encode($post->createPost($d));
                break;
            case 'getnews':
                echo json_encode($get->getNews());
                break;
            case 'updatenews':
                echo json_encode($patch->updateNews($d));
                break;
            case 'removenews':
                echo json_encode($remove->removeNews($d));
                break;
            default:
                echo errmsg(400);
                break;
        }
        break;
    default:
        echo errmsg(403);
}
