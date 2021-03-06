<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <script type="text/javascript" src="../js/liveupdate.js"></script>

    <title>E-Banking App</title>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

</head>

<body>

    <?php

    session_start();

    require_once("../Database/datenbank.php");
    require("../Database/transaktionen.php");
    require_once "ebankingvalidation.php";

    $db = new Database();
    $tran = new Transaktionen();

    if ((isset($_GET['id'])) && $_SESSION['isLoggedIn'][$_GET['id']] == true) {
        $id = $_GET['id'];
        $data = $db->getAccountData($id);
        $_SESSION['getData'] = $data;
        if ($data['userrole'] == 'Employee') {
            session_destroy();
            header("Location: ../index.php");
        }
    } else if ($_SESSION['isLoggedIn']['id'] == false || $_SESSION['isLoggedIn']['id'] != $_GET['id']) {
        session_destroy();
        header("Location: ../index.php");
    }

    if (isset($_POST['logout'])) {
        session_destroy();
        header("Location: ../index.php");
    }
    ?>

    <div class="container">
        <div class="row" style="text-align: center">
            <div class="col-md-12 mt-3">
                <h1>E-Banking App</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-3 border rounded m-1 pt-3" style="text-align: center; max-height: 22em">
                <h3> Ihr Profil </h3>
                <img src="../Img/Ricksadge.png" alt="Profilbild" style="width: 6em; height: 6em">
                <p class="pt-3"><?php echo $_SESSION['getData']['firstname'] . ' ' . $_SESSION['getData']['lastname']; ?></p>
                <p><?php echo $_SESSION['getData']['email']; ?></p>
                <form name="logout" action="ebanking.php" method="post">
                    <button type="submit" name="logout" class="btn btn-primary mb-3">Ausloggen</button>
                </form>
            </div>

            <div class=" col-sm-3 border rounded m-1 text-truncate pt-3" style="text-align: center; max-height: 22em">
                <h3>Ihr Konto</h3>
                <p><?php echo $_SESSION['getData']['useriban']; ?></p>

                <p>Spar-Konto</p>
                <p>Kontostand: <?php echo $_SESSION['getData']['userbalance']; ?></p>
                <form name="transaction" id="transaction" action="ebanking.php?id=<?php echo $_SESSION['getData']['id']; ?>" method="post">
                    <button type="submit" name="transaction" class="btn btn-primary">??berweisung</button></br></br>
                </form>
                <form name="transactionHistory" action="ebanking.php?id=<?php echo $_SESSION['getData']['id']; ?>" method="post">
                    <button type="submit" name="transactionHistory" class="btn btn-secondary" style="background-color: green">??berweisungshistorie</button></br></br>
                </form>
            </div>
            <div class="col-sm-5 border rounded m-1 p-3" style="max-height: 22em">
                <h3>Letzte Transaktionen</h3>
                <div class="table-responsive" style="max-height: 17em">
                    <table class="table table-hover">
                        <thead class="thead-dark" style="position: sticky;">
                            <tr>
                                <th scope="col">Datum</td>
                                <th scope="col">Empf??nger</td>
                                <th scope="col">Betrag</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($tran->idIsSender($_GET['id']) || $tran->idIsRecipient($_GET['id'])) {
                                $tran->getTableRecentTransactionsUser($_GET['id']);
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row">
            <?php
            if (isset($_POST['transaction'])) { ?>
                <form name="transactionForm" action="ebanking.php?id=<?php echo $_SESSION['getData']['id']; ?>" method="post">
                    <div class="col-sm-11 border rounded m-1 pt-3 container">
                        <div class="form-group">
                            <label for="recipient">IBAN</label>
                            <input type="text" class="form-control" id="recipient" name="recipient" value="<?= htmlspecialchars("") ?>" placeholder="AT-XXXXXXXXXXXXXXXXXX" minlength="21" maxlength="21" required>
                        </div>
                        <div class="form-group pt-2 pb-1">
                            <label for="amount">Betrag in ???</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="<?= htmlspecialchars("") ?>" placeholder="0.00" required>
                        </div>
                        <div class="form-group pt-2 pb-1">
                            <label for="reason">Zweck</label>
                            <input type="text" class="form-control" id="reason" name="reason" value="<?= htmlspecialchars("") ?>" placeholder="Zalando" minlength="5" maxlength="255" required>
                        </div>
                        <button type="submit" name="transfer" class="btn btn-primary mb-2 mt-2">??berweisen</button>
                    </div>
                </form>
                <?php
            }
            if (isset($_POST['transfer'])) {
                $sendinguserId = isset($_SESSION['getData']['id']) ? $_SESSION['getData']['id'] : '';
                $recieveinguserIBAN = isset($_POST['recipient']) ? $_POST['recipient'] : '';
                $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
                $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
                if (validateAmount($amount) && validateReason($reason) && validateIBAN($recieveinguserIBAN)) {
                    $tran->makeTransaction($amount, $sendinguserId, $recieveinguserIBAN, $reason);
                } else if (validateAmount($amount) && !validateReason($reason) && validateIBAN($recieveinguserIBAN)) {
                ?>
                    <div class="alert alert-warning col-sm-11 m-1" style="text-align: center;">
                        <h3>Achtung!</h3>
                        <p>Bitte geben Sie einen g??ltigen Grund ein!</p>
                        <p>??berweisung wurde Abgebrochen!</p>
                    </div>
                <?php
                } else if (validateAmount($amount) && validateReason($reason) && !validateIBAN($recieveinguserIBAN)) {
                ?>
                    <div class="alert alert-warning col-sm-11 m-1" style="text-align: center;">
                        <h3>Achtung!</h3>
                        <p>Bitte geben Sie einen g??ltigen IBAN ein!</p>
                        <p>??berweisung wurde Abgebrochen!</p>
                    </div>
                <?php
                } else {
                ?>
                    <div class="alert alert-warning col-sm-11 m-1" style="text-align: center;">
                        <h3>Achtung!</h3>
                        <p>Der zu ??berweisende Betrag muss Gr????er als 0??? sein!</p>
                        <p>??berweisung wurde Abgebrochen!</p>
                    </div>
            <?php
                }
            }
            if (isset($_POST['transactionHistory'])) {
                require_once 'ebankingHistorie.php';
                buildHistorieEbanking();
            }
            ?>

        </div>

</html>