<?php

    function validateAmount($amount) {
        if($amount !== null && $amount > 0 && $amount != '') {
            return true;
        } else {
            return false;
        }
    }

    function validateReason($reason) {
        if($reason != null && $reason != "" && strlen($reason) >= 5 && strlen($reason) <= 255) {
            return true;
        } else {
            return false;
        }
    }

    function validateIBAN ($iban) {
        if($iban != null && $iban != "" && strlen($iban) == 21){
            return true;
        } else {
            return false;
        }
    }

?>