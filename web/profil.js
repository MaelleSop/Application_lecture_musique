// Initialisation des informations de l'utilisateur sur la page
function getInformations() {
    ajaxRequest('GET','profilAJAX.php?request=nom',displayNom);
    ajaxRequest('GET','profilAJAX.php?request=prenom',displayPrenom);
    ajaxRequest('GET','profilAJAX.php?request=mail',displayMail);
    ajaxRequest('GET','profilAJAX.php?request=date_naissance',displayDatedenaissance);
    ajaxRequest('GET','profilAJAX.php?request=profile_picture',displayPp);
}


// fonction displayNom qui permet d'afficher le nom de l'utilisateur
function displayNom(data){
    let result = document.getElementById('nom')
    result.value = data['nom'];
}

// fonction displayPp qui permet d'afficher la photo de profil de l'utilisateur
function displayPp(data){
    console.log(data['profile_picture']);
    let result = document.getElementById('pp')
    let img = document.getElementById('profile_picture');
    if (data['profile_picture'] == null){
        data['profile_picture'] = "https://www.pngkey.com/png/detail/230-2301779_best-classified-apps-default-user-profile.png";
    }
    result.value = data['pp'];
    img.src = data['profile_picture'];
}

// fonction displayPrenom qui permet d'afficher le prenom de l'utilisateur
function displayPrenom(data){
    let result = document.getElementById('prenom')
    result.value = data['prenom'];
}

// fonction displayMail qui permet d'afficher le mail de l'utilisateur
function displayMail(data){
    let result = document.getElementById('mail')
    result.value = data['mail'];
}

// fonction displayDatedenaissance qui permet d'afficher la date de naissance de l'utilisateur
function displayDatedenaissance(data){
    let result = document.getElementById('date_naissance');
    result.value = data["age"];

    let ageResult = document.getElementById('votreAge');
    ageResult.innerHTML = "<br>Votre âge : " + calculateAge(data["age"]) + " ans";
}

// fonction putInformations qui permet de modifier les informations du profil de l'utilisateur
function putInformations(event){
    event.preventDefault();
    let nom = document.getElementById('nom').value;
    let prenom = document.getElementById('prenom').value;
    let mail = document.getElementById('mail').value;
    let date_naissance = document.getElementById('date_naissance').value;
    let motdepasse = document.getElementById('motdepasse').value;
    let pp = document.getElementById('pp').value;
    let motdepasse_confirmation = document.getElementById('motdepasse_confirmation').value;

    let result = document.getElementById('ModifierProfil');
    if (nom != "" && pp != "" && prenom != "" && date_naissance != "" && mail != "" && motdepasse != ""){
        if (motdepasse == motdepasse_confirmation){
            result.innerHTML = "<div class='alert alert-success' role='alert'>Votre profil a bien été modifié !</div>"
            ajaxRequest('PUT','profilAJAX.php?request=PUT&nom='+nom+'&prenom='+prenom+'&mail='+mail+'&date_naissance='+date_naissance+'&motdepasse='+motdepasse+'&pp='+pp, getInformations);
        } else {
            result.innerHTML = "<div class='alert alert-danger' role='alert'>mot de passe incorrect !</div>";
        }
    } else {
        result.innerHTML = "<div class='alert alert-danger' role='alert'>Informations manquantes !</div>";
    }
}

// fonction deleteHistorique qui permet de supprimer l'historique d'ecoute de l'utilisateur
function deleteHistorique(event){
    event.preventDefault();
    ajaxRequest('DELETE','profilAJAX.php?request=delete');
    let result = document.getElementById('deleteEcoute')
    result.innerHTML = "<div class='alert alert-success' role='alert'>Votre historique d'ecoute a bien été éffacé !</div>";
}

// fonction calculateAge qui permet de calculer l'age de l'utilisateur
function calculateAge(date) {
    const today = new Date();
    const date_naissance = new Date(date);
    let age = today.getFullYear() - date_naissance.getFullYear();
    const month = today.getMonth() - date_naissance.getMonth();
    if (month < 0 || (month === 0 && today.getDate() < date_naissance.getDate())) {
        age--;
    }
    return age;
}


// chargement des informations de l'utilisateur sur la page
getInformations();


// Evenements gerant les boutons
const modifier = document.querySelector('#modifier');
modifier.addEventListener("click", putInformations);

const supprimer = document.querySelector('#supprimer');
supprimer.addEventListener("click", deleteHistorique);


