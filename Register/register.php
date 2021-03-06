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

    require "../Database/datenbank.php";
    require "registervalidation.php";

    session_start();

    $firstname = '';
    $lastname = '';
    $email = '';
    $password = '';
    $user;
    $errors = [];
    $db = new Database();

    if (isset($_POST['register'])) {
        $firstname = isset($_POST['firstname']) ? $_POST['firstname'] : '';
        $lastname = isset($_POST['lastname']) ? $_POST['lastname'] : '';
        $email = isset($_POST['email']) ? $_POST['email'] : '';
        $password = isset($_POST['password']) ? $_POST['password'] : '';
        if(validateName($firstname) && validateName($lastname) && validateEmail($email) && validatePassword($password)){
            $_SESSION['registered'] = 'Sie wurden erfolgreich registriert';
            $db->addUser($firstname, $lastname, $email, $password);
        } else {
            $_SESSION['registered'] = 'Fehler bei der Registrierung';
        }
        header("Location: ../index.php");
    }

    if (isset($_POST['login'])) {
        header("Location: ../index.php");
    }
    ?>
    <div class="container">
        <div style="text-align: center">
            <form id="registerForm" action="register.php" method="post">
                <h1 class="mt-5" style="text-align: center">Registrierung</h1>

                <div class="form-group pt-3">
                    <h4 class="pt-3 pb-2">Bitte Registrieren</h4>
                    <input type="text" style="width: 20em; height: 3em" id="firstname" name="firstname" value="<?= htmlspecialchars("") ?>" placeholder="Vorname" minlength="5" maxlength="30" required>
                </div>

                <div class="form-group pt-3">
                    <input type="text" style="width: 20em; height: 3em" id="lastname" name="lastname" value="<?= htmlspecialchars("") ?>" placeholder="Nachname" minlength="5" maxlength="30" required>
                </div>

                <div class="form-group pt-3">
                    <input type="email" style="width: 20em; height: 3em" id="email" name="email" value="<?= htmlspecialchars("") ?>" placeholder="E-Mail" minlength="5" maxlength="50" required>
                </div>

                <div class="form-group pt-3">
                    <input type="password" style="width: 20em; height: 3em" id="password" name="password" value="<?= htmlspecialchars("") ?>" placeholder="Passwort" minlength="5" maxlength="50" required>
                </div>

                <div>
                    <button type="submit" style="width: 20em; height: 3em" name="register" class="btn btn-primary mt-4">Registrieren</button>
                </div>

            </form>

            <div class="form-group pt-3">
                <form id="registerForm" action="register.php" method="post">
                    <h5 class="pt-3">Bereits Registriert?</h5>
                    <button type="submit" style="width: 15em; height: 2.5em" name="login" class="btn btn-secondary">Anmelden</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>