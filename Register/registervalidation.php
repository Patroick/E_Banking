<?php

    function validateName ($name)
    {
        if($name != null && $name != "" && strlen($name) >= 5 && strlen($name) <= 30){
            return true;
        } else {
            return false;
        }
    }

    function validateEmail ($email) {
        if($email != null && $email != "" && strlen($email) >= 5 && strlen($email) <= 50 && filter_var($email, FILTER_VALIDATE_EMAIL)){
            return true;
        } else {
            return false;
        }
    }

    function validatePassword ($password) {
        if($password != null && $password != "" && strlen($password) >= 5 && strlen($password) <= 50){
            return true;
        } else {
            return false;
        }
    }
?>