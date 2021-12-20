<?php

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
            $sql = "CREATE TABLE Transactions (
                id INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                transactiondate TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP NOT NULL,
                useriban VARCHAR(21) NOT NULL,
                amount FLOAT NOT NULL,
                FOREIGN KEY(sendinguser) REFERENCES User (id) NOT NULL,
                FOREIGN KEY (recieveinguser) REFERENCES User (id) NOT NULL
                )";

            $conn->query($sql);

            $conn->close();
    }

        function makeTransaction ($useriban, $amount, $sendinguser) 
        {
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $userid = $this->getUserIdIBAN($useriban);

            $sql = "INSERT INTO E_Banking.Transactions (`useriban`, `amount`, `recieveinguser`, `sendinguser`)
            VALUES ('$useriban', '$amount', '$userid', '$sendinguser')";

            $conn->query($sql);

            $conn->close();
        }

        function getTableRecentTransactions ()
        {

        }

        function getUserIdIBAN($useriban) {

            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id FROM Users WHERE useriban LIKE $useriban";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result)['id'];
            } 

            $conn->close();

        }
    }
