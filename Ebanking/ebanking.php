<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>E-Banking App</title>
</head>

<body>

    <div class="container">
        <div class="row" style="text-align: center">
            <div class="col-md-12 mt-3">
                <h1>E-Banking App</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-3 border rounded m-1 pt-3" style="text-align: center; max-height: 25em">
                <h3> Ihr Profil </h3>
                <img src="../Img/unknown.png" alt="Profilbild" style="width: 6em; height: 6em">
                <p class="pt-3">Huber Robert</p>
                <p>hu.rob@tsn.at</p>
                <button type="button" class="btn btn-primary mb-3">Ausloggen</button>
            </div>

            <div class=" col-sm-3 border rounded m-1 text-truncate pt-3" style="text-align: center; max-height: 25em">
                <h3>Ihr Konto</h3>
                <p>AT-411100000237571500</p>
                <?php
                if (isset($_POST['transaction'])) {
                    print_r("here");
                }
                ?>
                <p>Spar-Konto</p>
                <p>Kontostand: 0,00 €</p>
                <form name="transaction" id="transaction" action="ebanking.php" method="post">
                    <button type="submit" class="btn btn-primary">Überweisung</button></br></br>
                </form>
                <form name="addBalance" action="" method="post">
                    <button type="submit" class="btn btn-secondary" style="background-color: green">Geld aufladen</button></br></br>
                </form>
                <form name="removeBalance" action="" method="post">
                    <button type="submit" class="btn btn-secondary mb-3" style="background-color: orange">Geld abheben</button>
                </form>
            </div>
            <div class="col-sm-5 border rounded m-1 p-3" style="max-height: 25em">
                <h3>Transaktionen</h3>
                <div class="table-responsive" style="max-height: 20em">
                    <table class="table table-hover">
                        <thead class="thead-dark">
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
    </div>

</html>