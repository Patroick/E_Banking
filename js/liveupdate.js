function startDateUpdate(startDate) {
   if(startDate.lenght==0) {
        document.getElementById('startDate').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('startDate').innerHTML=this.responseText;
            }
        };
        xmlhttp.open("GET", "../Ebanking/ebanking.php?id=$_GET['id']", true);
        console.log("startDate testitest");
        xmlhttp.send();
    }
}

function endDateUpdate() {

}

function ibanUpdate(iban) {
    if(iban.lenght==0) {
        document.getElementById('iban').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('iban').innerHTML=this.responseText;
            }
        };
        xmlhttp.open("GET", "../Ebanking/ebanking.php?id=$_GET['id']", true);
        $.get( "test.php", function( data ) {
            alert( "Data Loaded: " + data );
        });
        console.log("iban testitest");
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
        xmlhttp.open("POST", "../index.php", true);
        console.log("bic testitest");
        xmlhttp.send();
    }
}

function reasonUpdate(reason) {
    if(reason.lenght==0) {
        document.getElementById('reason').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('bic').innerHTML=this.responseText;
            }
        };
        xmlhttp.open("POST", "../index.php", true);
        console.log("reason testitest");
        xmlhttp.send();
    }
}

function referenceUpdate(reference) {
    if(reference.lenght==0) {
        document.getElementById('reference').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('bic').innerHTML=this.responseText;
            }
        };
        xmlhttp.open("POST", "../index.php", true);
        console.log("reference testitest");
        xmlhttp.send();
    }
}

function minAmountUpdate(minAmount) {
    if(minAmount.lenght==0) {
        document.getElementById('minAmount').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('bic').innerHTML=this.responseText;
            }
        };
        xmlhttp.open("POST", "../index.php", true);
        console.log("min Amount testitest");
        xmlhttp.send();
    }
}

function maxAmountUpdate(maxAmount) {
    if(maxAmount.lenght==0) {
        document.getElementById('maxAmount').innerHTML=="";
        return;
    } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if(this.readyState == 4 && this.status==200){
                document.getElementById('bic').innerHTML=this.responseText;
            }
        };
        xmlhttp.open("POST", "../index.php", true);
        console.log("max Amount testitest");
        xmlhttp.send();
    }
}