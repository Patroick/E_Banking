<?php

class User
{

    private $email;
    private $password;
    private $errors;

    public function __construct($email, $password)
    {
        $this->email = $email;
        $this->password = $password;
        $this->errors = [];
    }

    public function set_email($email)
    {
        $this->email = $email;
    }

    public function set_password($password)
    {
        $this->password = $password;
    }

    public function get_email()
    {
        return $this->email;
    }

    public function get_password()
    {
        return $this->password;
    }

    public function validate($email, $password)
    {
        return $this->checkEmail($email) && $this->checkPassword($password);
    }

    public function checkEmail($email)
    {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            if (strlen($email) >= 5 && strlen($email) <= 30) {
                $this->set_email($email);
                return true;
            } else if (strlen($email) < 5) {
                $this->errors[] = "Die eingegebene Email ist zu kurz!";
                return false;
            } else {
                $this->errors[] = "Die eingegebene Email ist zu lang!";
                return false;
            }
        } else {
            $this->errors[] = "Die eingegebene Email ist ungültig!";
            return false;
        }
    }

    public function checkPassword($password)
    {
        if (strlen($password) >= 5 && strlen($password) <= 20) {
            $this->set_password($password);
            return true;
        } else if (strlen($password) < 5) {
            $this->errors[] = "Das eingegebene Passwort ist zu kurz!";
            return false;
        } else {
            $this->errors[] = "Das eingegebene Passwort ist zu lang!";
            return false;
        }
    }

    public function userLogin($email, $password)
    {
        if ($email == "jo.lugger@tsn.at" && $password == "spslove") {
            $_SESSION['user'] = $email;
            return true;
        } else {
            $this->errors[] = "Fehler beim User Login!";
            $this->isLoggedIn = false;
            return false;
        }
    }

    public static function userLogout()
    {
        session_destroy();
    }

    public static function isUserLoggedIn()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }
}
