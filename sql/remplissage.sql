-- Insertion des utilisateur
INSERT INTO utilisateur (mail, motdepasse, nom, prenom, age) VALUES
    ('user1@example.com', '$2y$10$jePPGWGYgPrBG.ELmul5zuzTFUESZVnu5HWCXK1fpwGupI4gfPPKq', 'user1', 'nom1', '12-22-2003'),
    ('user2@example.com', '$2y$10$hD70L2fb/p6AIOpSbofpXes08XBoRLLbRkVfS1STHnV3Rd7OQrv12', 'user2', 'nom2', '04-20-2003');


-- Insertion des artiste
INSERT INTO artiste (num_artiste, nom, type) VALUES 
    (1, 'muse', 'groupe'),
    (2, 'lorenzo', 'chanteur'),
    (3, 'avicci', 'musicien');


-- Insertion des albums
INSERT INTO album (num_album, titre, datedeparution, image, style, num_artiste) VALUES
    (1, 'drones', '06-08-2015', '../cover/drones.jpg', 'rock', 1),
    (2, 'will of the people', '08-26-2022', '../cover/will_of_the_people.jpg', 'rock', 1),
    (3, 'legende vivante', '12-02-2022', '../cover/legende_vivante.jpg', 'rap', 2),
    (4, 'sex in the city', '08-23-2019', '../cover/sex_in_the_city.jpg', 'rap', 2),
    (5, 'true', '09-16-2013', '../cover/true.jpg', 'pop', 3),
    (6, 'stories', '10-02-2015', '../cover/stories.jpg', 'pop', 3);


-- Insertion des morceaux
INSERT INTO morceau (num_morceau, titre, duree, lien, num_album, num_artiste) VALUES
    (1, 'the handler', '00:04:34', '../music/the_handler.ogg', 1, 1),
    (2, 'dead inside', '00:04:23', '../music/dead_inside.ogg', 1, 1),
    (3, 'will of the people', '00:03:19', '../music/will_of_the_people.ogg', 2, 1),
    (4, 'compliance', '00:04:11', '../music/compliance.ogg', 2, 1),
    (5, 'catastrophe', '00:02:19', '../music/catastrophe.ogg', 3, 2),
    (6, 'le kush', '00:02:20', '../music/le_kush.ogg', 3, 2),
    (7, 'impec', '00:02:57', '../music/impec.ogg', 4, 2),
    (8, 'damdamdeo', '00:03:05', '../music/damdamdeo', 4, 2),
    (9, 'wake me up', '00:04:08', '../music/wake_me_up.ogg', 5, 3),
    (10, 'hey brother', '00:04:15', '../music/hey_brother.ogg', 5, 3),
    (11, 'waiting for love', '00:03:50', '../music/waiting_for_love.ogg', 6, 3),
    (12, 'pure grinding', '00:02:52', '../music/pure_grinding.ogg', 6, 3);


-- Insertion des playlists
INSERT INTO playlist (num_playlist, nom, datecreation, id) VALUES
    (1, 'Playlist 1 - user1', '06-12-2020', 1),
    (2, 'Playlist 2 - user1', '06-12-2020', 1),
    (3, 'Playlist 1 - user2', '06-12-2020', 2),
    (4, 'Playlist 2 - user2', '06-12-2020', 2);


-- Insertion des favoris
INSERT INTO favoris (num_morceau, id) VALUES
    (4, 1),
    (7, 1),
    (8, 1),
    (2, 2);


-- Insertion des morceaux dans les playlists
INSERT INTO appartient (num_playlist, num_morceau, dateajout) VALUES
    (1, 1, '06-12-2020'),
    (1, 2, '06-12-2020'),
    (2, 3, '06-12-2020'),
    (2, 4, '06-12-2020'),
    (3, 5, '06-12-2020'),
    (3, 6, '06-12-2020'),
    (4, 7, '06-12-2020'),
    (4, 8, '06-12-2020');


-- Insertion des recements ecoutees
INSERT INTO recemment_ecouter (num_morceau, id) VALUES
    (1, 1),
    (2, 1),
    (3, 1),
    (4, 1),
    (5, 1),
    (6, 1),
    (7, 2),
    (8, 2),
    (9, 2),
    (10, 2),
    (11, 2),
    (12, 2),
    (1, 1),
    (2, 1),
    (3, 1),
    (4, 1),
    (5, 1),
    (6, 1);



