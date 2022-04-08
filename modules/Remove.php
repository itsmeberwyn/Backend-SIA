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

        try {
            $this->pdo->beginTransaction();

            $removeNewsSQL = "DELETE FROM news_table WHERE news_id=?";
            $removeNewsSQL = $this->pdo->prepare($removeNewsSQL);
            $removeNewsSQL->execute([$data->news_id]);

            $this->pdo->commit();

            $code = 200;
            $remarks = "success";
            $message = "Successfully deleted";
            return $this->gm->response($payload, $remarks, $message, $code);
        } catch (\PDOException $e) {
        }
        return $this->gm->response($payload, $remarks, $message, $code);
    }
}
