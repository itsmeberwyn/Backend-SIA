<?php
class Patch
{
    protected $pdo, $gm;

    public function __construct(\PDO $pdo)
    {
        $this->gm = new GlobalMethods($pdo);
        $this->pdo = $pdo;
    }

    public function updateEvent($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to update data";

        $eventInfo = json_decode($data['event_info']);
        $eventDetails = json_decode($data['event_details']);

        $imageInfo = $this->gm->uploadImage('event', $_FILES);

        if ($imageInfo['status'] == 'success') {
            $eventDetails->event_detail_image = $imageInfo['filename'];
        }

        try {
            $this->pdo->beginTransaction();

            $updateEventSQL = "UPDATE events_table SET event_title=?, event_description=?, event_location=?, event_capacity=?, event_startdatetime=?, event_enddatetime=? WHERE event_id=?";
            $updateEventSQL = $this->pdo->prepare($updateEventSQL);
            $updateEventSQL->execute([$eventInfo->event_title, $eventInfo->event_description, $eventInfo->event_location, $eventInfo->event_capacity, $eventInfo->event_startdatetime, $eventInfo->event_enddatetime, $eventInfo->event_id]);

            $updateEventSQL = "UPDATE event_details_table SET event_detail_image=?, event_detail_organizer=?, event_detail_type=?, event_detail_category=? WHERE event_id_e=?";
            $updateEventSQL = $this->pdo->prepare($updateEventSQL);
            $updateEventSQL->execute([$eventDetails->event_detail_image, $eventDetails->event_detail_organizer, $eventDetails->event_detail_type, $eventDetails->event_detail_category, $eventInfo->event_id]);

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

    public function updateNews($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to update data";

        $newsInfo = json_decode($data['news_info']);
        $newsDetails = json_decode($data['news_details']);

        $imageInfo = $this->gm->uploadImage('news', $_FILES);

        if ($imageInfo['status'] == 'success') {
            $newsDetails->news_details_image = $imageInfo['filename'];
        }

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
