<?php

class Adminauth
{
    protected $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function adminRegister($data)
    {
        $sql = "SELECT * FROM admins_table WHERE admin_email = '$data->admin_email'";
        if ($res = $this->pdo->query($sql)->fetchAll()) {
            return array("conflict" => "Username already registered");
        } else {
            $sql = "INSERT INTO admins_table(admin_firstname, admin_lastname, admin_middlename, admin_gender, admin_email, role, password) VALUES (?,?,?,?,?,?,?)";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $data->admin_firstname,
                $data->admin_lastname,
                $data->admin_middlename,
                $data->admin_gender,
                $data->admin_email,
                'admin',
                password_hash($data->admin_password, PASSWORD_DEFAULT),
            ]);

            $count = $sql->rowCount();
            $LAST_ID = $this->pdo->lastInsertId();

            if ($count) {
                return array(
                    "data" => array(
                        "id" => $LAST_ID,
                        "firstname" => $data->admin_firstname,
                        "lastname" => $data->admin_lastname,
                        "lastname" => $data->admin_middlename,
                        "lastname" => $data->admin_gender,
                        "email" => $data->admin_email,
                    ),
                    "success" => true
                );
            } else {
                return array("data" => array("message" => "No Record inserted"), "success" => false);
            }
        }
    }

    public function adminLogin($data)
    {
        $sql = "SELECT * FROM admins_table WHERE admin_email = ? LIMIT 1";
        $sql = $this->pdo->prepare($sql);
        $sql->execute([
            $data->admin_email,
        ]);

        $res = $sql->fetch(PDO::FETCH_ASSOC);

        if (password_verify($data->admin_password, $res['password'])) {
            $refreshToken = generateRandomString();

            $sql = "INSERT INTO admin_refresh_tokens (adminid, token, expires_at) VALUES (?, ?, ?)";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $res['admin_id'],
                $refreshToken,
                (time() + 600),
            ]);

            $headers = array('alg' => 'HS256', 'typ' => 'JWT');
            $payload = array('sub' => '1234567890', 'name' => $res['admin_firstname'], 'adminid' => $res['admin_id'], 'admin' => true, 'exp' => (time() + 60));

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
                "adminid" => $res['admin_id'],
                "firstname" => $res['admin_firstname'],
                "lastname" => $res['admin_lastname'],
                "role" => $res['role'],
            ), "success" => true, "accesstoken" => $jwt);
        } else {
            return array("data" => array("message" => "Incorrect username or password"), "success" => false);
        }
    }

    public function refreshToken($data)
    {
        if (isset($_COOKIE['refreshtoken'])) {
            $refreshToken = $_COOKIE['refreshtoken'];

            $sql = "SELECT admin_refresh_tokens.*, admins_table.admin_firstname, admins_table.admin_id FROM admin_refresh_tokens, admins_table WHERE token=? AND admins_table.admin_id = admin_refresh_tokens.adminid LIMIT 1";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $refreshToken,
            ]);

            $res = $sql->fetch(PDO::FETCH_ASSOC);


            if ($res) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('sub' => '1234567890', 'name' => $res['admin_firstname'], 'adminid' => $res['admin_id'], 'admin' => true, 'exp' => (time() + 60));

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

            $sql = "DELETE FROM admin_refresh_tokens WHERE adminid=? AND token=?";
            $sql = $this->pdo->prepare($sql);
            $sql->execute([
                $data->adminid,
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
