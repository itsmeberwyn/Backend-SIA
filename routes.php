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
                echo json_encode($post->createNews($_POST));
                break;

            case 'getnews':
                echo json_encode($get->getNews());
                break;

            case 'updatenews':
                echo json_encode($patch->updateNews($_POST));
                break;
            case 'removenews':
                echo json_encode($remove->removeNews($d));
                break;

                //create events
            case 'createevent':
                echo json_encode($post->createEvent($_POST));
                break;
            case 'getevent':
                echo json_encode($get->getEvent());
                break;
            case 'updateevent':
                echo json_encode($patch->updateEvent($_POST));
                break;
            case 'removeevent':
                echo json_encode($remove->removeEvent($d));
                break;
            case 'joinevent':
                echo json_encode($post->joinEvent($d));
                break;
            case 'userevent':
                echo json_encode($get->getUserEvent($d));
                break;
            case 'cancelregistration':
                echo json_encode($remove->cancelRegistration($d));
                break;

                //client Login 
            case 'admin-register':
                echo json_encode($post->adminRegister($d));
                break;
            case 'admin-login':
                echo json_encode($post->adminLogin($d));
                break;

                //Profile 
            case 'clientProfile':
                echo json_encode($post->clientProfile($d));
                break;
            case 'adminProfile':
                echo json_encode($post->adminProfile($d));
                break;
            case 'clientEventHistory':
                echo json_encode($post->clientEventHistory($d));
                break;
            case 'adminEventHistory':
                echo json_encode($get->adminEventHistory($d));
                break;

            default:
                echo errmsg(400);
                break;
        }
        break;
    default:
        echo errmsg(403);
}
