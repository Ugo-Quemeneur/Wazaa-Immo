// A adapter avec mes variables

let send = getElementById("send");
let cancel = getElementById("cancel");
let nom = getElementById("nom")
let prenom = getElementById("prenom");
let datenaissance = getElementById("datenaissance");
let email = getElementById("email");
let code = getElementById("code");

send.addEventListener("click", Verifications(nom, prenom, datenaissance, email, code));

cancel.addEventListener("click", Effacement())

function Verifications(nom_, prenom_, datenaissance_, email_, code_) {
    let checknames = new RegExp("[\w][\w][\w]+");
    let checkmail =  new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[az0-9])?");
    let checkdatenaissance = new RegExp("/^[0-9][0-9]?\/[0-9][0-9]?\/[0-9][0-9]([0-9][0-9])?$/");
    let checkcode = new RegExp("FR[0-9][0-9][0-9][0-9][0-9][A-Z\-\._][A-Z\-\._][A-Z\-\._]x")
    let check;
    Verification1(checknames, nom_, check);
    if (check == true) {
        Verification2(checknames, prenom_, check);
        if (check == true) {
            Verification3(checkdatenaissance, datenaissance_, check);
            if (check == true) {
                Verification4(checkmail, email_, check);
                if (check == true) {
                    Verification5(checkcode, code_, check);
                }
            }
        }
    }
    if (check == true) {
    alert("Vos données sont valides,elles vont être transmises sur nos serveurs pour traitement\nNous sommes ravis de vous compter parmi nos nouveaux clients");
    }
}

function Verification1(_checknames, _nom, _check) {
    _check = _checknames.test(_nom);
    if (_check == false) {
        let cel1 = getElementById("cel1");
        cel1.innerHTML = '<p class="erreur">3 caractères alphanumériques au minimum !!!</p>'
    }
}

function Verification2(_checknames, _prenom, _check) {
    _check = _checknames.test(_prenom);
    if (_check == false) {
        let cel2 = getElementById("cel2");
        cel2.innerHTML = '<p class="erreur">3 caractères alphanumériques au minimum !!!</p>'
    }
}

function Verification3(_checkdatenaissance, _datenaissance, _check) {
    _check = _checkdatenaissance.test(_datenaissance);
    if (_check == false) {
        let cel3 = getElementById("cel3");
        cel3.innerHTML = '<p class="erreur">Date au format dd/mm/aaaa</p>'
    }
}

function Verification4(_checkmail, _email, _check) {
    _check = _checkmail.test(_email);
    if (_check == false) {
        let cel4 = getElementById("cel4");
        cel4.innerHTML = '<p class="erreur">champ obligatoire</p>'
    }
}

function Verification5(_checkcode, _code, _check) {
    _check = _checkcode.test(_code);
    if (_check == false) {
        let cel5 = getElementById("cel5");
        cel5.innerHTML = '<p class="erreur">FR puis 5 chiffres puis 3 Lettres majuscules et x en suffixe</p>'
    }
}