<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 10.03.2019
 * Time: 17:43
 */

namespace classes;

use classes\helpers\DB;
use classes\helpers\TextSecurity;
use mysql_xdevapi\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class User
{
    public function __construct()
    {
        $this->DB = DB::init();
    }

    public function login(array $array)
    {
        if (!$email = filter_var($array['email'], FILTER_VALIDATE_EMAIL)) {
            throw new \Exception('Incorrect email', 1);
        }
        $email = strtolower($email);

        $this->DB->where("email", $email);
        $userInDB = $this->DB->getOne("users");

        if ($userInDB) {

            if (!$array['pass'] && !password_verify($array['pass'], $userInDB['pwd'])) {
                throw new \Exception('Incorrect password', 2);
            }

            if (!$userInDB['verified']) {
                throw new \Exception('User is not verified yet', 3);
            }

            return $userInDB;
        }

        //user is not found
        $token  = $this->newToken();
        $newuser = [
            "email" => $email,
            "pwd" => password_hash($array['pass'], PASSWORD_DEFAULT),
            "created_at" => time(),
            "token" => $token
        ];

        $userInDB = $this->DB->insert("users", $newuser);

        //notify user via email
        $mail = new PHPMailer();
        $mail->isMail();
        $mail->CharSet= "utf-8";
        $mail->setFrom(ADMIN_EMAIL, 'from '.ADMIN_NAME);
        $mail->isHTML(true);
        $mail->Subject = 'Email verification';
        $mail->addAddress($email);
        $mail->Body = "
            <h1>Welcome to VisAssis</h1>
            <p>Please, verify your email. Click this link: 
                <a href='".HOST."/api/?method_name=confirm_email&token=".$token."'>".HOST."api/?method_name=confirm_email&token=".$token."</a>
            </p>
        ";
        $mail->send();

        return false;

    }

    public function confirm(string $token)
    {
        if (!$token = TextSecurity::shield_hard($token)) {
            throw new \Exception ('Incorrect token');
        }

        $newToken = $this->newToken();
        $this->DB->where("token", $token);
        $this->DB->update("users", [
            "token" => $newToken,
            "verified" => 1
        ]);

        $this->DB->where("token", $newToken);
        return $this->DB->getOne("users");
    }

    public function newToken()
    {
        return hash("md5", time().rand());
    }
}
