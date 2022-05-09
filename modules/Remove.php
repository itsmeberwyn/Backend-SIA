<?php
class Remove
{
    protected $pdo, $gm;

    public function __construct(\PDO $pdo)
    {
        $this->gm = new GlobalMethods($pdo);
        $this->pdo = $pdo;
    }

    public function removeNews($data)
    {
        $payload = [];
        $code = 404;
        $remarks = "failed";
        $message = "Unable to delete data";


        $removeNewsSQL = "UPDATE news_details_table SET deleted_at=NOW() WHERE news_id_n=?";
        $removeNewsSQL = $this->pdo->prepare($removeNewsSQL);
        $removeNewsSQL->execute([$data->news_id]);

        $code = 200;
        $remarks = "success";
        $message = "Successfully deleted";

        return $this->gm->response($payload, $remarks, $message, $code);
    }
}
