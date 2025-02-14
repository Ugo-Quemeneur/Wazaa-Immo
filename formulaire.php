<?php 
include "header.php";
?> <!-- A adapter por contact -->
    <table id="table">
        <tr class="line">
            <td class="txt cel">Nom :</td>
            <td class="cel"><input class="input" id="nom"></td>
            <td class="cel" id="cel1"></td>
        </tr>
        <tr class="line">
            <td class="txt">Prénom :</td>
            <td><input class="input" id="prenom"></td>
            <td id="cel2"></td>
        </tr>
        <tr class="line">
            <td class="txt">Date de Naissance :</td>
            <td><input class="input" id="datenaissance"></td>
            <td id="cel3"></td>
        </tr>
        <tr class="line">
            <td class="txt">Email :</td>
            <td><input class="input" id="email"></td>
            <td id="cel4"></td>
        </tr>
        <tr class="line">
            <td class="txt">Code Confidentiel :</td>
            <td><input class="input" placeholder="FR12345ABCx" id="code"></td>
            <td id="cel5"></td>
        </tr>
        <tr class="line">
            <td class="butplaces"><button class="but" id="send">Envoyer</button></td>
            <td class="butplaces"><button class="but" id="cancel">Annuler</button></td>
            <td></td>
        </tr>
    </table>
    <script src="Scripts/script.js"></script>
</body>
</html>