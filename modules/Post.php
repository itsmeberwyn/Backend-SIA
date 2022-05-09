<?php
class Post
{
    protected $pdo, $gm;

    public function __construct(\PDO $pdo)
    {
        $this->gm = new GlobalMethods($pdo);
        $this->pdo = $pdo;
    }

    public function testPost($data)
    {
        return $this->gm->response($data, "success", "test", 200);
    }

    public function createNews($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to save data";

        $newsInfo = json_decode($data['news_info']);
        $newsDetails = json_decode($data['news_details']);


        $imageInfo = $this->gm->uploadImage('news', $_FILES);

        if ($imageInfo['status'] == 'success') {
            $newsDetails->news_details_image = $imageInfo['filename'];
        }

        // return ['news_info' => $newsInfo, 'news_details' => $newsDetails];

        try {
            $this->pdo->beginTransaction();

            $newsInfoSQL = "INSERT INTO news_table(news_title, news_description) VALUES (?, ?)";
            $studentsSQL = $this->pdo->prepare($newsInfoSQL);
            $studentsSQL->execute([$newsInfo->news_title, $newsInfo->news_description]);
            $LAST_ID = $this->pdo->lastInsertId();

            $newsDetailSQL = "INSERT INTO news_details_table(news_id_n, news_details_image, news_details_organizer, news_details_type, news_details_category) VALUES (?, ?, ?, ?, ?)";
            $newsDetailSQL = $this->pdo->prepare($newsDetailSQL);
            $newsDetailSQL->execute([$LAST_ID, $newsDetails->news_details_image, $newsDetails->news_details_organizer, $newsDetails->news_details_type, $newsDetails->news_details_category]);

            $payload = ['newsInfo' => $newsInfo, 'newsDetails' => $newsDetails];

            $this->pdo->commit();

            $code = 200;
            $remarks = "success";
            $message = "Successfully created";
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            unlink($imageInfo['targetpath']);
            $this->pdo->rollback();
            throw $e;
        }
        return $this->gm->response($payload, $remarks, $message, $code);
    }

    public function adminRegister($data)
    {
        $sql = "SELECT * FROM admins_table WHERE admin_email = '$data->admin_email'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            return array("conflict" => "Username already registered");
        } else {
            $sql = "INSERT INTO admins_table(admin_firstname, admin_lastname, admin_middlename, admin_gender, admin_email, password) VALUES (?,?,?,?,?,?)";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $data->admin_firstname,
                $data->admin_lastname,
                $data->admin_middlename,
                $data->admin_gender,
                $data->admin_email,
                $data->admin_password,
            ]);

            $count = $sql->rowCount();
            $LAST_ID = $this->pdo->lastInsertId();

            if ($count) {
                return array(
                    "data" => array(
                        "id" => $LAST_ID,
                        "firstname" => $data->admin_firstname,
                        "lastname" => $data->admin_lastname,
                        "lastname" => $data->admin_middlename,
                        "lastname" => $data->admin_gender,
                        "email" => $data->admin_email,
                    ),
                    "success" => true
                );
            } else {
                return array("data" => array("message" => "No Record inserted"), "success" => false);
            }
        }
    }

    public function adminLogin($data)
    {
        $sql = "SELECT * FROM admins_table WHERE admin_email = ? AND password = ?";
        $sql = $this->pdo->prepare($sql);
        $sql->execute([
            $data->admin_email,
            $data->admin_password,
        ]);

        $res = $sql->fetch(PDO::FETCH_ASSOC);
        $count = $sql->rowCount();

        if ($count) {
            return array("data" => array(
                "studnum" => $res['admin_id'],
                "firstname" => $res['admin_firstname'],
                "lastname" => $res['admin_lastname'],
            ), "success" => true);
        } else {
            return array("data" => array("message" => "Incorrect username or password"), "success" => false);
        }
    }

    //romeo part
    public function joinEvent()
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to save data";
    }


    public function createEvent($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to save data";

        $eventInfo = $data->event_info;
        $eventDetails = $data->event_detail;

        try {
            $this->pdo->beginTransaction();
            $eventInfoSQL = "INSERT INTO events_table(event_title, event_description, event_location) VALUES (?, ?, ?)";
            $studentsSQL = $this->pdo->prepare($eventInfoSQL);
            $studentsSQL->execute([$eventInfo->event_title, $eventInfo->event_description, $eventInfo->event_location]);
            $LAST_ID = $this->pdo->lastInsertId();

            $eventDetailSql = "INSERT INTO events_details_table(event_id_e, event_detail_image, event_detail_organizer, event_detail_type, event_detail_category) VALUES (?, ?, ?, ?, ?)";
            $eventDetailSql = $this->pdo->prepare($eventDetailSql);
            $eventDetailSql->execute([$LAST_ID, $eventDetails->event_detail_image, $eventDetails->event_detail_organizer, $eventDetails->event_detail_type, $eventDetails->event_detail_category]);

            $payload = $LAST_ID;

            $this->pdo->commit();

            $code = 200;
            $remarks = "success";
            $message = "Successfully created";
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            $this->pdo->rollback();
            throw $e;
        }
        return $this->gm->response($payload, $remarks, $message, $code);
    }

    //mel mark part 
    public function clientProfile($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to retrieve data";

        $sql = "SELECT * FROM users_table";
        if ($data != null) {
            $sql .= " WHERE user_studnum=$data->user_studnum";
        }

        $res = $this->gm->retrieve($sql);

        if ($res['code'] == 200) {
            $payload = $res['data'];
            $code = 200;
            $remarks = "success";
            $message = "Successfully retrieved requested records";
        }
        return $this->gm->response($payload, $remarks, $message, $code);
    }

    public function adminProfile($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to retrieve data";

        $sql = "SELECT * FROM admins_table";
        if ($data != null) {
            $sql .= " WHERE admin_id=$data->admin_id";
        }

        $res = $this->gm->retrieve($sql);

        if ($res['code'] == 200) {
            $payload = $res['data'];
            $code = 200;
            $remarks = "success";
            $message = "Successfully retrieved requested records";
        }
        return $this->gm->response($payload, $remarks, $message, $code);
    }

    public function clientEventHistory($data)
    {

        $sqlRegister = "SELECT 
           events_table.event_startdatetime , events_table.event_enddatetime, events_table.event_id,
           registration_table.event_id_r,registration_table.user_studnum_r,registration_table.registration_created_at

           FROM registration_table INNER JOIN events_table 
           ON registration_table.event_id_r = events_table.event_id
           WHERE user_studnum_r = '$data->user_studnum_r' ";



        if ($res = $this->pdo->query($sqlRegister)->fetchAll()) {
            return array("data" => array(

                "event_id_r" => $res[0]['event_id_r'],
                "user_studnum_r" => $res[0]['user_studnum_r'],
                "registration_created_at" => $res[0]['registration_created_at'],

                "event_id" => $res[0]['event_id'],
                "event_startdatetime" => $res[0]['event_startdatetime'],
                "event_enddatetime" => $res[0]['event_enddatetime']

            ), "success" => true);
            // $currentDate = date("Y-d-m h:m:s");
            // if ($currentDate <=  $res[0]['event_startdatetime']) {
            //     return "current";
            // } else {
            //     return "history";
            // }
        } else {
            return array("data" => array("message" => "Incorrect "), "success" => false);
        }
    }
}
