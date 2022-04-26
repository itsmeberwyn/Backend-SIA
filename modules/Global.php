<?php
class GlobalMethods
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function uploadImage($dir, $file)
    {
        // return ['data' => $dir, 'file' => $file];

        if ($file) {
            $target_dir = 'upload/' . $dir . '/';

            $imageFileType = strtolower(pathinfo($file['image']['name'], PATHINFO_EXTENSION));
            $filename = time() . '.' . $imageFileType;
            $target_file = $target_dir .  $filename;

            move_uploaded_file($file['image']['tmp_name'], $target_file);

            return ['filename' => $filename, 'targetpath' => $target_file, 'status' => 'success'];
        } else {
            return ['message' => 'something went wrong', 'status' => 'error'];
        }
    }

    public function retrieve($sql)
    {
        $data = array();
        $errmsg = "";
        $code = 0;

        try {
            if ($res = $this->pdo->query($sql)->fetchAll()) {
                foreach ($res as $rec) {
                    array_push($data, $rec);
                }

                $res = null;
                $code = 200;

                return array("code" => $code, "data" => $data);
            } else {
                $errmsg = "No records found";
                $code = 404;
            }
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }

        return array("code" => $code, "errmsg" => $errmsg);
    }

    public function insert($table, $data)
    {
        $i = 0;
        $fields = [];
        $values = [];
        foreach ($data as $key => $value) {
            array_push($fields, $key);
            array_push($values, $value);
        }

        try {
            $ctr = 0;
            $sqlstr = "INSERT INTO $table (";
            foreach ($fields as $value) {
                $sqlstr .= $value;
                $ctr++;
                if ($ctr < count($fields)) {
                    $sqlstr .= ", ";
                }
            }

            $sqlstr .= ") VALUES (" . str_repeat("?, ", count($values) - 1) . "?)";
            $sql = $this->pdo->prepare($sqlstr);
            $sql->execute($values);
            return array("code" => 200, "remarks" => "success");
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }

        return array("code" => $code, "errmsg" => $errmsg);
    }

    public function update($table, $data, $conditionString)
    {
        $fields = [];
        $values = [];
        $setStr = "";

        foreach ($data as $key => $value) {
            array_push($fields, $key);
            array_push($values, $value);
        }

        try {
            $ctr = 0;
            $sqlstr = "UPDATE $table SET ";
            foreach ($data as $key => $value) {
                $sqlstr .= "$key=?";
                $ctr++;

                if ($ctr < count($fields)) {
                    $sqlstr .= ", ";
                }
            }

            $sqlstr .= " WHERE " . $conditionString;
            $sql = $this->pdo->prepare($sqlstr);
            $sql->execute($values);

            return array("code" => 200, "remarks" => "success");
        } catch (\PDOException $e) {
            $errmsg = $e->getMessage();
            $code = 403;
        }
        return array("code" => $code, "errmsg" => $errmsg);
    }

    public function response($payload, $remarks, $message, $code)
    {
        $status = array("remarks" => $remarks, "message" => $message);
        http_response_code($code);
        return array("status" => $status, "payload" => $payload, "timestamp" => date_create());
    }
}
