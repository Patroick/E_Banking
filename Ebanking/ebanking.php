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

    require_once("../Database/datenbank.php");
    require("../Database/transaktionen.php");

    $db = new Database();
    $tran = new Transaktionen();

    if (isset($_GET['id']) && $_SESSION['isLoggedIn'][$_GET['id']] == true) {
        $id = $_GET['id'];
        $data = $db->getAccountData($id);
        $_SESSION['getData'] = $data;
    } else if ($_SESSION['isLoggedIn']['id'] == false) {
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
                <img src="../Img/unknown.png" alt="Profilbild" style="width: 6em; height: 6em">
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
                    <button type="submit" name="transaction" class="btn btn-primary">Überweisung</button></br></br>
                </form>
                <form name="transactionHistory" action="ebanking.php?id=<?php echo $_SESSION['getData']['id']; ?>" method="post">
                    <button type="submit" name="transactionHistory" class="btn btn-secondary" style="background-color: green">Überweisungshistorie</button></br></br>
                </form>
            </div>
            <div class="col-sm-5 border rounded m-1 p-3" style="max-height: 22em">
                <h3>Letzte Transaktionen</h3>
                <div class="table-responsive" style="max-height: 17em">
                    <table class="table table-hover">
                        <thead class="thead-dark" style="position: sticky;">
                            <tr>
                                <th scope="col">Datum</td>
                                <th scope="col">Empfänger</td>
                                <th scope="col">Betrag</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>12.12.2021</td>
                                <td>AT-123465436324</td>
                                <td>-350.00€</td>
                            </tr>
                            <tr>
                                <td>15.12.2021</td>
                                <td>AT-12309638324</td>
                                <td>-100.00€</td>
                            </tr>
                            <tr>
                                <td>01.02.2022</td>
                                <td>AT-12348395324</td>
                                <td>700.00€</td>
                            </tr>
                            <tr>
                                <td>01.02.2022</td>
                                <td>AT-12348395324</td>
                                <td>700.00€</td>
                            </tr>
                            <tr>
                                <td>01.02.2022</td>
                                <td>AT-12348395324</td>
                                <td>700.00€</td>
                            </tr>
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
                            <input type="text" class="form-control" id="recipient" name="recipient" value="<?= htmlspecialchars("") ?>" placeholder="AT-XXXXXXXXXXXXXXXXXX">
                        </div>
                        <div class="form-group pt-2 pb-1">
                            <label for="amount">Betrag in €</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="<?= htmlspecialchars("") ?>" placeholder="0.00">
                        </div>
                        <div class="form-group pt-2 pb-1">
                            <label for="reason">Zweck</label>
                            <input type="text" class="form-control" id="reason" name="reason" value="<?= htmlspecialchars("") ?>" placeholder="Schwarzgeld">
                        </div>
                        <button type="submit" name="transfer" class="btn btn-primary mb-2 mt-2">Überweisen</button>
                    </div>
                </form>
            <?php
            }
            if (isset($_POST['transfer'])) {
                $sendinguserId = isset($_SESSION['getData']['id']) ? $_SESSION['getData']['id'] : '';
                $recieveinguserIBAN = isset($_POST['recipient']) ? $_POST['recipient'] : '';
                $amount = isset($_POST['amount']) ? $_POST['amount'] : '';
                $reason = isset($_POST['reason']) ? $_POST['reason'] : '';
                $tran->makeTransaction($amount, $sendinguserId, $recieveinguserIBAN, $reason);
            }
            if (isset($_POST['transactionHistory'])) { ?>
                <div class="col-sm-11 border rounded m-1 p-3" style="max-height: 30em">
                    <h2 style="text-align: center">Überweisungshistorie</h2>
                        <div class="row ">
                            <div class="col-sm-2">
                                <form name="sortByDate" action="adminebanking.php" method="post">
                                    <label for="sortByDate">Von</label>
                                    <input type="date" name="sortByDate" class="form-control">
                                    <label for="sortByDate">Bis</label>
                                    <input type="date" name="sortByDate" class="form-control">
                                </form>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <form name="sortByText" action="adminebanking.php" method="post">
                                        <label for="sortByText">IBAN</label>
                                        <input type="text" name="sortByText" class="form-control" placeholder="AT-XXXXXXXXXXXXXXXXXX">
                                    </form>
                                    <form name="sortByText" action="adminebanking.php" method="post">
                                        <label for="sortByText">BIC</label>
                                        <input type="text" name="sortByText" class="form-control" placeholder="ING-DIBA">
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row">
                                    <form name="sortByReason" action="adminebanking.php" method="post">
                                        <label for="sortByReason">Zweck</label>
                                        <input type="text" name="sortByReason" class="form-control" placeholder="Schwarzgeld">
                                    </form>
                                    <form name="sortByReference" action="adminebanking.php" method="post">
                                        <label for="sortByReference">Zahlungsreferenz</label>
                                        <input type="text" name="sortByReference" class="form-control" placeholder="1100XXXXXXXX">
                                    </form>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <form name="sortByDate" action="adminebanking.php" method="post">
                                    <label for="sortByAmount">Min</label>
                                    <input type="text" name="sortByAmount" class="form-control" placeholder="0.00">
                                    <label for="sortByAmount">Max</label>
                                    <input type="text" name="sortByDate" class="form-control" placeholder="0.00">
                                </form>
                            </div>

                        </div>
                        <div class="table-responsive mt-3" style="max-height: 17em">
                            <table class="table table-hover table-striped">
                                <thead class="thead-dark" style="position: sticky;">
                                    <tr>
                                        <th scope="col">Datum</td>
                                        <th scope="col">Sender</td>
                                        <th scope="col">BIC</td>
                                        <th scope="col">Empfänger</td>
                                        <th scope="col">BIC</td>
                                        <th scope="col">Zahlungsreferenz</td>
                                        <th scope="col">Zweck</td>
                                        <th scope="col">Betrag</td>
                                    </tr>
                                </thead>
                                <?php $tran->getTableRecentTransactionsUser(isset($_SESSION['getData']['id'])) ?>
                            </table>
                        </div>

                </div>



            <?php
            }
            ?>

        </div>

</html>