# projet_grp10 - Spotifly
##### Création d'un site web de streaming musical

## Installation

### Prérequis
* Connectez-vous à votre VM en ssh avec la commande `ssh <username>@<ip>`

* Faites les mise à jour avec la commande `sudo apt update` puis `sudo apt upgrade`
* Installez apache2 avec la commande `sudo apt install apache2`
* Installez php avec la commande `sudo apt install php`
* Installez postgresql avec la commande `sudo apt install postgresql`
* Installez pgsql avec la commande `sudo apt install php-pgsql`
* Installez git avec la commande `sudo apt install git`

### Installation du projet
* Clonez le projet avec la commande `git clone https://github.com/WanDayoMollets/projet_grp10.git`

### Configuration de la base de données
* Connectez-vous à postgresql avec la commande `sudo -u postgres psql`

* Créez une base de données avec la commande `CREATE DATABASE spotifly;`

* Créez un utilisateur avec la commande `CREATE USER spotifly WITH PASSWORD 'spotifly';` *(il est vivement recommandé de changer le mot de passe)*

* Donnez les droits à l'utilisateur sur la base de données avec la commande `GRANT ALL PRIVILEGES ON DATABASE spotifly TO spotifly;`

* Quittez postgresql avec la commande `\q`

* Importez le fichier `creation.sql` dans la base de données avec la commande `psql -U spotifly -d spotifly -f creation.sql`

* Importez le fichier `insertion.sql` dans la base de données avec la commande `psql -U spotifly -d spotifly -f insertion.sql`

### Configuration du site
* Déplacez le dossier du projet dans le dossier html avec la commande `sudo mv ~/projet_grp10/. /var/www/html/`

* Modifiez le fichier `constants.php` avec les informations de votre base de données

* Modifier le fichier `000-default.conf` avec la commande `sudo nano /etc/apache2/sites-enabled/000-default.conf` et ajoutez les lignes suivantes :
```
<VirtualHost <votreIP>:80>

<Directory /var/www/html/web>
    Options -Indexes 
    AllowOverride All
    Require all granted
    DirectoryIndex connexion.php
</Directory>
```

* Redémarrez apache2 avec la commande `sudo service apache2 restart`

* Connectez-vous au site avec l'adresse `<votreIP>` et le port `80`

## Connexion

### Identifiants

#### VM
* Utilisateur : `user1` / Mot de passe : `groupe10` / Adresse IP : `10.10.51.80`

### Utilisateurs du site
* Utilisateur1 : `user1@example.com` / Mot de passe : `1234`
* Utilisateur2 : `user2@example.com` / Mot de passe : `1234`



