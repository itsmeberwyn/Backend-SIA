<?php
class Get
{
    protected $pdo, $gm;

    public function __construct(\PDO $pdo)
    {
        $this->gm = new GlobalMethods($pdo);
        $this->pdo = $pdo;
    }

    public function testGet($data)
    {
        return $this->gm->response($data, "success", "test", 200);
    }

    public function getNews()
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        try {
            $sql = "SELECT * FROM news_table, news_details_table WHERE news_table.news_id = news_details_table.news_id_n AND news_details_table.deleted_at IS NULL";
            $res = $this->gm->retrieve($sql);

            // return $res['data'];
            // return $res['data'][0]['news_id'];

            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    //Romeo    
    public function getEventToday($data)
    {
        $withCategory = true;
        if ($data === '') {
            $withCategory = false;
        }
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        $currentDate = date('Y-m-d');

        try {
            if ($withCategory) {
                $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) = '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL AND event_details_table.event_detail_category = '$data->category'";
            } else {
                $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) = '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL";
            }
            $res = $this->gm->retrieve($sql);
            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    public function getEventFuture($data)
    {
        $withCategory = true;
        if ($data === '') {
            $withCategory = false;
        }
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        $currentDate = date('Y-m-d');

        try {
            if ($withCategory) {
                $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) > '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL AND event_details_table.event_detail_category = '$data->category'";
            } else {
                $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) > '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL";
            }
            $res = $this->gm->retrieve($sql);
            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    public function getEventFinished($data)
    {
        $withCategory = true;
        if ($data === '') {
            $withCategory = false;
        }

        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        $currentDate = date('Y-m-d');

        try {
            if ($withCategory) {
                $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) < '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL AND event_details_table.event_detail_category = '$data->category'";
            } else {
                $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) < '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL";
            }
            $res = $this->gm->retrieve($sql);
            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    public function isJoined($data)
    {
        $payload = [];
        $code = 203;
        $remarks = "failed";
        $message = "Unable to fetch data";

        $sql = "SELECT * FROM registration_table WHERE event_id_r = ? AND user_studnum_r = ? AND cancelled_at IS NULL";
        $sql = $this->pdo->prepare($sql);
        $sql->execute([
            $data->event_id,
            $data->student_num,
        ]);

        $count = $sql->rowCount();

        if ($count) {
            $code = 200;
            $remarks = "success";
            $message = "Found!";
            $payload = ["data" => $count];
        }
        return $this->gm->response($payload, $remarks, $message, $code);
    }

    public function getUserEvent($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        try {
            $sql = "SELECT registration_table.*, users_table.user_studnum, users_table.user_department, users_table.user_block, users_table.user_firstname, users_table.user_lastname, users_table.user_middlename, users_table.user_email, events_table.*, event_details_table.* FROM registration_table INNER JOIN users_table ON registration_table.user_studnum_r=users_table.user_studnum INNER JOIN events_table ON registration_table.event_id_r=events_table.event_id INNER JOIN event_details_table ON registration_table.event_id_r=event_details_table.event_id_e WHERE users_table.user_studnum = $data->user_studnum AND event_details_table.deleted_at IS NULL AND registration_table.cancelled_at IS NULL AND events_table.event_enddatetime > NOW()";

            $res = $this->gm->retrieve($sql);

            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    public function getUserFinishedEvent($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        try {
            $sql = "SELECT registration_table.*, users_table.user_studnum, users_table.user_department, users_table.user_block, users_table.user_firstname, users_table.user_lastname, users_table.user_middlename, users_table.user_email, events_table.*, event_details_table.* FROM registration_table INNER JOIN users_table ON registration_table.user_studnum_r=users_table.user_studnum INNER JOIN events_table ON registration_table.event_id_r=events_table.event_id INNER JOIN event_details_table ON registration_table.event_id_r=event_details_table.event_id_e WHERE users_table.user_studnum = $data->user_studnum AND event_details_table.deleted_at IS NULL AND registration_table.cancelled_at IS NULL AND events_table.event_enddatetime < NOW()";

            $res = $this->gm->retrieve($sql);

            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    public function adminEventHistory()
    {

        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to save data";

        try {
            $sql = "SELECT * FROM events_table ";
            $res = $this->gm->retrieve($sql);

            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    //mel mark pogi
    public function getStudent()
    {

        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to get data";

        try {
            $sql = "SELECT * FROM users_table ";
            $res = $this->gm->retrieve($sql);

            if ($res['code'] == 200) {
                $payload = $res['data'];
                $code = 200;
                $remarks = "success";
                $message = "Successfully retrieved requested records";
            }
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
            return $this->gm->response($payload, $remarks, $message, $code);
        }
    }

    public function getStudentByCourse($data)
    {
        $sql = "SELECT * FROM users_table WHERE user_course = '$data->user_course'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            $payload = array();
            for ($i = 0; $i < sizeof($res); $i++) {
                array_push($payload, [
                    "user_studnum" => $res[$i]['user_studnum'],
                    "user_firstname" => $res[$i]['user_firstname'],
                    "user_middlename" => $res[$i]['user_middlename'],
                    "user_lastname" => $res[$i]['user_lastname'],
                    "user_department" => $res[$i]['user_department'],
                    "user_yearlevel" => $res[$i]['user_yearlevel'],
                    "user_priviledge" => $res[$i]['user_priviledge'],
                    "user_course" => $res[$i]['user_course'],
                ]);
            }
            return ["data" => $payload, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }

    public function getStudentByDepartment($data)
    {
        $sql = "SELECT * FROM users_table WHERE user_department = '$data->user_department'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            $payload = array();
            for ($i = 0; $i < sizeof($res); $i++) {
                array_push($payload, [
                    "user_studnum" => $res[$i]['user_studnum'],
                    "user_firstname" => $res[$i]['user_firstname'],
                    "user_middlename" => $res[$i]['user_middlename'],
                    "user_lastname" => $res[$i]['user_lastname'],
                    "user_department" => $res[$i]['user_department'],
                    "user_yearlevel" => $res[$i]['user_yearlevel'],
                    "user_priviledge" => $res[$i]['user_priviledge'],
                    "user_course" => $res[$i]['user_course'],
                ]);
            }
            return ["data" => $payload, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }

    public function getPriviledeStudent()
    {
        $sql = "SELECT * FROM users_table WHERE user_priviledge = '1'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            $payload = array();
            for ($i = 0; $i < sizeof($res); $i++) {
                array_push($payload, [
                    "user_studnum" => $res[$i]['user_studnum'],
                    "user_firstname" => $res[$i]['user_firstname'],
                    "user_middlename" => $res[$i]['user_middlename'],
                    "user_lastname" => $res[$i]['user_lastname'],
                    "user_department" => $res[$i]['user_department'],
                    "user_yearlevel" => $res[$i]['user_yearlevel'],
                    "user_priviledge" => $res[$i]['user_priviledge'],
                    "user_course" => $res[$i]['user_course'],
                ]);
            }
            return ["data" => $payload, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }

    public function getPriviledeStudentByDepartment($data)
    {
        $sql = "SELECT * FROM users_table WHERE user_priviledge = '1' AND user_department = '$data->user_department'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            $payload = array();
            for ($i = 0; $i < sizeof($res); $i++) {
                array_push($payload, [
                    "user_studnum" => $res[$i]['user_studnum'],
                    "user_firstname" => $res[$i]['user_firstname'],
                    "user_middlename" => $res[$i]['user_middlename'],
                    "user_lastname" => $res[$i]['user_lastname'],
                    "user_department" => $res[$i]['user_department'],
                    "user_yearlevel" => $res[$i]['user_yearlevel'],
                    "user_priviledge" => $res[$i]['user_priviledge'],
                    "user_course" => $res[$i]['user_course'],
                ]);
            }
            return ["data" => $payload, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }

    public function getPriviledeStudentByCourse($data)
    {
        $sql = "SELECT * FROM users_table WHERE user_priviledge = '1' AND user_department = '$data->user_department' AND user_course = '$data->user_course'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            $payload = array();
            for ($i = 0; $i < sizeof($res); $i++) {
                array_push($payload, [
                    "user_studnum" => $res[$i]['user_studnum'],
                    "user_firstname" => $res[$i]['user_firstname'],
                    "user_middlename" => $res[$i]['user_middlename'],
                    "user_lastname" => $res[$i]['user_lastname'],
                    "user_department" => $res[$i]['user_department'],
                    "user_yearlevel" => $res[$i]['user_yearlevel'],
                    "user_priviledge" => $res[$i]['user_priviledge'],
                    "user_course" => $res[$i]['user_course'],
                ]);
            }
            return ["data" => $payload, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }

    public function searchStudent($data)
    {
        $sql = "SELECT * FROM users_table WHERE user_studnum LIKE '%$data->keyword%' OR user_firstname LIKE '%$data->keyword%' OR user_lastname LIKE '%$data->keyword%' OR user_middlename LIKE '%$data->keyword%'";

        if ($res = $this->pdo->query($sql)->fetchAll()) {
            $payload = array();
            for ($i = 0; $i < sizeof($res); $i++) {
                array_push($payload, [
                    "user_studnum" => $res[$i]['user_studnum'],
                    "user_firstname" => $res[$i]['user_firstname'],
                    "user_middlename" => $res[$i]['user_middlename'],
                    "user_lastname" => $res[$i]['user_lastname'],
                    "user_department" => $res[$i]['user_department'],
                    "user_yearlevel" => $res[$i]['user_yearlevel'],
                    "user_priviledge" => $res[$i]['user_priviledge'],
                    "user_course" => $res[$i]['user_course'],
                ]);
            }
            return ["data" => $payload, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }

    public function checkParticipants($data)
    {
        $sql = "SELECT COUNT(*) as count FROM registration_table WHERE event_id_r = $data->event_id";

        if ($res = $this->pdo->query($sql)->fetchAll()) {
            return ["data" => $res, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }

    public function participantsList($data)
    {
        $sql = "SELECT registration_table.*, users_table.user_studnum, users_table.user_department, users_table.user_course, users_table.user_block, users_table.user_firstname, users_table.user_lastname, users_table.user_middlename, users_table.user_email, events_table.*, event_details_table.* FROM registration_table INNER JOIN users_table ON registration_table.user_studnum_r=users_table.user_studnum INNER JOIN events_table ON registration_table.event_id_r=events_table.event_id INNER JOIN event_details_table ON registration_table.event_id_r=event_details_table.event_id_e WHERE registration_table.event_id_r = $data->event_id AND event_details_table.deleted_at IS NULL AND registration_table.cancelled_at IS NULL";

        if ($res = $this->pdo->query($sql)->fetchAll()) {
            return ["data" => $res, "success" => true];
        } else {
            return array("data" => array("message" => "Unable to get data"), "success" => false);
        }
    }
}
