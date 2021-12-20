 <?php
    $mysqli = new mysqli("localhost", "root", "", "E_Banking");

    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli->connect_error;
        exit();
    }

    $sql = "SELECT * FROM E_Banking";
    $result = $mysqli->query($sql);

    // Fetch all
    $result->fetch_all(MYSQLI_ASSOC);

    // Free result set
    $result->free_result();

    $mysqli->close();
?> 