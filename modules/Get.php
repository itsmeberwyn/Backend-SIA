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
    public function getEventToday()
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        $currentDate = date('Y-m-d');

        try {
            $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) = '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL";
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
    public function getEventFuture()
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        $currentDate = date('Y-m-d');

        try {
            $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) > '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL";
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

    public function getEventFinished()
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        $currentDate = date('Y-m-d');

        try {
            $sql = "SELECT * FROM events_table, event_details_table WHERE DATE(events_table.event_startdatetime) < '$currentDate' AND events_table.event_id = event_details_table.event_id_e AND event_details_table.deleted_at IS NULL";
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

    public function getUserEvent($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to fetch data";

        try {
            $sql = "SELECT registration_table.*, users_table.user_studnum, users_table.user_department, users_table.user_block, users_table.user_firstname, users_table.user_lastname, users_table.user_middlename, users_table.user_email, events_table.*, event_details_table.* FROM registration_table INNER JOIN users_table ON registration_table.user_studnum_r=users_table.user_studnum INNER JOIN events_table ON registration_table.event_id_r=events_table.event_id INNER JOIN event_details_table ON registration_table.event_id_r=event_details_table.event_id_e WHERE users_table.user_studnum = $data->event_id AND event_details_table.deleted_at IS NULL AND registration_table.cancelled_at IS NULL AND DATE(events_table.event_enddatetime) > NOW()";

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
            $sql = "SELECT registration_table.*, users_table.user_studnum, users_table.user_department, users_table.user_block, users_table.user_firstname, users_table.user_lastname, users_table.user_middlename, users_table.user_email, events_table.*, event_details_table.* FROM registration_table INNER JOIN users_table ON registration_table.user_studnum_r=users_table.user_studnum INNER JOIN events_table ON registration_table.event_id_r=events_table.event_id INNER JOIN event_details_table ON registration_table.event_id_r=event_details_table.event_id_e WHERE users_table.user_studnum = $data->event_id AND event_details_table.deleted_at IS NULL AND registration_table.cancelled_at IS NULL AND DATE(events_table.event_enddatetime) < NOW()";

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
        $message = "Unable to save data";

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
}
