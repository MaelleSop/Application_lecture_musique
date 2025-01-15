function getCards(){
    ajaxRequest('GET','principale.php?request=cardsRecemmEc',displayCardsDerniereEcoutes);
    ajaxRequest('GET','principale.php?request=cardsFav',displayCardsFavoris);
    ajaxRequest('GET','principale.php?request=cardsPlaylist',displayCardsPlaylist);
}

function getRecherche(event){
    event.preventDefault();
    let recherche = document.getElementById('search').value;
    let filtre = document.getElementById('filtre').value;
    if(filtre=='artiste'){
        ajaxRequest('GET','principale.php?request=rechercherArtiste&recherche='+recherche+'&filtre='+filtre,displayRechercheArtiste);
    }
    if(filtre=='album'){
        ajaxRequest('GET','principale.php?request=rechercherArtiste&recherche='+recherche+'&filtre='+filtre,displayRechercheAlbum);
    }
    if(filtre=='morceau'){
        ajaxRequest('GET','principale.php?request=rechercherArtiste&recherche='+recherche+'&filtre='+filtre,displayRechercheMorceau);
    }
}

function getDetails(id){
    let detail = document.getElementById('details').getAttribute("value");
    if(detail=='detailsMorceau'){
        ajaxRequest('GET','principale.php?request=detailsMorceau&id='+id,displayDetailsMorceau);
    }
    if(detail=='detailsAlbum'){
        ajaxRequest('GET','principale.php?request=detailsAlbum&id='+id,displayDetailsAlbum);
    }
    if(detail=='detailsArtiste'){
        ajaxRequest('GET','principale.php?request=detailsArtiste&id='+id,displayDetailsArtiste);
    }
    if(detail=='detailsPlaylist'){
        ajaxRequest('GET','principale.php?request=detailsPlaylist&id='+id,displayDetailsPlaylist);
    }
}

function addFavoris(id_morceau){
    ajaxRequest('POST','principale.php?request=ajouterFavoris&id='+id_morceau);
    ajaxRequest('GET','principale.php?request=cardsRecemmEc',displayCardsDerniereEcoutes);
    ajaxRequest('GET','principale.php?request=cardsFav',displayCardsFavoris);

}

function getForm(num_morceau){
    ajaxRequest('GET','principale.php?request=formPlaylist&num_morceau='+num_morceau,displayForm);
}

function removeFavoris(id_morceau){
    ajaxRequest('DELETE','principale.php?request=supprimerFavoris&id='+id_morceau);
    ajaxRequest('GET','principale.php?request=cardsFav',displayCardsFavoris);
    ajaxRequest('GET','principale.php?request=cardsRecemmEc',displayCardsDerniereEcoutes);
}

function addFavorisFromRecherche(id_morceau){
    ajaxRequest('POST','principale.php?request=ajouterFavoris&id='+id_morceau);
    let recherche = document.getElementById('search').value;
    ajaxRequest('GET','principale.php?request=rechercherArtiste&recherche='+recherche+'&filtre=morceau',displayRechercheMorceau);
}

function removeFavorisFromRecherche(id_morceau){
    ajaxRequest('DELETE','principale.php?request=supprimerFavoris&id='+id_morceau);
    let recherche = document.getElementById('search').value;
    ajaxRequest('GET','principale.php?request=rechercherArtiste&recherche='+recherche+'&filtre=morceau',displayRechercheMorceau);
}

function addMorceauPlaylist(data){
    console.log(data);
    let num_morceau = data[0];
    for(let i=0; i<data[1].length; i++){
        let check = document.getElementById("playlist"+i);
        if(check.checked){
            num_playlist = data[1][i]['num_playlist'];
        }
    }
    console.log('num_playlist'+num_playlist);
    console.log('num_morceau'+num_morceau);
    ajaxRequest('POST','principale.php',function(){console.log('ok');},'request=addinplaylist&num_morceau='+num_morceau+'&num_playlist='+num_playlist);
}


function displayCardsDerniereEcoutes(data){
    console.log(data);
    let result = document.getElementById('box2');
    result.innerHTML = '';
    let lastListened = document.createElement('div');
    lastListened.id = 'lastListened';
    lastListened.className = 'card';
    lastListened.style = 'width: 18rem;';
    lastListened.innerHTML = '<div class="card-header" id="details" value="detailsMorceau" style="background: #AEEDA9;">' +
    '<p>Derniers morceaux écoutés :</p>' +
    '</div>';
    result.appendChild(lastListened);
    let ul = document.createElement('ul');
    result.appendChild(ul);
    ul.classList.add('list-group', 'list-group-flush');
    for(let i=0; i<data.length; i++){
        let el = document.createElement('li');
        el.className = 'list-group-item';
        el.id = data[i]['num_morceau'];
        el.innerHTML = data[i]['titre_morceau']+" - "+data[i]['nom_artiste']+" <a id=it"+i+" value="+data[i]['num_morceau']+" onclick=getDetails("+data[i]['num_morceau']+")><img src='../img/details_morc.png' alt='Icône'></a>";

        el.addEventListener('click',display_music_player);
        ul.appendChild(el);
    }
    result.scrollTop = result.scrollHeight;
}

function addPlaylist(event){
    event.preventDefault();
    let nom_playlist = document.getElementById('new_playlist').value;
    ajaxRequest('POST','principale.php',getCards, "request=new_playlist&nom_playlist="+nom_playlist);
}

function delPlaylist(id){
    ajaxRequest('DELETE','principale.php?request=delPlaylist&id='+id,getCards);
}
 
function delMorceauPlaylist(id_morceau,num_playlist){
    ajaxRequest('DELETE','principale.php?request=delMorceauPlaylist&id_morceau='+id_morceau+'&num_playlist='+num_playlist,getPlaylist(num_playlist));
}

function getPlaylist(id){
    ajaxRequest('GET','principale.php?request=detailsPlaylist&id='+id,displayDetailsPlaylist);
}

function displayCardsFavoris(data){
    let result = document.getElementById('box3');
    result.innerHTML = '';
    let fav = document.createElement('div');
    fav.id = 'fav';
    fav.className = 'card';
    fav.style = 'width: 18rem;';
    fav.innerHTML = '<div class="card-header" id="details" value="detailsMorceau" style="background: #AEEDA9;">' +
    '<p>Morceaux favoris :</p>' +
    '</div>';
    result.appendChild(fav);
    let ul = document.createElement('ul');
    result.appendChild(ul); 
    ul.classList.add('list-group', 'list-group-flush');
    for(let i=0; i<data.length; i++){
        let el = document.createElement('li');
        el.className = 'list-group-item';
        el.id = data[i]['num_morceau'];
        el.innerHTML = data[i]['titre_morceau']+" - "+data[i]['nom_artiste']+" <a  id=it"+i+" value="+data[i]['num_morceau']+" onclick=getDetails("+data[i]['num_morceau']+")><img src='../img/details_morc.png' alt='Icône'></a>";
        el.addEventListener('click',display_music_player);
        ul.appendChild(el);
    }
    result.scrollTop = result.scrollHeight;
}

function displayCardsPlaylist(data){
    let result = document.getElementById('box4');
    let card = '<br><div class="card" style="width: 18rem;" >' +
    '<div class="card-header"  style="background: #AEEDA9;">' +
    '<p>Vos playlists :</p>' +
    '</div>' +
    '<ul class="list-group list-group-flush">';
    for(let i=0; i<data.length; i++){
        card += "<li class='list-group-item'>"+data[i]['nom']+
        "<a id=it"+i+" value="+data[i]['num_playlist']+" onclick=getPlaylist("+data[i]['num_playlist']+")> <img src='../img/details_morc.png' alt='Icône'></a>" +
        "<a id=del"+i+" value="+data[i]['num_playlist']+" onclick=delPlaylist("+data[i]['num_playlist']+")> <img src='../img/poubelle.png' alt='Icone'></a>" + 
        "</li>";
    }
    card +=  '</ul>' + '</div>';
    card += '<div class="card-body">' +
    '<ul class="list-group list-group-flush">';
    card += "<input type='text' id='new_playlist' name='nom_playlist' placeholder='nouvelle playlist'>" + 
    "<button class='btn col-md-1 offset-md-1' id='addPlaylist' type='submit'> <h4><i class='bi bi-plus-square' ></i></h4></button>" 
    card += '</div>' + '</div>';
    result.innerHTML = card;
    result.scrollTop = result.scrollHeight;
    const add = document.querySelector('#addPlaylist');
    add.addEventListener("click",addPlaylist);
}


//Affichage recherche
function displayRechercheArtiste(data){
    console.log(data);
    let result = document.getElementById('cards');
    result.innerHTML = '';
    result.classList.add('displayRecherche');
    let recherche = document.createElement('div');
    recherche.id = 'recherche';
    recherche.className = 'card';
    recherche.style = 'padding: 20px;';
    recherche.innerHTML = '<div class="card-header" id="details" value="detailsArtiste" style="background: #AEEDA9;">' +
    '<p>Résultats :</p>' +
    '</div>';
    result.appendChild(recherche);
    let ul = document.createElement('ul');
    result.appendChild(ul);
    ul.classList.add('list-group', 'list-group-flush');
    for(let i=0; i<data.length; i++){
        let el = document.createElement('li');
        el.className = 'list-group-item';
        el.id = data[i]['num_morceau'];
        el.innerHTML = data[i]['titre_morceau']+" - "+data[i]['nom_artiste']+" <a id=it"+i+" value="+data[i]['num_artiste']+" onclick=getDetails("+data[i]['num_artiste']+")><img src='../img/details_morc.png' alt='Icône'></a>";
        el.addEventListener('click',display_music_player);
        ul.appendChild(el);
    }
    result.scrollTop = result.scrollHeight;
}

function displayRechercheAlbum(data){
    let result = document.getElementById('cards');
    result.innerHTML = '';
    result.classList.add('displayRecherche');
    let recherche = document.createElement('div');
    recherche.id = 'recherche';
    recherche.className = 'card';
    recherche.style = 'padding: 20px;';
    recherche.innerHTML = '<div class="card-header" id="details" value="detailsAlbum" style="background: #AEEDA9;">' +
    '<p>Résultats :</p>' +
    '</div>';
    result.appendChild(recherche);
    let ul = document.createElement('ul');
    result.appendChild(ul);
    ul.classList.add('list-group', 'list-group-flush');
    for(let i=0; i<data.length; i++){
        let el = document.createElement('li');
        el.className = 'list-group-item';
        el.id = data[i]['num_album'];
        el.innerHTML = data[i]['titre']+" - "+data[i]['nom']+"<a id=it"+i+" value="+data[i]['num_album']+" onclick=getDetails("+data[i]['num_album']+")><img src='../img/details_morc.png' alt='Icône'></a>";
        //el.addEventListener('click',afficher_album);
        ul.appendChild(el);
    }
    result.scrollTop = result.scrollHeight;
}

// fonction displayRechercheMorceau permettant d'afficher les résultats de la recherche de morceaux
function displayRechercheMorceau(data) {
    let result = document.getElementById('cards');
    result.innerHTML = '';
    result.classList.add('displayRecherche');
    let recherche = document.createElement('div');
    recherche.id = 'recherche';
    recherche.className = 'card';
    recherche.style = 'padding: 20px;';
    recherche.innerHTML = '<div class="card-header" id="details" value="detailsMorceau" style="background: #AEEDA9;">' +
    '<p>Résultats :</p>' +
    '</div>';
    result.appendChild(recherche);
    let ul = document.createElement('ul');
    result.appendChild(ul);
    ul.classList.add('list-group', 'list-group-flush');
    for(let i=0; i<data.length; i++){
        let el = document.createElement('li');
        el.className = 'list-group-item';
        el.id = data[i]['num_morceau'];
        el.innerHTML = data[i]['titre_morceau']+" - "+data[i]['nom_artiste']+"<a id=it"+i+" value="+data[i]['num_morceau']+" onclick=getDetails("+data[i]['num_morceau']+")><img src='../img/details_morc.png' alt='Icône'></a></a>";
        el.addEventListener('click',display_music_player);
        ul.appendChild(el);    
    }
    result.scrollTop = result.scrollHeight;
}


//Affichage details
function displayDetailsMorceau(data){
    let result = document.getElementById('cards');
    let card = '<div class="card" style="width: 18rem;">' +
    '<div class="card-header" style="background: #AEEDA9;">' +
    "<p>Détails du morceau :</p>" +
    '</div>' +
    '<ul class="list-group list-group-flush">';
    card += "<li class='list-group-item'> Titre du morceau : "+data[0]['titre_morceau']+"</li>" +
    "<li class='list-group-item'> Artiste : "+data[0]['nom']+"</li>" +
    "<li class='list-group-item'> Album : "+data[0]['titre_album']+"</li>" +
    "<li class='list-group-item'> Durée : "+data[0]['duree']+"</li>" +
    '</ul>';
    card += "<a id=add value="+data[0]['num_morceau']+" onclick=getForm("+data[0]['num_morceau']+")><img src='../img/plus.png' alt='Icône'></a>";
    result.innerHTML = card;
    result.scrollTop = result.scrollHeight;
}

function displayDetailsAlbum(data){
    let result = document.getElementById('cards');
    let card = '<div class="card" style="width: 18rem;">' +
    '<img class="card-img-top" src="'+data[0]['image']+'" alt="Card image cap">' +
    '<div class="card-body" tyle="background: #AEEDA9;>'+
    "<p>Détails de l'album :</p>" +
    '</div>' +
    '<ul class="list-group list-group-flush">';
    card += "<li class='list-group-item'> Titre de l'album : "+data[0]['titre']+"</li>";
    card += "<li class='list-group-item'> Artiste : "+data[0]['nom']+"</li>";
    card += "<li class='list-group-item'> Date de parution : "+data[0]['datedeparution']+"</li>";
    card += "<li class='list-group-item'> Style : "+data[0]['style']+"</li>";
    card += '</ul>' + '</div>';
    result.innerHTML = card;
    result.scrollTop = result.scrollHeight;
}

function displayDetailsArtiste(data){
    let result = document.getElementById('cards');
    result.classList.add("displayRecherche");
    result.innerHTML = '<div class="card" style="width: 200px;">' +
    '<div class="card-header" style="background: #AEEDA9;">' +
    "<p>Détails de l'artiste:</p>" +
    '</div>' +
    '<ul class="list-group list-group-flush">';
    result.innerHTML += "<li class='list-group-item'> Nom : "+data[0]['nom']+"</li>";
    result.innerHTML += "<li class='list-group-item'> Type : "+data[0]['type']+"</li>";
    result.innerHTML += "<li class='list-group-item'> Titre des albums : ";
    for(let i=0; i<data.length; i++){
        result.innerHTML += data[i]['titre']+"<br>";
    }
    result.innerHTML += "</li>"; 
    result.innerHTML += '</ul>' + '</div>';
    result.scrollTop = result.scrollHeight;
}

function displayDetailsPlaylist(data){
    let result = document.getElementById('cards');
    let card = '<div class="card" style="width: 18rem;">'+
    '<div class="card-header" style="background: #AEEDA9;">' +
    "<h3>"+data[0]['nom_playlist']+"</h3>" +
    "<p> Date de création : "+data[0]['datecreation']+"</p>" +
    '</div>' +
    '<div class="card-body">' +
    '<ul class="list-group list-group-flush">';
    for(let i=0; i<data.length; i++){
        card += "<li class='list-group-item'>"+data[i]['titre']+" - "+data[i]['nom_artiste']+
        "<a id=del"+i+" value="+data[i]['num_morceau']+" onclick=delMorceauPlaylist("+data[i]['num_morceau']+","+data[i]['num_playlist'] +")> <img src='../img/poubelle.png' alt='Icone'></a>" +"</li>";
    }
    card += '</ul>';
    card += '</div>' + '</div>';
    result.innerHTML = card;
    result.scrollTop = result.scrollHeight;
}


//Affichage formulaire add morceau in playlist
function displayForm(data){
    let result = document.getElementById('cards');
    let affichage = '<div class="card" style="width: 18rem;">'+
    '<div class="card-header" style="background: #AEEDA9;">' +
    '<h3> Ajouter à la playlist : </h3> </div>' + 
    '<div class="card-body">' +
    '<ul class="list-group list-group-flush" style="list-style:none;">';
    for(let i=0; i<data[1].length; i++){
        affichage += '<li> <input type="radio" id="playlist'+i+'" name="playlist" value='+data[1][i]['num_playlist']+'> '+data[1][i]['nom']+ '</li>';
    }
    affichage += '</ul>' +
    "<a id='btnadd'><img src='../img/plus.png' alt='Icône'></a>";
    affichage += '</div>' + '</div>';
    result.innerHTML = affichage;
    result.scrollTop = result.scrollHeight;
    const btn = document.getElementById('btnadd');
    btn.addEventListener("click", function(){
        addMorceauPlaylist(data);
        for(let i=0; i<data[1].length; i++){
            document.getElementById('playlist'+i).checked = false;
        }
    })
}

getCards();

const rechercher = document.querySelector('#btnRechercher');
rechercher.addEventListener("click",getRecherche);
