<?php
require_once("./config/Config.php");
require_once("./modules/Procedural.php");
require_once("./modules/Global.php");
require_once("./modules/Get.php");
require_once("./modules/Post.php");
require_once("./modules/Patch.php");
require_once("./modules/Remove.php");
require_once("./modules/AdminAuth.php");
require_once("./modules/StudentAuth.php");


$db = new Connection();
$pdo = $db->connect();
$get = new Get($pdo);
$post = new Post($pdo);
$patch = new Patch($pdo);
$remove = new Remove($pdo);
$adminAuth = new Adminauth($pdo);
$studentAuth = new Studentauth($pdo);


if (isset($_REQUEST['request'])) {
    $req = explode('/', rtrim($_REQUEST['request'], '/'));
} else {
    $req = array("errorcatcher");
}

switch ($_SERVER['REQUEST_METHOD']) {
    case 'POST':
        $d = json_decode(file_get_contents("php://input"));
        if (isset(getallheaders()["Authorization"])) {
            $jwt = substr(getallheaders()["Authorization"], 7);

            if (isAuthorized($jwt)) {

                switch ($req[0]) {
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
                    case 'geteventtoday':
                        echo json_encode($get->getEventToday());
                        break;
                    case 'geteventfuture':
                        echo json_encode($get->getEventFuture());
                        break;
                    case 'geteventfinished':
                        echo json_encode($get->getEventFinished());
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

                    case 'user-edit-profile':
                        echo json_encode($patch->editUserProfile($d));
                        break;
                    case 'user-change-password':
                        echo json_encode($patch->changePassword($d));
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

                        //student list -> mel
                    case 'get-student':
                        echo json_encode($get->getStudent($d));
                        break;
                    case 'assignStudent':
                        echo json_encode($patch->assignStudent($d));
                        break;

                    default:
                        header("HTTP/1.1 200 OK");
                        return;
                        break;
                }
                return;
            } else {
                echo errmsg(401);
                return;
            }
        }
        switch ($req[0]) {
            case 'studentrefreshtoken':
                echo json_encode($studentAuth->refreshToken($d));
                break;
            case 'user-register':
                echo json_encode($studentAuth->userRegister($d));
                break;
            case 'user-login':
                echo json_encode($studentAuth->userLogin($d));
                break;
            case 'student-logout':
                echo json_encode($studentAuth->logout($d));
                break;

            case 'refreshtoken':
                echo json_encode($adminAuth->refreshToken($d));
                break;
            case 'admin-register':
                echo json_encode($adminAuth->adminRegister($d));
                break;
            case 'admin-login':
                echo json_encode($adminAuth->adminLogin($d));
                break;
            case 'admin-logout':
                echo json_encode($adminAuth->logout($d));
                break;

            default:
                echo errmsg(401);
                break;
        }

        break;

    case 'OPTIONS':
        echo errmsg(200);
        break;

    default:
        echo errmsg(403);
}
