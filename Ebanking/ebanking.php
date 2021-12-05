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
            <div class="col-md-12">
                <h1>E-Banking App</h1>
            </div>
        </div>

        <div class="row">

            <div class="col-sm-3 border rounded m-1" style="text-align: center">
                <h3> Ihr Profil </h3>
                <img src="../Img/unknown.png" alt="Profilbild" style="width: 6em; height: 6em">
                <p class="pt-3">Huber Robert</p>
                <p>hu.rob@tsn.at</p>
                <button type="button" class="btn btn-primary">Ausloggen</button>
            </div>

            <div class=" col-sm-3 border rounded m-1 text-truncate" style="text-align: center">
                <h3>Ihr Konto</h3>
                <p>AT-411100000237571500</p>
                <p>Spar-Konto</p>
                <p>Kontostand: 0,00 €</p>
                <button type="button" class="btn btn-primary">Überweisung</button>
            </div>
            <div class="col-sm-5 border rounded m-1">
                <h3>Transaktionen</h3>
                <table>
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</html>