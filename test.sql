DROP TABLE IF EXISTS recemment_ecouter;
DROP TABLE IF EXISTS appartient;
DROP TABLE IF EXISTS favoris;
DROP TABLE IF EXISTS playlist;
DROP TABLE IF EXISTS morceau;
DROP TABLE IF EXISTS album;
DROP TABLE IF EXISTS artiste;
DROP TABLE IF EXISTS utilisateur;



CREATE TABLE utilisateur(
        id         Serial  NOT NULL ,
        mail       Varchar (50) NOT NULL ,
        motdepasse Varchar (100) NOT NULL ,
        nom        Varchar (50) NOT NULL ,
        prenom     Varchar (50) NOT NULL ,
        age        date NOT NULL
	,CONSTRAINT utilisateur_PK PRIMARY KEY (id)
);


CREATE TABLE artiste(
        num_artiste Serial  NOT NULL ,
        nom         Varchar (50) NOT NULL ,
        type        Varchar (50) NOT NULL
	,CONSTRAINT artiste_PK PRIMARY KEY (num_artiste)
);


CREATE TABLE album(
        num_album      Serial  NOT NULL ,
        titre          Varchar (50) NOT NULL ,
        datedeparution date NOT NULL ,
        image          Varchar (50) NOT NULL ,
        style          Varchar (50) NOT NULL ,
        num_artiste    Int NOT NULL
	,CONSTRAINT album_PK PRIMARY KEY (num_album)

	,CONSTRAINT album_artiste_FK FOREIGN KEY (num_artiste) REFERENCES artiste(num_artiste)
);


CREATE TABLE morceau(
        num_morceau serial  NOT NULL ,
        titre       Varchar (50) NOT NULL ,
        duree       Time NOT NULL ,
        lien        Varchar (100) NOT NULL ,
        num_album   Int NOT NULL ,
        num_artiste Int NOT NULL
	,CONSTRAINT morceau_PK PRIMARY KEY (num_morceau)

	,CONSTRAINT morceau_album_FK FOREIGN KEY (num_album) REFERENCES album(num_album)
	,CONSTRAINT morceau_artiste0_FK FOREIGN KEY (num_artiste) REFERENCES artiste(num_artiste)
);


CREATE TABLE playlist(
        num_playlist Serial  NOT NULL ,
        nom          Varchar (50) NOT NULL ,
        datecreation date NOT NULL ,
        id           Int NOT NULL
	,CONSTRAINT playlist_PK PRIMARY KEY (num_playlist)

	,CONSTRAINT playlist_utilisateur_FK FOREIGN KEY (id) REFERENCES utilisateur(id)
);


CREATE TABLE favoris(
        num_morceau Int NOT NULL ,
        id          Int NOT NULL
	,CONSTRAINT favoris_PK PRIMARY KEY (num_morceau,id)

	,CONSTRAINT favoris_morceau_FK FOREIGN KEY (num_morceau) REFERENCES morceau(num_morceau)
	,CONSTRAINT favoris_utilisateur0_FK FOREIGN KEY (id) REFERENCES utilisateur(id)
);


CREATE TABLE appartient(
        num_playlist Int NOT NULL ,
        num_morceau  Int NOT NULL ,
        dateajout    date NOT NULL
	,CONSTRAINT appartient_PK PRIMARY KEY (num_playlist,num_morceau)

	,CONSTRAINT appartient_playlist_FK FOREIGN KEY (num_playlist) REFERENCES playlist(num_playlist)
	,CONSTRAINT appartient_morceau0_FK FOREIGN KEY (num_morceau) REFERENCES morceau(num_morceau)
);


CREATE TABLE recemment_ecouter(
        num_morceau Int NOT NULL ,
        id          Int NOT NULL
	,CONSTRAINT recemment_ecouter_PK PRIMARY KEY (num_morceau,id)

	,CONSTRAINT recemment_ecouter_morceau_FK FOREIGN KEY (num_morceau) REFERENCES morceau(num_morceau)
	,CONSTRAINT recemment_ecouter_utilisateur0_FK FOREIGN KEY (id) REFERENCES utilisateur(id)
);


