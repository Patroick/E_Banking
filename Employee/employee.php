<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>E-Banking App</title>
</head>

<body>

    <?php

    session_start();

    require_once "../Database/datenbank.php";
    require_once "../loginValidation.php";

    $email = '';
    $password = '';
    $errors = [];
    $db = new Database();

    if (isset($_POST['login'])) {
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        if(validateEmail($email) && validatePassword($password)){
            if ($db->checkLoginEmployee($email, $password)) {
                print_r("here");
                $_SESSION['isLoggedIn'][$db->getAccountId($email, $password)] = true;
                header("Location: ../Ebanking/adminebanking.php?id=" . $db->getAccountId($email, $password));
            } else {
                $message = "<p style='color: red'>Die eingegebenen Daten sind fehlerhaft!</p>";
                foreach ($errors as $key => $value) {
                    echo "<li>" . $value . "</li>";
                }
            }
        } else {
            $message = "<p style='color: red'>Die eingegebenen Daten sind fehlerhaft!</p>";
            foreach ($errors as $key => $value) {
                echo "<li>" . $value . "</li>";
            }
        }

        
    }

    if (isset($_POST['goBack'])) {
        header("Location: ../index.php");
    }

    ?>

    <div class="container">
        <div style="text-align: center">
            <form id="loginForm" action="employee.php" method="post">

                <h1 class="mt-5" style="text-align: center">Angestellten Login</h1>

                <div class="form-group pt-3">
                    <h4 class="pt-3 pb-2">Bitte Anmelden</h4>
                    <input type="text" style="width: 20em; height: 3em" id="email" name="email" value="<?= htmlspecialchars("") ?>" placeholder="E-Mail" minlength="5" maxlength="30" required>
                </div>

                <div class="form-group pt-3">
                    <input type="password" style="width: 20em; height: 3em" id="password" name="password" value="<?= htmlspecialchars("") ?>" placeholder="Passwort" minlength="5" maxlength="20" required>
                </div>

                <div>
                    <?php
                    if (isset($_POST['login'])) {
                        echo $message;
                    }
                    ?>
                </div>

                <div>
                    <button type="submit" style="width: 20em; height: 3em" name="login" class="btn btn-primary mt-4">Anmelden</button>
                </div>

            </form>

            <div class="form-group pt-3">
                <form id="employeeForm" action="employee.php" method="post">
                    <h5 class="pt-3">Kein Angestellter?</h5>
                    <button type="submit" style="width: 15em; height: 2.5em" name="goBack" class="btn btn-secondary">Zurück</button>
                </form>
            </div>

        </div>
    </div>
</body>

</html>