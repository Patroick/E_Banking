 <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "E_Banking";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Create database
    $sql = "CREATE DATABASE E_Banking";
    if (mysqli_query($conn, $sql)) {
        echo "Database created successfully";
    } else {
        echo "Error creating database: " . mysqli_error($conn);
    }

    // sql to create table
    $sql = "CREATE TABLE Users (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    userrole VARCHAR(8) NOT NULL,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50) NOT NULL,
    userpassword VARCHAR(50) NOT NULL,
    userbalance FLOAT NOT NULL,
    useriban VARCHAR(20) NOT NULL,
    userbic VARCHAR(11) NOT NULL,
    reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) === TRUE) {
        echo "Table Users created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }

    $conn->close();
    ?>





 