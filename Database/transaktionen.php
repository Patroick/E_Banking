<?php

require_once "datenbank.php";

    class Transaktionen{

        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "E_Banking";

        function createTable()
        {
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // sql to create table
                $sql = "CREATE TABLE E_Banking.Transactions (
                id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                transactiondate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
                useriban VARCHAR(21) NOT NULL,
                amount FLOAT NOT NULL
                )";

            $conn->query($sql);

        }

        function makeTransaction ($useriban, $amount) 
        {
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password);
            // Check connection
            if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        }
    }

?> 