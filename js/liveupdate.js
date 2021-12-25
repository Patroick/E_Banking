function startDateUpdate() {
    write('startDateUpdate');
}

function endDateUpdate() {

}

function ibanUpdate(iban) {
    if(str.lenght==0) {
        document.getElementById('iban').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('iban').innerHTML=this.responseText;
                xmlhttp.open("POST", "index.php", true);
            }
        };
        xmlhttp.send();
    }
}

function bicUpdate(bic) {
    if(bic.lenght==0) {
        document.getElementById('bic').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('bic').innerHTML=this.responseText;
            }
        };
        xmlhttp.open("POST", "index.php", true);
        console.log("testitest");
        xmlhttp.send();
    }
}

function reasonUpdate() {

}

function referenceUpdate() {

}

function minAmountUpdate() {

}

function maxAmountUpdate() {

}