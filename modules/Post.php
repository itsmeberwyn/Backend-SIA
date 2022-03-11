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
}
