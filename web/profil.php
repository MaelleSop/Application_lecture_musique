<?php
  require_once('../lib/fonction.php');

  ini_set('display_errors', 1);
  error_reporting(E_ALL);

  $db = dbConnect();

  session_start();
  $id = $_SESSION['id_utilisateur'];
?>

<!-- Inclusion des fichiers nécessaires -->
<head>
  <link rel="stylesheet" href="profil.css">
  <script src="ajax.js" defer></script>
  <script src="profil.js" defer></script> 

  <title>Votre profil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@40,400,0,0">
</head>

<body>
  <!-- Barre de navigation -->
  <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" >
      <div class="container">
        <div class="col-3">
          <a class="navbar-brand" href="accueil.php">
            <span class="material-symbols-outlined">home</span>
          </a>
        </div>
        <div class="row">
          <div class="col-6">
            <h4 class="navbar-brand text-center">Votre profil</h4>
          </div>
        </div>
        <div class="col-3"></div> 
      </div>
    </nav>
  </header>

  <!-- Formulaire de modification du profil -->
  <div class="row">
    <div class="col-2"></div>
    <div class="col-8">
    <div id='photo'>
        <img id='profile_picture' src="" alt="Photo de profil">
          <div class="form-group">
            <label for="pp">Lien de votre photo de profil</label>
            <input type="text" class="form-control" id="pp" placeholder="Profile_picture" name="pp" value="">
          </div>
      </div>
      <div class="row">
        <div class="col-6"><br>
          <div class="form-group">
            <label for="nom">Votre Nom</label>
            <input type="text" class="form-control" id="nom" placeholder="Nom" name="nom" value="">
          </div><br>
          <div class="form-group" >
            <label for="mail">Votre Mail</label>
            <input type="text" class="form-control" id="mail" placeholder="Mail" name="mail" value="">
          </div><br>
          <div class="form-group">
            <label for="motdepasse">Votre Mot de passe</label>
            <input type="password" class="form-control" id="motdepasse" placeholder="Mot de passe" name="motdepasse">
          </div><br>
          <div class="form-group">
            <label for="motdepasse_confirmation">Confirmer votre Mot de passe</label>
            <input type="password" class="form-control" id="motdepasse_confirmation" placeholder="Mot de passe (confirmation)" name="motdepasse_confirmation">
          </div>
        </div>
        <div class="col-6"><br>
          <div class="form-group">
            <label for="prenom">Votre Prenom</label>  
            <input type="text" class="form-control" id="prenom" placeholder="Prenom" name="prenom" value=""> 
          </div><br>
          <div class="form-group">
            <label for="date_naissance">Votre Date de naissance</label>
            <input type="date" class="form-control" id="date_naissance" placeholder="Date de naissance" name="date_naissance" value="">
          </div>
          <!-- Affichage de l'âge -->
          <div class="row">
            <div class="col-4"></div>
            <div class="col-8"> 
            <div class="form-group">
            <div class="box" id="votreAge"></div>
          </div><br><br>
          </div>   
          
          <!-- Bouton pour modifier son profil -->
          <div class="row">
            <div class="col-5"></div>
            <div class="col-7"> 
            <button class="btn btn-secondary btn-sm" id='modifier' name='modifier' type="submit">Modifier</button>
          </div>          
        </div>
      </div>
    </div>
    <div class="col-3"></div>
  </div>
  
  <!-- Bouton pour effacer l'historique d'écoute -->
  <div class="row">
    <div class="col-5"></div>
    <div class="col-7"><br><br>
      <button class="btn btn-secondary btn-sm" id='supprimer' name='supprimer' type="submit">Effacer l'historique d'écoute</button>
    </div>
  </div><br>

  <!-- Informations sur les actions éffectuées -->
  <div class="box" id="ModifierProfil"></div>
  <div class="box" id="deleteEcoute"></div>
</body>
</html>

