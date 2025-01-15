function display_music_player(event){
    let id = event.target.id;
    if (id === ""){
        return;
    }
    console.log(id)
    let morceau = event.target.textContent.split(' - ')[0];
    let artiste = event.target.textContent.split(' - ')[1];
    let album = 'c';
    let source = 'd';
    console.log('Morceau sélectionné :', id);
    let musicPlayer = document.getElementById('music_player');
    let close = document.createElement('p');
    close.id = 'close';
    close.textContent = 'close';
    close.addEventListener('click',closePlayer)
    musicPlayer.innerHTML = '<p id="infos_player">'+morceau+'<br>'+artiste+'</p><audio id="audioPlayer" controls="controls">' +
        '<source src="../music/'+id+'.ogg" type="audio/ogg"></audio></div>';
    musicPlayer.appendChild(close);
    musicPlayer.classList.remove('d-none');
    document.getElementById('audioPlayer').play();
    addToUserHistory(id);
    setTimeout(ajaxRequest('GET','principale.php?request=cardsRecemmEc',displayCardsDerniereEcoutes),2000);
    
}

function closePlayer(){
    document.getElementById('audioPlayer').pause();
    document.getElementById('music_player').classList.add('d-none');
}

function addToUserHistory(num_morceau) {
    let url = 'principale.php';
    let params = new URLSearchParams();
    params.append('request', 'addToUserHistory');
    params.append('num_morceau', num_morceau);

    fetch(url, {
        method: 'POST',
        body: params
    })
    .then(response => {
        if (response.ok) {
            return response.json();
        } else {
            throw new Error('Erreur lors de la requête AJAX');
        }
    })
    .then(data => {
        console.log('Morceau ajouté à l\'historique:', num_morceau);
        refreshCardsDerniereEcoutes();
    })
    .catch(error => {
        console.log(error);
    });
}

function refreshCardsDerniereEcoutes() {
    ajaxRequest('GET', 'principale.php?request=cardsRecemmEc', displayCardsDerniereEcoutes);
}



