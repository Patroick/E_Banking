<?php
require_once 'ebanking.php';

function buildHistorieEbanking()
{
    $tran = new Transaktionen();
?>
    <div class="col-sm-11 border rounded m-1 p-3" style="max-height: 30em">
        <h2 style="text-align: center">Überweisungshistorie</h2>

        <form name="sort" action="ebanking.php?id=<?php echo $_SESSION['getData']['id']; ?>" method="post">
            <div class="row ">
                <div class="col-sm-2">
                    <label for="sortByStartDate">Von</label>
                    <input type="date" name="sortByStartDate" id="startDate" class="form-control" onkeyup="startDateUpdate(startDate)">
                    <label for="sortByEndDate">Bis</label>
                    <input type="date" name="sortByEndDate" id="endDate" class="form-control">

                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="sortByIBAN">IBAN</label>
                        <input type="text" name="sortByIBAN" id="iban" class="form-control" placeholder="AT-XXXXXXXXXXXXXXXXXX" onkeyup="ibanUpdate(iban)">

                        <label for="sortByBIC">BIC</label>
                        <input type="text" name="sortByBIC" id="bic" class="form-control" placeholder="ING-DIBA" onkeyup="bicUpdate(bic)">

                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row">
                        <label for="sortByReason">Zweck</label>
                        <input type="text" name="sortByReason" id="reason" class="form-control" placeholder="Rechnung" onkeyup="reasonUpdate(reason)">

                        <label for="sortByReference">Zahlungsreferenz</label>
                        <input type="text" name="sortByReference" id="reference" class="form-control" placeholder="wQhMr8WjNGT7n1GSbKzalSpp3t77RtTRKeJ" onkeyup="referenceUpdate(reference)">

                    </div>
                </div>
                <div class="col-sm-2">

                    <label for="sortByMinAmount">Min</label>
                    <input type="text" name="sortByMinAmount" id="minAmount" class="form-control" placeholder="0.00" onkeyup="minAmountUpdate(minAmount)">
                    <label for="sortByMaxAmount">Max</label>
                    <input type="text" name="sortByMaxAmount" id="maxAmount" class="form-control" placeholder="0.00" onkeyup="maxAmountUpdate(maxAmount)">

                </div>
            </div>
            <div>
                <button type="submit" name="sort" class="btn btn-primary mb-2 mt-3 float-end">Sortieren</button></br></br>

            </div>
        </form>
        <div class="table-responsive mt-3" style="max-height: 17em">
            <table class="table table-hover table-striped" id="tableHistorie">
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
                <?php
                if ($tran->idIsSender($_GET['id']) || $tran->idIsRecipient($_GET['id'])) {
                    if (isset($_POST['sort'])) {
                        
                        buildHistorieEbanking();
                        $testi = $_POST['sort']['sortByIban'];
                        //$tran->getTableFiltered();
                    } else {
                        $tran->getTableRecentTransactionsAllUser($_GET['id']);
                    }
                }
                ?>
            </table>
        </div>

    </div>
<?php
}
?>