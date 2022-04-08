<?php
class Patch
{
    protected $pdo, $gm;

    public function __construct(\PDO $pdo)
    {
        $this->gm = new GlobalMethods($pdo);
        $this->pdo = $pdo;
    }

    public function updateNews($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to update data";

        $newsInfo = $data->news_info;
        $newsDetails = $data->news_details;

        try {
            $this->pdo->beginTransaction();

            $updateNewsSQL = "UPDATE news_table SET news_title=?, news_description=? WHERE news_id=?";
            $updateNewsSQL = $this->pdo->prepare($updateNewsSQL);
            $updateNewsSQL->execute([$newsInfo->news_title, $newsInfo->news_description, $newsInfo->news_id]);

            $updateNewsSQL = "UPDATE news_details_table SET news_details_image=?, news_details_organizer=?, news_details_type=?, news_details_category=? WHERE news_id_n=?";
            $updateNewsSQL = $this->pdo->prepare($updateNewsSQL);
            $updateNewsSQL->execute([$newsDetails->news_details_image, $newsDetails->news_details_organizer, $newsDetails->news_details_type, $newsDetails->news_details_category, $newsInfo->news_id]);

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
