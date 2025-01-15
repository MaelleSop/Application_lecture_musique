<?php
    session_start();
    $id_utilisateur = $_SESSION['id_utilisateur'];
?>

<!DOCTYPE html>

<html lang="fr">
    <head>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
        <link rel="stylesheet" href="accueil.css"/>
        <script src="ajax.js" defer></script>
        <script src="principale.js" defer></script> 
        <script src="script.js" defer></script>
    </head>
    
    <body>
        <header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light" >
                <a class="navbar-brand"> Menu</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-item nav-link" href="accueil.php">Accueil</a>
                        <a class="nav-item nav-link" href="profil.php">Profil </a>
                        <a class="nav-item nav-link" href="connexion.php">Me deconnecter</a>
                    </div>
                </div>
            </nav>
        </header>

        <section id="errors">
            <div class="alert alert-danger" role="alert" id="error" style="display: none;">
                <p id="error_message"></p>
            </div>
        </section>

        <div class="box" id="box1">
            <nav class="navbar navbar-light bg-light">
                    <input class="form-control mr-sm-2" id="search" name="search" type="search" placeholder="Rechercher" aria-label="Search">
                    <label for="filtre">Filtres :</label> 
                    <select name="filtres" id="filtre"> 
                        <option value="artiste">Artiste</option> 
                        <option value="album">Album</option> 
                        <option value="morceau">Morceau</option> 
                    </select>
                    <br>
                    <br>
                    <button class="btn btn-secondary my-2 my-sm-0" id='btnRechercher' name='btnRechercher' type="submit">Rechercher</button>
            </nav>
        
        </div>
        
        
        <div class="container" id="cards">
        
            <div class="box" id="box2">
            </div>
    
            <div class="box" id="box3">
            </div>
    
            <div class="box" id="box4">
            </div>
        </div>
        <div id="music_player" class="d-none"></div>

        <footer>

        </footer>

    </body>

</html>
