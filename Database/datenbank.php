 <?php

    class Database
    {

        private $servername = "localhost";
        private $username = "root";
        private $password = "";
        private $dbname = "E_Banking";

        function createDB()
        {

            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $this->createTable();

            $conn->close();
        }

        function createTable()
        {
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Create database
            $sql = "CREATE DATABASE E_Banking";
            mysqli_query($conn, $sql);

            // sql to create table
            $sql = "CREATE TABLE E_Banking.Users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            userrole VARCHAR(8) NOT NULL,
            firstname VARCHAR(30) NOT NULL,
            lastname VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL,
            userpassword VARCHAR(50) NOT NULL,
            userbalance FLOAT NOT NULL,
            useriban VARCHAR(21) NOT NULL,
            userbic VARCHAR(11) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

            $conn->query($sql);

            $conn->close();
        }

        function addUser($firstname, $lastname, $email, $userpassword)
        {
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $iban = $this->ibanGenerator();

            $sql = "INSERT INTO Users (`userrole`, `firstname`, `lastname`, `email`, `userpassword`, `userbalance`, `useriban`, `userbic`)
            VALUES ('User', '$firstname', '$lastname', '$email', MD5('$userpassword'), '0.00', '$iban', 'GIBAATWW')";

            if ($conn->query($sql) === TRUE) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        }

        function ibanGenerator()
        {
            $iban = 'AT-' . mt_rand(100000000000000000, 999999999999999999);
            return $iban;
        }

        function checkUserLogin($email, $userpassword)
        {
            $validatet = false;
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT userrole, email, userpassword FROM Users WHERE userrole LIKE 'User' AND email = '$email' AND userpassword = MD5('$userpassword')";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $validatet = true;
            }

            return $validatet;

            $conn->close();
        }

        function checkLoginEmployee($email, $userpassword)
        {
            $validatet = false;
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT userrole, email, userpassword FROM Users WHERE userrole LIKE 'Employee' AND email = '$email' AND userpassword = MD5('$userpassword')";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $validatet = true;
            }

            return $validatet;

            $conn->close();
        }

        function getAccountId($email, $userpassword) 
        {
            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT id FROM Users WHERE email = '$email' AND userpassword = MD5('$userpassword')";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                return mysqli_fetch_assoc($result)['id'];
            }

            $conn->close();
        }

        function getAccountData($id) {

            // Create connection
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            // Check connection

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM Users WHERE id LIKE $id";
            $result = mysqli_query($conn, $sql);

            // Fetch all
            $data = mysqli_fetch_assoc($result);

            $result->free_result();

            $conn->close();

            return $data;
        }
    }

?> 