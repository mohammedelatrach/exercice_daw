<?php
session_start();

include("modele/Client.php");

if (!isset($_SESSION['connecter'])) {
    $_SESSION['connecter'] = false;
}

if (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['nom']) && !empty($_POST['datenaissance']) && !empty($_POST['addresse']) && !empty($_POST['numero_telephone'])) {
    $client = new Client();
    try {
        $client->inscription($_POST['nom'], $_POST['username'], $_POST['datenaissance'], $_POST['addresse'], $_POST['password'], $_POST['numero_telephone']);
        // Redirection ou message de succès
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="CSS/bootstrap/css/bootstrap.min.css"/>
<link rel="stylesheet" href="CSS/theme.css"/>
<!-- Inclure le CSS de intl-tel-input -->
<link rel="stylesheet" href="node_modules/intl-tel-input/build/css/intlTelInput.css">
<script type="text/javascript" src="node_modules/intl-tel-input/build/js/intlTelInput.min.js"></script>
<title>biblio</title>
</head>
<body>

<div class="jumbotron">
    <div class="col-lg-8">
        <span class="biblio-logo">Biblio</span>
    </div>
    <div class="col-lg-4">
        <div id="logoright">Bibliotheque du web</div>
    </div>
</div>

<div class="col-lg-6">
    <ul class="nav nav-pills">
        <li><a href="index.php">Accueil</a></li>
        <?php 
        if (!$_SESSION['connecter']) {
        ?>
        <li class="active"><a href="inscription.php">Inscription</a></li>
        <?php
        }
        ?>
        <li><a href="reglement.php">Règlement</a></li>
        <li><a href="bibliotheque.php">La bibliothèque</a></li>
    </ul>
</div>

<div class="col-lg-6">
    <div id="iscri">
        <?php 
        if (!$_SESSION['connecter']) {
        ?>
        <form method="post" action="inscription.php">
            <input type="text" name="email" placeholder="Email ou Username" required />
            <input type="password" name="pwd" placeholder="Password" required />
            <input type="submit" value="Login"/>
        </form>  
        <?php
        } else {
        ?> 
        <div class="col-lg-7"></div>
        <div class="col-lg-5">
            <ul class="nav nav-pills">
                <li class="active"><a href="profil.php">Profile</a></li>
                <li><a href="index.php?d=true">Déconnecter</a></li>
            </ul>
        </div>
        <?php
        }
        ?>
    </div> 
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-success panel1">
            <div class="panel-heading">Inscription</div>
            <div class="panel-body">
                <fieldset>
                    <legend><b>Inscription Individuelle</b></legend>
                    <form action="inscription.php" method="post" >
                        <table class="login_table">
                            <tr>
                                <td>Email<span>*</span></td>
                                <td><input type="text" name="username" id="username" placeholder="email or username" required></td>
                            </tr>
                            <tr>
                                <td>Téléphone<span>*</span></td>
                                <td><input class="form-conrtol" type="tel" name="numero_telephone" id="numero_telephone" placeholder="Numéro de téléphone" required ></td>
                            </tr>
                            <tr>
                                <td>Password<span>*</span></td>
                                <td><input type="password" name="password" id="password" placeholder="password" required></td>
                            </tr>
                            <tr>
                                <td>Nom<span>*</span></td>
                                <td><input type="text" name="nom" id="nom" placeholder="Nom" required></td>
                            </tr>
                            <tr>
                                <td>Date de naissance<span>*</span></td>
                                <td><input type="date" name="datenaissance" id="datenaissance" placeholder="AAAA-MM-JJ" required></td>
                            </tr>
                            <tr>
                                <td>Adresse<span>*</span></td>
                                <td><input type="text" name="addresse" id="addresse" placeholder="Adresse" required></td>
                            </tr>
                            <tr>
                                <td><small>Keep Me</small><input type="checkbox" name="keep" value="true"></td>
                                <td><input type="submit" value="Inscription"/><input type="reset" value="Réinitialiser"/></td>
                            </tr>
                        </table>
                    </form>
                </fieldset>
               <!-- <div id="reglement_ecrire">
                    <h2>Carte « Adhérent »</h2>
                    <ul>
                        <li>Une carte « Adhérent » sera délivrée aux usagers n’appartenant pas à l’Université Hassan II de Casablanca. Cette carte doit être présentée à chaque visite de la bibliothèque et est obligatoire pour toute opération de prêt.</li>
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
</div>

<?php
include('composant/footer.php');
?>

<!-- Initialiser intl-tel-input -->
<script>
    var input = document.querySelector("#numero_telephone");
    window.intlTelInput(input, {
        initialCountry: "auto",
        geoIpLookup: function(success, failure) {
            fetch("https://ipinfo.io/json")
                .then(function(response) {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error("Failed to fetch IP info");
                })
                .then(function(ipinfo) {
                    success(ipinfo.country);
                })
                .catch(function() {
                    success("us");
                });
        },
        utilsScript: "node_modules/intl-tel-input/build/js/utils.js"
    });
</script>

</body>
</html>
