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
                reason VARCHAR(255) NOT NULL,
                reference VARCHAR(255) NOT NULL,
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

        if ($userid != $sendinguser && $this->userExists($useriban)) {

            $sql = "INSERT INTO E_Banking.Transactions (`useriban`, `amount`, `receivinguser`, `sendinguser`)
            VALUES ('$useriban', '$amount', '$userid', '$sendinguser')";

            $conn->query($sql);
?>
            <div class="alert alert-success col-sm-11 m-1" style="text-align: center;">
                <h2>Transaktion Erfolgreich!</h2>
                <p>Es wurden <?php echo $amount ?>€ an das Konto mit dem IBAN: <?php echo $useriban ?> gesendet.</p>
            </div>
        <?php
        } else if ($userid == $sendinguser) {
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
                <p>Es existiert kein Konto mit dem IBAN: <?php echo $useriban ?>!</p>
                <p>Überweisung wurde Abgebrochen!</p>
            </div>
<?php
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

        $sql = "SELECT * FROM Users ORDER BY id DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result)['id'];
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

        $sql = "SELECT * FROM Users WHERE id LIKE $userid ORDER BY id DESC LIMIT 5";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            foreach($result as $row) {
                return '<tr>
                        <td>'.$row['transactiondate'].'</td>
                        <td>'.$this->getUserIBANId($row['sendinguser']).'</td>
                        <td>'.$this->getUserIBANId($row['receivinguser']).'</td>
                        <td>'.$row['reason'].'</td>
                        <td>'.$row['amount'].'</td>
                        </tr>';
            }
            return mysqli_fetch_assoc($result)['id'];
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
    }
}
