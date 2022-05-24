<?php
class Studentauth
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function userRegister($data)
    {
        $sql = "SELECT * FROM users_table WHERE user_email = '$data->user_email'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            return array("conflict" => "Username already registered");
        } else {
            $sql = "INSERT INTO users_table(user_firstname, user_lastname, user_middlename, user_gender, user_department, user_yearlevel, user_block, user_email, user_password, role, user_priviledge) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $data->user_firstname,
                $data->user_lastname,
                $data->user_middlename,
                $data->user_gender,
                $data->user_department,
                $data->user_yearlevel,
                $data->user_block,
                $data->user_email,
                password_hash($data->user_password, PASSWORD_DEFAULT),
                $data->role,
                $data->user_priviledge,
            ]);

            $count = $sql->rowCount();
            $LAST_ID = $this->pdo->lastInsertId();

            if ($count) {
                return array(
                    "data" => array(
                        "id" => $LAST_ID,
                        "firstname" => $data->user_firstname,
                        "lastname" => $data->user_lastname,
                        "middlename" => $data->user_middlename,
                        "gender" => $data->user_gender,
                        "department" => $data->user_department,
                        "yearlevel" => $data->user_yearlevel,
                        "block" => $data->user_block,
                        "email" => $data->user_email,
                        "priviledge" => $data->user_priviledge,
                    ),
                    "success" => true
                );
            } else {
                return array("data" => array("message" => "No Record inserted"), "success" => false);
            }
        }
    }


    public function userLogin($data)
    {
        $sql = "SELECT * FROM users_table WHERE user_email = ? LIMIT 1";
        $sql = $this->pdo->prepare($sql);
        $sql->execute([
            $data->user_email,
        ]);

        $res = $sql->fetch(PDO::FETCH_ASSOC);
        $count = $sql->rowCount();

        if (password_verify($data->user_password, $res['user_password'])) {
            $refreshToken = generateRandomString();

            $sql = "INSERT INTO student_refresh_tokens (studentid, token, expires_at) VALUES (?, ?, ?)";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $res['user_studnum'],
                $refreshToken,
                (time() + 600),
            ]);

            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('sub' => '1234567890', 'name' => $res['user_firstname'], 'studentid' => $res['user_studnum'], 'admin' => false, 'exp' => (time() + 60));

            $jwt = generate_jwt($headers, $payload);

            $cookie_options = array(
                'expires' => time() + 3600,
                'path' => '/',
                'httponly' => true,
                'secure' => true, // or false
                'samesite' => 'Strict' // None || Lax || Strict
            );

            setcookie("refreshtoken", $refreshToken, $cookie_options);

            return array("data" => array(
                "user_studnum" => $res['user_studnum'],
                "user_firstName" => $res['user_firstname'],
                "user_lastName" => $res['user_lastname'],
                "user_middleName" => $res['user_middlename'],
                "user_gender" => $res['user_gender'],
                "user_department" => $res['user_department'],
                "user_yearlevel" => $res['user_yearlevel'],
                "user_block" => $res['user_block'],
                "user_email" => $res['user_email'],
                "privilege" => $res['user_priviledge'],
                "role" => $res['role']
            ), "success" => true, "accesstoken" => $jwt);
        } else {
            return array("data" => array("message" => "Incorrect username or password"), "success" => false);
        }
    }

    public function refreshToken($data)
    {
        if (isset($_COOKIE['refreshtoken'])) {
            $refreshToken = $_COOKIE['refreshtoken'];

            $sql = "SELECT student_refresh_tokens.*, users_table.user_firstname, users_table.user_studnum FROM student_refresh_tokens, users_table WHERE token=? AND users_table.user_studnum = student_refresh_tokens.studentid LIMIT 1";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $refreshToken,
            ]);

            $res = $sql->fetch(PDO::FETCH_ASSOC);

            if ($res) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('sub' => '1234567890', 'name' => $res['user_firstname'], 'studentid' => $res['user_studnum'], 'admin' => false, 'exp' => (time() + 60));

                $jwt = generate_jwt($headers, $payload);

                // add logic to renew cookie if valid user
                // code...

                return ['status' => 'ok', "accesstoken" => $jwt];
            } else {
                echo errmsg(400);
                die();
            }
        } else {
            return ['status' => 'error'];
        }
    }

    public function logout($data)
    {
        if (isset($_COOKIE['refreshtoken'])) {
            $refreshToken = $_COOKIE['refreshtoken'];

            $sql = "DELETE FROM student_refresh_tokens WHERE studentid=? AND token=?";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $data->studentid,
                $refreshToken,
            ]);
            $count = $sql->rowCount();

            if ($count) {
                unset($_COOKIE['refreshtoken']);
                setcookie('refreshtoken', null, -1, '/');
            }
            return ["data" => "success"];
        }
        return ["data" => "failed"];
    }
}
