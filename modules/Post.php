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

    public function createPost($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to save data";

        $newsInfo = $data->news_info;
        $newsDetails = $data->news_details;


        try {
            $this->pdo->beginTransaction();

            $newsInfoSQL = "INSERT INTO news_table(news_title, news_description) VALUES (?, ?)";
            $studentsSQL = $this->pdo->prepare($newsInfoSQL);
            $studentsSQL->execute([$newsInfo->news_title, $newsInfo->news_description]);
            $LAST_ID = $this->pdo->lastInsertId();

            $newsDetailSQL = "INSERT INTO news_details_table(news_id_n, news_details_image, news_details_organizer, news_details_type, news_details_category) VALUES (?, ?, ?, ?, ?)";
            $newsDetailSQL = $this->pdo->prepare($newsDetailSQL);
            $newsDetailSQL->execute([$LAST_ID, $newsDetails->news_details_image, $newsDetails->news_details_organizer, $newsDetails->news_details_type, $newsDetails->news_details_category]);

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
}
