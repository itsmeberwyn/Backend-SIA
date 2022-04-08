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
        $message = "Unable to save data";

        try {
            $sql = "SELECT * FROM news_table, news_details_table WHERE news_table.news_id = news_details_table.news_id_n";
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
}
