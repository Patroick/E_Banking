<?php

class Transaktionen
{

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
                sendinguser INT(6) UNSIGNED,
                receivinguser INT(6) UNSIGNED,
                FOREIGN KEY (receivinguser) REFERENCES Users(id),
                FOREIGN KEY (receivinguser) REFERENCES Users(id)
                )";

        $conn->query($sql);

        $conn->close();
    }

    function makeTransaction($useriban, $amount, $sendinguser)
    {

        $this->createTable();

        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $userid = $this->getUserIdIBAN($useriban);

        if ($userid != $sendinguser) {

            $sql = "INSERT INTO E_Banking.Transactions (`useriban`, `amount`, `receivinguser`, `sendinguser`)
            VALUES ('$useriban', '$amount', '$userid', '$sendinguser')";

            $conn->query($sql);
        } else {
            print_r("Sie können kein Geld an Ihr eigenes Konto schicken!");
        }

        $conn->close();
    }

    function getTableRecentTransactions()
    {
    }

    function getUserIdIBAN($useriban)
    {

        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id FROM Users WHERE useriban LIKE '$useriban'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['id'];
        }

        $conn->close();
    }
}
