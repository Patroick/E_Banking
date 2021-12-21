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
                amount FLOAT NOT NULL,
                sendinguserId INT(6) UNSIGNED NOT NULL,
                sendinguserIBAN VARCHAR(22) NOT NULL,
                sendinguserBIC VARCHAR(12) NOT NULL,
                receivinguserId INT(6) UNSIGNED NOT NULL,
                receivinguserIBAN VARCHAR(22) NOT NULL,
                receivinguserBIC VARCHAR(12) NOT NULL,
                reason VARCHAR(255) NOT NULL,
                reference VARCHAR(35) NOT NULL,
                FOREIGN KEY (sendinguserId) REFERENCES Users(id),
                FOREIGN KEY (receivinguserId) REFERENCES Users(id)
                )";

        $conn->query($sql);

        $conn->close();
    }

    function makeTransaction($amount, $sendingUserId, $receivingUserIBAN, $reason)
    {

        $this->createTable();

        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $receivingUserId = $this->getUserIdIBAN($receivingUserIBAN);

        if ($receivingUserId != $sendingUserId && $this->userExists($receivingUserIBAN)) {

            $sendingUserIBAN = $this->getUserIBANId($sendingUserId);
            $sendingUserBIC = $this->getUserBICId($sendingUserId);
            $receivingUserBIC = $this->getUserBICId($receivingUserId);
            $reference = $this->generateReference();

            $sql = "INSERT INTO Transactions (`amount`, `sendinguserId`, `sendinguserIBAN`, `sendinguserBIC`, `receivinguserId`, `receivinguserIBAN`, `receivinguserBIC`, `reason`, `reference`)
            VALUES ('$amount', '$sendingUserId', '$sendingUserIBAN', '$sendingUserBIC', '$receivingUserId','$receivingUserIBAN', '$receivingUserBIC', '$reason', '$reference')";

            $conn->query($sql);

            /* echo $conn->query($sql); */
        ?>
            <div class="alert alert-success col-sm-11 m-1" style="text-align: center;">
                <h2>Transaktion Erfolgreich!</h2>
                <p>Es wurden <?php echo $amount ?>€ an das Konto mit dem IBAN: <?php echo $receivingUserIBAN ?> gesendet.</p>
            </div>
        <?php
        } else if ($receivingUserId == $sendingUserId) {
        ?>
            <div class="alert alert-danger col-sm-11 m-1" style="text-align: center;">
                <h2>Achtung!</h2>
                <p>Sie können kein Geld auf Ihr eigenes Konto senden!</p>
            </div>
        <?php
        } else {
        ?>
            <div class="alert alert-warning col-sm-11 m-1" style="text-align: center;">
                <h3>Achtung!</h3>
                <p>Es existiert kein Konto mit dem IBAN: <?php echo $receivingUserIBAN ?>!</p>
                <p>Überweisung wurde Abgebrochen!</p>
            </div>
        <?php
        }

        $conn->close();
    }

    function getTableRecentTransactionsAllUser($userid)
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Transactions WHERE sendinguserid LIKE $userid OR receivinguserId LIKE $userid";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $table = '';
            foreach ($result as $row) {
                $tablerow = '<tr>
                        <td>' . $row['transactiondate'] . '</td>
                        <td>' . $row['sendinguserIBAN'] . '</td>
                        <td>' . $row['sendinguserBIC'] . '</td>
                        <td>' . $row['receivinguserIBAN'] . '</td>
                        <td>' . $row['receivinguserBIC'] . '</td>
                        <td>' . $row['reference'] . '</td>
                        <td>' . $row['reason'] . '</td>
                        <td>' . $row['amount'] . '€</td>
                        </tr>';

                $table .= $tablerow;
            }

            echo $table;
            unset($table);
        }
        $conn->close();

    }

    function getTableRecentTransactionsUser($userid)
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Transactions WHERE sendinguserId LIKE $userid OR receivinguserId LIKE $userid ORDER BY id DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $table = '';
            foreach($result as $row) {
                $tablerow = '<tr>
                        <td>'.$row['transactiondate'].'</td>
                        <td>'.$row['receivinguserIBAN'].'</td>
                        <td>'.$row['amount'].'€</td>
                        </tr>';

                $table .= $tablerow;
            }

            echo $table;
            unset($table);
        } 
        $conn->close();
    }

    function getTableRecentTransactionsUserLimitFive()
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Transactions ORDER BY id DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $table = '';
            foreach ($result as $row) {
                $tablerow = '<tr>
                        <td>' . $row['transactiondate'] . '</td>
                        <td>' . $row['sendinguserIBAN'] . '</td>
                        <td>' . $row['sendinguserBIC'] . '</td>
                        <td>' . $row['receivinguserIBAN'] . '</td>
                        <td>' . $row['receivinguserBIC'] . '</td>
                        <td>' . $row['reference'] . '</td>
                        <td>' . $row['reason'] . '</td>
                        <td>' . $row['amount'] . '€</td>
                        </tr>';

                $table .= $tablerow;
            }

            echo $table;
            unset($table);
        }
        $conn->close();
    }

    function getTableRecentTransactionsAll()
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM Transactions";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $table = '';
            foreach ($result as $row) {
                $tablerow = '<tr>
                        <td>' . $row['transactiondate'] . '</td>
                        <td>' . $row['sendinguserIBAN'] . '</td>
                        <td>' . $row['sendinguserBIC'] . '</td>
                        <td>' . $row['receivinguserIBAN'] . '</td>
                        <td>' . $row['receivinguserBIC'] . '</td>
                        <td>' . $row['reference'] . '</td>
                        <td>' . $row['reason'] . '</td>
                        <td>' . $row['amount'] . '€</td>
                        </tr>';

                $table .= $tablerow;
            }

            echo $table;
            unset($table);
        }
        $conn->close();
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

    function userExists($useriban)
    {

        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id FROM Users WHERE useriban LIKE '$useriban'";
        $result = mysqli_query($conn, $sql);

        if (!mysqli_num_rows($result) > 0) {
            return false;
        } else {
            return true;
        }

        $conn->close();
    }

    function getUserIBANId ($userid)
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT useriban FROM Users WHERE id LIKE '$userid'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['useriban'];
        }

        $conn->close();
    }

    function getUserBICId ($userid) 
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT userbic FROM Users WHERE id LIKE '$userid'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['userbic'];
        }

        $conn->close();
    }

    function generateReference()
    {
        $length = 35;
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $reference = '';
        for ($i = 0; $i < $length; $i++) {
            $reference .= $characters[rand(0, $charactersLength - 1)];
        }
        return $reference;
    }

    function idIsSender($userid) 
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id FROM Transactions WHERE sendinguserId LIKE '$userid'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

        $conn->close();
    }

    function idIsRecipient($userid)
    {
        // Create connection
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        // Check connection

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT id FROM Transactions WHERE receivinguserId LIKE '$userid'";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return true;
        } else {
            return false;
        }

        $conn->close();
    }
}

?>