-- phpMyAdmin SQL Dump
-- version 4.5.4.1deb2ubuntu2
-- http://www.phpmyadmin.net
--
-- Client :  localhost
-- Généré le :  Jeu 26 Octobre 2017 à 13:53
-- Version du serveur :  5.7.19-0ubuntu0.16.04.1
-- Version de PHP :  7.0.22-0ubuntu0.16.04.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `simple-mvc`
--

-- --------------------------------------------------------

--
-- Structure de la table `item`
--

CREATE TABLE `item` (
  `id` int(11) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `item`
--

INSERT INTO `item` (`id`, `title`) VALUES
(1, 'Stuff'),
(2, 'Doodads');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `item`
--
ALTER TABLE `item`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `item`
--
ALTER TABLE `item`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;


-------------------------------------------------------------------------------------------
-------------------------------------------------------------------------------------------


-- SQL REQUESTS FOR COMIC_CULT DATABASE -- 

------------------------------------------------------
-- IF YOU HAVE TO DROP ALL THE DATABASE             --
------------------------------------------------------

DROP DATABASE comic_cult;

------------------------------------------------------
-- CREATION AND USE REQUESTS                        --
------------------------------------------------------

CREATE DATABASE comic_cult;

USE comic_cult;

------------------------------------------------------
-- REQUEST FOR 'role' TABLE CREATION                --
------------------------------------------------------

CREATE TABLE role (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    role VARCHAR(80) NOT NULL
    );

------------------------------------------------------
-- REQUEST FOR 'author' TABLE CREATION              --
------------------------------------------------------

CREATE TABLE author (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(100) NOT NULL,
    birth_date DATE,
    editor VARCHAR(100),
    biography TEXT
    );

-------------------------------------------------------
-- REQUEST FOR 'role_author' JUNCTION TABLE CREATION --
-------------------------------------------------------
    
CREATE TABLE role_author (
	author_id INT NOT NULL,
	CONSTRAINT fk_role_author
		FOREIGN KEY (author_id)
		REFERENCES author(id),
	role_id INT NOT NULL,
	CONSTRAINT fk_author_role
		FOREIGN KEY (role_id)
		REFERENCES role(id)
	);

------------------------------------------------------
-- REQUEST FOR 'category' TABLE CREATION            --
------------------------------------------------------

CREATE TABLE category (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    category VARCHAR(80) NOT NULL
    );

------------------------------------------------------
-- REQUEST FOR 'user' TABLE CREATION                --
------------------------------------------------------

CREATE TABLE `user` (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
	user_name VARCHAR(80) NOT NULL,
    first_name VARCHAR(80) NOT NULL,
    last_name VARCHAR(80) NOT NULL,
    email VARCHAR(320) NOT NULL,
    password VARCHAR(80) NOT NULL,
    birth_date DATE NOT NULL,
    is_admin BOOL NOT NULL
    );

------------------------------------------------------
-- REQUEST FOR 'comic_book' TABLE CREATION          --
------------------------------------------------------

CREATE TABLE comic_book (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
	title_keywords VARCHAR(255),
    isbn BIGINT,
    date_of_release DATE,
    pitch TEXT NOT NULL,
	keywords TEXT,
    nb_pages INT,
    volume INT,
    price VARCHAR(10),
    cover VARCHAR(1000),
    author_name VARCHAR(100),
	category_id INT NOT NULL,
	CONSTRAINT fk_comic_book_category
		FOREIGN KEY (category_id)
		REFERENCES category(id),
	user_id INT,
	CONSTRAINT fk_comic_book_user
		FOREIGN KEY (user_id)
		REFERENCES user(id)
	);

-------------------------------------------------------------
-- REQUEST FOR 'comic_book_author' JUNCTION TABLE CREATION --
-------------------------------------------------------------
    
    CREATE TABLE comic_book_author (
	comic_book_id INT NOT NULL,
	CONSTRAINT fk_author_comic_book
		FOREIGN KEY (comic_book_id)
		REFERENCES comic_book(id),
	author_id INT NOT NULL,
	CONSTRAINT fk_comic_book_author
		FOREIGN KEY (author_id)
		REFERENCES author(id)
	);

------------------------------------------------------
-- REQUEST FOR 'contact' TABLE CREATION             --
------------------------------------------------------
    
CREATE TABLE contact (
	id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    firstname VARCHAR(80) NOT NULL,
    lastname VARCHAR(100) NOT NULL,
    email VARCHAR(320) NOT NULL,
    message TEXT NOT NULL
    );

------------------------------------------------------
-- REQUEST FOR 'keywords_search' TABLE CREATION     --
------------------------------------------------------

CREATE TABLE keywords_search (
	keyword VARCHAR(80));

----------------------------------------------------------------------------------------
----------------------------------------------------------------------------------------


-- SQL REQUEST TO INSERT SOME VALUES INTO TABLES --

------------------------------------------------------
-- INSERT VALUES REQUEST FOR 'role' TABLE           --
------------------------------------------------------

INSERT INTO comic_cult.`role` (`role`) VALUES
	 ('Dessinateur'),
	 ('Scénariste'),
	 ('Coloriste');

------------------------------------------------------
-- INSERT VALUES REQUEST FOR 'category' TABLE       --
------------------------------------------------------

INSERT INTO comic_cult.category (category) VALUES
	 ('Education'),
	 ('Polar'),
	 ('Science-fiction'),
	 ('Sport'),
	 ('Humour'),
	 ('Horreur'),
	 ('Philo'),
	 ('Histoire'),
	 ('Absurde'),
	 ('Western');
INSERT INTO comic_cult.category (category) VALUES
	 ('Aventure'),
	 ('Héroïque Fantaisie'),
	 ('Animalier'),
	 ('Autobiographique'),
	 ('Biographique'),
	 ('Documentaire'),
	 ('Espionnage'),
	 ('Fantastique'),
	 ('Humoristique'),
	 ('Jeunesse');
INSERT INTO comic_cult.category (category) VALUES
	 ('Médical'),
	 ('Poltique'),
	 ('Graphique'),
	 ('Sentimental'),
	 ('Underground');

------------------------------------------------------
-- INSERT VALUES REQUEST FOR 'author' TABLE         --
------------------------------------------------------

INSERT INTO comic_cult.author (first_name,last_name,birth_date,editor,biography) VALUES
	 ('Eric','Buche','1965-05-12','Éditions Glénat',''),
	 ('Jean','Van Hamme','1939-01-16','',''),
	 ('Grzegorz','Rosinski','1947-08-02','',''),
	 ('Raoul','Cauvin','1921-08-18','',''),
	 ('Louis','Salvérius','1933-12-04','',''),
	 ('Juan','Diaz Canalès','1971-12-31','',''),
	 ('Juanjo','Guarnido','1966-12-31','',''),
	 ('Jean','Giraud / Moebius / Gir','1938-05-07','',''),
	 ('Jean-Michel','Charlier','1924-10-30','',''),
	 ('Georges','Rémi / Hergé','1907-05-01','Casterman','');
INSERT INTO comic_cult.author (first_name,last_name,birth_date,editor,biography) VALUES
	 ('Albert','Uderzo','1927-04-24','',''),
	 ('André','Goscinny','1926-08-13','',''),
	 ('Maurice','de Bevere / Morris','1923-12-01','',''),
	 ('Xavier','Dorison','1972-10-07','',''),
	 ('Ralph','Meyer','1971-08-10','',''),
	 ('Marion','Montaigne','1980-04-07','Sarbacane',''),
	 ('Arnaud','Le Gouëfflec','1974-03-24','',''),
	 ('Nicolas','Moog','1978-08-08','',''),
	 ('Jean-Pierre','Pécau','1955-07-26','',''),
	 ('Stefano','Martino','1970-04-21','','');
INSERT INTO comic_cult.author (first_name,last_name,birth_date,editor,biography) VALUES
	 ('Elmer','Santos','1991-01-04','',''),
	 ('Yoon','Jeong','1999-12-31','',''),
	 ('Joaquin','Tejon / Quino','1932-07-16','',''),
	 ('Christophe','Bec','1969-08-23','',''),
	 ('Stefano','Raffaele','1970-03-14','',''),
	 ('Marjane','Satrapi','1969-11-21','',''),
	 ('Othon','Aristides / Fred','1931-03-05','',''),
	 ('Christophe','Arleston','1962-12-31','',''),
	 ('Adrien','Floch','1977-03-16','',''),
	 ('Claude','Guth','1962-02-28','','');
INSERT INTO comic_cult.author (first_name,last_name,birth_date,editor,biography) VALUES
	 ('Adrien','Martin','1977-06-01','',''),
	 ('Ludovic','Danjou','1977-06-01','',''),
	 ('Renaud','Dillies','1972-10-12','',''),
	 ('Jun','Jung-sik','1965-12-01','',''),
	 ('Catel','Muller','1964-08-26','',''),
	 ('Jean-Louis','Boquet','1962-08-27','',''),
	 ('Philippe','Aymont','1968-02-02','',''),
	 ('Thomas','Mosdi','1961-12-31','',''),
	 ('Roberto','Saviano','1979-07-21','',''),
	 ('Asaf','Hanuka','1973-12-31','','');

------------------------------------------------------
-- INSERT VALUES REQUEST FOR 'user' TABLE           --
------------------------------------------------------

INSERT INTO comic_cult.`user` (user_name,first_name,last_name,email,password,birth_date,is_admin) VALUES
	 ('Toto_69','Toto','Leclient','toto.leclient@bdcult.fr','TotoKiffLaBd69002!','1983-07-23',1);

------------------------------------------------------
-- INSERT VALUES REQUEST FOR 'role_author' TABLE    --
------------------------------------------------------

INSERT INTO comic_cult.role_author (author_id,role_id) VALUES
	 (2,2),
	 (3,1),
	 (4,2),
	 (5,1),
	 (6,2),
	 (7,1),
	 (1,1),
	 (8,1),
	 (10,1),
	 (9,2);
INSERT INTO comic_cult.role_author (author_id,role_id) VALUES
	 (11,1),
	 (12,2),
	 (13,1),
	 (14,2),
	 (15,1),
	 (16,1),
	 (19,1),
	 (20,2),
	 (21,3),
	 (17,2);
INSERT INTO comic_cult.role_author (author_id,role_id) VALUES
	 (18,1),
	 (23,1),
	 (22,1),
	 (24,2),
	 (25,1),
	 (26,1),
	 (27,1),
	 (28,2),
	 (29,1),
	 (30,3);
INSERT INTO comic_cult.role_author (author_id,role_id) VALUES
	 (33,1),
	 (31,1),
	 (32,2),
	 (34,1),
	 (35,2),
	 (36,1),
	 (37,1),
	 (38,1),
	 (39,2),
	 (40,1);

------------------------------------------------------
-- INSERT VALUES REQUEST FOR 'comic_book' TABLE     --
------------------------------------------------------

INSERT INTO comic_cult.comic_book (title,title_keywords,isbn,date_of_release,pitch,keywords,nb_pages,volume,price,cover,author_name,category_id,user_id) VALUES
	 ('Franky Snow - Slide à mort','franky snow slide mort',9782723427593,'1999-10-19','Franky Snow est un vrai rider. Snowboard, surf, ski, skate, BMX, roller, VTT extrême, flyboard… cela tout en draguant les filles au passage si possible !','franky snow vrai rider snowboard surf ski skate bmx roller vtt extreme flyboard cela tout draguant  filles passage possible',48,1,10.95,'https://blog.manawa.com/wp-content/uploads/2020/12/Franky-Snow-nr-1.jpeg','Eric Buche',5,NULL),
	 ('Western','western',9782803624683,'2001-04-30','1858, Wyoming. Ambrosius Van Deer, un gros éleveur, a promis la somme faramineuse de 1000 dollars à qui lui ramènerait son neveu enlevé par les Sioux. Alléché, Jess Chisum tente un coup de bluff: faire passer son propre fils pour l''enfant tant recherché. Bien mal lui en prend: accusé de meurtre et amputé d''un bras, le jeune homme ne pourra plus compter que sur son habileté au colt pour que vive la légende du cow-boy manchot.','wyoming ambrosius van deer gros eleveur  somme faramineuse  ramenerait neveu enleve par  sioux alleche jess chisum tente coup bluff faire passer  propre fils pour enfant tant recherche bien mal accuse  meurtre  ampute bras jeune homme  pourra plus compter habilete  colt pour que vive legende cow boy manchot',88,1,20.0,'https://www.bdtheque.com/repupload/T/T_205.JPG','Van Hamme',10,NULL),
	 ('Les Tuniques Bleues - Un Chariot dans l''ouest','tuniques bleues chariot ouest',9782800108582,'1972-01-31','Un messager blessé parvient à atteindre le camp de Fort Bow. Il appartient à la garnison de Fort Defiance. Les soldats y subissent le siège des Indiens. Mais ils sont à bout de forces et à court de munitions. Il faut faire vite ! C’est donc un sergent Chesterfield déterminé, flanqué de son inséparable caporal Blutch et de leurs compagnons qui volent au secours des leurs. Pas facile de se déplacer sans encombre avec un chariot bourré de munitions, dans une zone infestée par les Indiens.','un messager blesse parvient a atteindre le camp de fort bow  il appartient a la garnison de fort defiance  les soldats y subissent le siege des indiens  mais ils sont a bout de forces et a court de munitions  il faut faire vite  donc un sergent chesterfield determine  flanque inseparable caporal blutch compagnons qui volent secours pas facile deplacer sans encombre achariot bourre munitions zone infestee indiens',48,1,20.0,'https://www.bdtheque.com/repupload/T/T_1658.JPG','Grzegorz Rosinski',10,NULL),
	 ('Blueberry - Fort Navajo','blueberry fort navajo',9782205042122,'1965-08-31','Blueberry est affecté après la fin de la guerre de sécession à Fort Navajo. Lorsqu''il s''y rend il fait la connaissance d''un de ses "collègues", le lieutenant Graig. C''est avec lui qu''il fera le voyage vers le Fort et découvrira une ferme incendiée par les Apaches semble-t-il. Cet événement et la haine farouche envers les indiens du Major Bascom va plonger le territoire qui est sous la protection du fort dans une longue période de trouble. Mais Blueberry, avec l''aide d''un jeune sang-mêlé (le sergent Crowe) et l''appui du Lieutenant Graig, entend bien découvrir la vérité. Il espère ainsi retrouver le jeune garçon qui a disparu lors de l''attaque de la ferme et ramener avec lui la paix.','blueberry est affecte apres la fin de la guerre de secession a fort navajo  lorsqu il s y rend il fait la connaissance d un de ses  collegues   le lieutenant graig  c est avec lui qu il fera le voyage vers le fort et decouvrira une ferme incendiee par les apaches semble t il  cet evenement et la haine farouche envers les indiens du major bascom va plonger le territoire qui est sous la protection du fort dans une longue periode de trouble  mais blueberry  avec l aide d un jeune sang mele le sergent crowe',48,1,20.0,'https://www.bdtheque.com/repupload/T/T_1763.JPG','Jean-Michel Charlier',10,NULL),
	 ('Lucky Luke - La Mine d''or de Dick Digger','lucky luke mine or dick digger',9782800114415,'1949-02-28','Dick Digger, un vieil ami de Lucky Luke, a découvert une mine d''or dans les West Hills. Il a caché son plan dans une bouteille de rhum. Pendant la nuit, alors qu''il dort dans une chambre au-dessus d''un saloon, il se fait voler son or et son plan par deux bandits mexicains. Il tente de se défendre mais il reçoit un méchant coup sur la tête et perd la mémoire. Lucky Luke retrouve la piste des bandits...','dick digger  un vieil ami de lucky luke  a decouvert une mine d or dans les west hills  il a cache son plan dans une bouteille de rhum  pendant la nuit  alors qu il dort dans une chambre au dessus d un saloon  il se fait voler son or et son plan par deux bandits mexicains  il tente de se defendre mais il reçoit un mechant coup sur la tete et perd la memoire  lucky luke retrouve la piste des bandits',48,1,20.0,'https://www.bdtheque.com/repupload/T/T_655.JPG','René Goscinny',10,NULL),
	 ('Undertaker - Le mangeur d''or','undertaker mangeur or',9782505061373,'2015-01-29','Jonas Crow, croque-mort, doit convoyer le cercueil d''un ancien mineur devenu millionnaire vers le filon qui fit autrefois sa fortune. Des funérailles qui devraient être tranquilles, à un détail près : avant de décéder, Joe Cusco a avalé son or pour l''emmener avec lui dans l''éternité. Pas de chance, le secret est éventé et provoque la fureur des mineurs d''Anoki City.','jonas crow  croque mort  doit convoyer le cercueil d un ancien mineur devenu millionnaire vers le filon qui fit autrefois sa fortune  des funerailles qui devraient etre tranquilles  a un detail pres   avant de deceder  joe cusco a avale son or pour l emmener avec lui dans l eternite  pas de chance  le secret est evente et provoque la fureur des mineurs d anoki city',56,1,20.0,'https://www.bdtheque.com/repupload/T/T_46461.JPG','Xavier Dorison',10,NULL),
	 ('Blacksad - Quelque part entre les ombres','blacksad quelque part entre ombres',9782205049657,'2000-11-09','Un chat détective, la cigarette au museau, enquête sur le meurtre de son ex entre serpents tueurs à gage, cochon barman, rhinocéros gardes du corps et chien policier. Disney ? Oui un Disney buvant du bourbon, fumant des sans filtre, jouant du blues et préférant Marilyn à Minnie.','un chat detective  la cigarette au museau  enquete sur le meurtre de son ex entre serpents tueurs a gage  cochon barman  rhinoceros gardes du corps et chien policier  disney   oui un disney buvant du bourbon  fumant des sans filtre  jouant du blues et preferant marilyn a minnie',48,1,14.5,'https://www.bdtheque.com/repupload/T/T_170.JPG','Juan Dias Canales',2,NULL),
	 ('Blacksad - Arctic Nation','blacksad arctic nation',9782205051995,'2003-03-21','Oldsmill, le maître de la ville, est un tigre blanc. Karup, le chef de la police, un ours blanc. Huk, l''âme damnée de Karup, un renard blanc. Avec les autres animaux à pelage immaculé, ils forment la société WASP (W pour White, AS pour Anglo-Saxon, P pour Protestant). Dans cette ambiance pas câline, câline, Blacksad, le chat détective privé, enquête sur la disparition d''une enfant de couleur. La mère de Kyle, Dinah, travaillait comme femme de ménage chez le même Karup et, selon quelques bonnes âmes, serait au mieux avec le fils Oldsmill.','oldsmill  le maitre de la ville  est un tigre blanc  karup  le chef de la police  un ours blanc  huk  l âme damnee de karup  un renard blanc  avec les autres animaux a pelage immacule  ils forment la societe wasp (w pour white  as pour anglo saxon  p pour protestant)  dans cette ambiance pas câline  câline  blacksad  le chat detective prive  enquete sur la disparition d une enfant de couleur  la mere de kyle  dinah  travaillait comme femme de menage chez le meme karup et  selon quelques bonnes âmes',56,2,14.5,'https://www.bdtheque.com/repupload/T/T_7657.JPG','Juan Dias Canales',2,NULL),
	 ('Blacksad - Ame Rouge','blacksad ame rouge',9782205055641,'2005-11-17','Finances et moral au plus bas, Blacksad est à Las Vegas où il travaille pour le compte d''un joueur fortuné. Pourtant une rencontre inattendue va bousculer sa nouvelle vie : un ami, Otto Lieber, scientifique de haut rang, est de passage dans la ville où a lieu une conférence sur le nucléaire. Les deux hommes réussissent à se voir et les souvenirs remontent à la surface... Otto semble avoir une vie passionnante malgré l''excentricité de son "bienfaiteur", Gotfield. Celui-ci est marié à la troublante Alma et, après ces rencontres, la vie de Blacksad va prendre une nouvelle tournure...','finances et moral au plus bas  blacksad est a las vegas ou il travaille pour le compte d un joueur fortune  pourtant une rencontre inattendue va bousculer sa nouvelle vie   un ami  otto lieber  scientifique de haut rang  est de passage dans la ville ou a lieu une conference sur le nucleaire  les deux hommes reussissent a se voir et les souvenirs remontent a la surface    otto semble avoir une vie passionnante malgre l excentricite de son  bienfaiteur   gotfield  celui ci est marie a la troublante alma',56,3,14.5,'https://www.bdtheque.com/repupload/T/T_15027.JPG','Juan Dias Canales',2,NULL),
	 ('Les aventures de Tintin - L''île noire','aventures tintin ile noire',NULL,'1938-01-01','Un mystérieux avion met Tintin, pour la première fois, sur la piste du Docteur Müller. Celui-ci dirige un étrange asile : ceux qui y entrent ne sont pas forcément fous. Lancé à sa poursuite, Tintin ira jusqu’à l’Ile Noire où l’énigmatique Docteur dissimule une activité plus mystérieuse encore...','un mysterieux avion met tintin  pour la premiere fois  sur la piste du docteur muller  celui ci dirige un etrange asile   ceux qui y entrent ne sont pas forcement fous  lance a sa poursuite  tintin ira jusqu’a l’ile noire ou l’enigmatique docteur dissimule une activite plus mysterieuse encore',64,7,11.5,'https://static.fnac-static.com/multimedia/FR/Images_Produits/FR/fnac.com/Visual_Principal_340/0/6/0/9782203001060/tsp20121014055923/L-Ile-noire.jpg','Hergé',11,NULL);
INSERT INTO comic_cult.comic_book (title,title_keywords,isbn,date_of_release,pitch,keywords,nb_pages,volume,price,cover,author_name,category_id,user_id) VALUES
	 ('Les aventures de Tintin - On a marché sur la lune','aventures tintin marche lune',NULL,'1953-12-31','On a marché sur la Lune décrit le premier voyage spatial et l''exploration de notre satellite par Tintin et ses compagnons, quinze ans avant l''Américain Armstrong! Une anticipation remarquablement documentée et époustouflante par l''acuité visionnaire du récit.','on a marche sur la lune decrit le premier voyage spatial et l exploration de notre satellite par tintin et ses compagnons  quinze ans avant l americain armstrong  une anticipation remarquablement documentee et epoustouflante par l acuite visionnaire du recit',62,17,12.0,'https://www.bdtheque.com/repupload/T/T_547.JPG','Hergé',11,NULL),
	 ('Les aventures de Tintin - Tintin au Tibet','aventure tintin tibet',NULL,'1959-12-31','Un avion de ligne à bord duquel le jeune Chinois Tchang se rendait en Europe s''est écrasé dans l''Himalaya. Tintin au Tibet, pure histoire d''amitié, sans le moindre méchant, décrit la recherche désespérée à laquelle Tintin se livre pour retrouver son ami. Ce récit pathétique, qui rompt avec le ton extraverti des épisodes précédents, démontre que la fidélité et l''espoir sont capables de vaincre tous les obstacles, et que les préjugés - en l''occurrence, à l''égard de l''"abominable homme des neiges" - sont bien souvent le fruit de l''ignorance.','un avion de ligne a bord duquel le jeune chinois tchang se rendait en europe s est ecrase dans l himalaya  tintin au tibet  pure histoire d amitie  sans le moindre mechant  decrit la recherche desesperee a laquelle tintin se livre pour retrouver son ami  ce recit pathetique  qui rompt avec le ton extraverti des episodes precedents  demontre que la fidelite et l espoir sont capables de vaincre tous les obstacles  et que les prejuges   en l occurrence  a l egard de l  abominable homme des neiges    sont bien',62,20,11.5,'https://www.bdtheque.com/repupload/T/T_550.JPG','Hergé',11,NULL),
	 ('Astérix - Astérix et Cléopâtre','asterix cleopatre',9782012101388,'1965-05-31','Excédée par ses sarcasmes, Cléopâtre fait à César le pari d’édifier dans la ville d’Alexandrie un palais somptueux en son honneur, en trois mois, jour pour jour ! Pour Numérobis, l’architecte à qui la reine confie le projet, c’est mission impossible. D’autant qu’Amonbofis, son rival jaloux, fera tout pour mettre son projet en péril. Il ne lui reste qu’un espoir : Panoramix, le druide gaulois aux pouvoirs magiques…','excedee par ses sarcasmes  cleopatre fait a cesar le pari d’edifier dans la ville d’alexandrie un palais somptueux en son honneur  en trois mois  jour pour jour   pour numerobis  l’architecte a qui la reine confie le projet  c’est mission impossible  d’autant qu’amonbofis  son rival jaloux  fera tout pour mettre son projet en peril  il ne lui reste qu’un espoir   panoramix  le druide gaulois aux pouvoirs magiques',48,6,10.99,'https://www.bdtheque.com/repupload/T/T_616.JPG','Albert Uderzo',11,NULL),
	 ('Astérix - Astérix aux jeux olympiques','asterix jeux olympiques',9782012101449,'1968-06-30','Faire la fête et laminer ses adversaires : voilà bien ce que les gaulois préfèrent. Et lorsqu’ils apprennent que les Romains du camp d’Aquarium s’entraînent pour représenter Rome aux prochains jeux olympiques, ils n’ont qu’une envie : y participer eux aussi !','faire la fete et laminer ses adversaires   voila bien ce que les gaulois preferent  et lorsqu’ils apprennent que les romains du camp d’aquarium s’entrainent pour representer rome aux prochains jeux olympiques  ils n’ont qu’une envie   y participer eux aussi',48,12,11.99,'https://www.bdtheque.com/repupload/T/T_621.JPG','Albert Uderzo',11,NULL),
	 ('Astérix - Le Domaine des Dieux','asterix domaine dieux',9782012101494,'1971-09-30','Jules César n’en démord pas : il faut mettre au pas les Irréductibles Gaulois ! Et puisque ces guerriers impénitents refusent d’adhérer à la civilisation romaine, elle s’imposera à eux, de gré ou de force.','jules cesar n’en demord pas   il faut mettre au pas les irreductibles gaulois   et puisque ces guerriers impenitents refusent d’adherer a la civilisation romaine  elle s’imposera a eux  de gre ou de force',48,17,11.99,'https://www.bdtheque.com/repupload/T/T_625.JPG','Albert Uderzo',11,NULL),
	 ('Panique organique','panique organique',9782848651849,'2007-10-01','En avalant son bol de céréales « Chocomiams », Stiveune, engloutit le sous-marin miniature offert avec le paquet. Une aubaine pour Pistou et Chimou, deux bactéries qui s’ennuyaient à mourir dans son estomac : en route pour l’aventure ! Commence alors, à bord de l’engin, une exploration palpitante du corps humain…','avalant son bol de cereales « chocomiams »  stiveune  engloutit le sous marin miniature offert avec le paquet  une aubaine pour pistou et chimou  deux bacteries qui s’ennuyaient a mourir dans son estomac   en route pour l’aventure   commence alors  a bord de l’engin  une exploration palpitante du corps humain',96,1,19.99,'https://www.bdtheque.com/repupload/T/T_22326.JPG','Marion Montaigne',21,NULL),
	 ('Underground','underground',9782344042182,'2021-04-13','Ces hommes et ces femmes ne sont pas connus du grand public et pourtant, leurs œuvres ont bouleversé l’histoire de la musique. Pour remettre sur le devant de la scène des artistes dont la popularité n’égale pas l’influence, Arnaud Le Gouëfflec et Nicolas Moog nous content les histoires de ces fabuleux créateurs. Parmi eux, (re)découvrez le génie sensible et maniaco-dépressif Daniel Johnston, la reine péruvienne de l’exotica Yma Sumac, l’improbable SDF aveugle Moondog, les chineurs classieux de The Cramps, la légendaire Patti Smith et tellement d’autres...','ces hommes et ces femmes ne sont pas connus du grand public et pourtant  leurs oeuvres ont bouleverse l’histoire de la musique  pour remettre sur le devant de la scene des artistes dont la popularite n’egale pas l’influence  arnaud le gouefflec et nicolas moog nous content les histoires de ces fabuleux createurs  parmi eux decouvrez le genie sensible et maniaco depressif daniel johnston  la reine peruvienne de l’exotica yma sumac  l’improbable sdf aveugle moondog  les chineurs classieux',312,1,29.99,'https://www.bdtheque.com/repupload/T/66713-couverture-bd-underground-rockers-maudits-et-grandes-pretresses-du-son-tome-0.jpg','Arnaud Le Gouefflec',25,NULL),
	 ('Ghost War - L''aube rouge','ghost war aube rouge',9782302069763,'2018-05-29','Dans un futur proche où les réserves de pétrole s’épuisent, les bots, scaphandres bardés d’électronique, facilitent le travail des militaires, manutentionnaires ou foreurs comme Terry, qui oeuvre sur une plateforme maritime. Lida, elle, est serveuse dans la ville côtière la plus proche. Lorsque des bots non identifiés débarquent et massacrent leurs amis et collègues, Terry et Lida, malgré leurs dissensions, doivent faire équipe pour tirer ça au clair.','dans un futur proche ou les reserves de petrole s’epuisent  les bots  scaphandres bardes d’electronique  facilitent le travail des militaires  manutentionnaires ou foreurs comme terry  qui oeuvre sur une plateforme maritime  lida  elle  est serveuse dans la ville cotiere la plus proche  lorsque des bots non identifies debarquent et massacrent leurs amis et collegues  terry et lida  malgre leurs dissensions  doivent faire equipe pour tirer ça au clair',48,1,13.99,'https://www.bdtheque.com/repupload/T/T_56976.JPG','Jean-Pierre Pécaud',3,NULL),
	 ('Sentimental color','sentimental color',9782353255108,'2013-05-01','Les sentiments ont toutes sortes de couleurs. Quelle est la couleur des vôtres ?','les sentiments ont toutes sortes de couleurs  quelle est la couleur des votres',48,1,13.9,'https://www.bdtheque.com/repupload/T/T_48825.JPG','Yoon-Jeong',24,NULL),
	 ('60 ans d''humour','60 ans humour',9782344000656,'2014-04-01','Recueil de gags de Quino pour l''anniversaire de ses 60 ans de carrière.','recueil de gags de quino pour l anniversaire de ses 60 ans de carriere',141,1,12.75,'https://www.bdtheque.com/repupload/T/T_56673.JPG','Quino',5,NULL);
INSERT INTO comic_cult.comic_book (title,title_keywords,isbn,date_of_release,pitch,keywords,nb_pages,volume,price,cover,author_name,category_id,user_id) VALUES
	 ('Pandemonium','pandemonium',9782302120082,'2022-02-15','Le Waverly Hills Sanatorium fut l''un des établissements les plus réputés des Etats-Unis en matière de traitement de la tuberculose. Entre 1920 et 1960, plus de 63 000 personnes y ont trouvé la mort. Cet énorme bâtiment construit en forme d''ailes de chauve-souris, aujourd''hui en ruine, a été classé parmi les 10 endroits les plus effrayants au monde.','le waverly hills sanatorium fut l un des etablissements les plus reputes des etats unis en matiere de traitement de la tuberculose  entre et a plus de 63 personnes y ont trouve la mort  cet enorme bâtiment construit en forme d ailes de chauve souris  aujourd hui en ruine  a ete classe parmi les endroits les plus effrayants au monde',56,1,8.99,'https://www.bdtheque.com/repupload/T/T_29436.JPG','Christophe Bec',6,NULL),
	 ('Persepolis - l''intégrale','persepolis integrale',9782844146762,'2017-10-19','L’Iran est un vaste pays avec une identité culturelle et historique lourde à porter et avec des ressources en pétrole qui attirent depuis la fin du XIXème siècle toutes les convoitises des pays étrangers, et particulièrement européens. A la fin des années 70, l’Iran est dirigé par un shah (un roi), plus ou moins corrompu, n’hésitant pas à utiliser la force pour étouffer toute opposition. C’est dans ce contexte que le peuple après plusieurs évènements sanglants, ce soulève et manifeste pour renverser le Shah. Celui ci est donc obligé d’abdiquer et alors se met en place la « révolution islamique » avec son cortège d’intolérance.','iran est un vaste pays avec une identite culturelle et historique lourde a porter et avec des ressources en petrole qui attirent depuis la fin du xixeme siecle toutes les convoitises des pays etrangers  et particulierement europeens  a la fin des annees 7â  l’iran est dirige par un shah (un roi)  plus ou moins corrompu  n’hesitant pas a utiliser la force pour etouffer toute opposition  c’est dans ce contexte que le peuple apres plusieurs evenements sanglants  ce souleve et manifeste',200,1,36.0,'https://www.bdtheque.com/repupload/T/20994-couverture-bd-persepolis-tome-1.jpg','Marjan Satrapi',23,NULL),
	 ('Philémon avant la lettre','philemon avant lettre',9782205055047,'2003-03-31','Philémon, c''est un grand bonhomme toujours dans ses pensées et dans son monde extraordinaire, entre poésie et invention, qui vous emmenera bien au delà de ce que vous espérez.','philemon grand bonhomme toujours dans ses pensees et dans son monde extraordinaire  entre poesie et invention  qui vous emmenera bien au dela de ce que vous esperez',78,0,14.5,'https://www.bdtheque.com/repupload/T/T_4054.JPG','Fred',9,NULL),
	 ('Sangre - Hovanne l''irrésolue','sangre hovanne irresolue',9782302095021,'2022-01-04','Introduite au manoir de Mermillade, Sangre enquête pour savoir laquelle des jeunes nobles a eu un passé secret de pirate sous l''identité d''Hovanne. Un exercice difficile dans cette société d''oisifs où tout est basé sur le prestige personnel.','introduite au manoir de mermillade  sangre enquete pour savoir laquelle des jeunes nobles a eu un passe secret de pirate sous l identite d hovanne  un exercice difficile dans cette societe d oisifs ou tout est base sur le prestige personnel',48,3,14.95,'https://www.bdtheque.com/repupload/T/67313-couverture-bd-sangre-tome-3.jpg','Christophe Arleston',12,NULL),
	 ('Betty Blues','betty blues',9782940334179,'2003-09-23','Rice est un canard jazzophile. Occupé à souffler dans sa trompette, il ne voit pas sa copine Betty s''emmerder au coin du bar. Une belle histoire sur la vie et l''amour.','rice est un canard jazzophile  occupe a souffler dans sa trompette  il ne voit pas sa copine betty s emmerder au coin du bar  une belle histoire sur la vie et l amour',78,1,16.8,'https://www.bdtheque.com/repupload/T/T_10238.JPG','Renaud Dilies',13,NULL),
	 ('L''Aventure géopolitique','aventure geopolitique',9782302093034,'2021-04-20','Mister Geopolitix, c''est Gildas, un aventurier YouTuber, reporter passionné qui se questionne sur les enjeux humains, l''impact environnemental de nos sociétés et les conséquences des choix politiques. Pour comprendre la déforestation, Gildas se lance dans un incroyable voyage autour du monde. Une aventure qui nous emmène au coeur de l''Amazonie, dans les plaines africaines jusqu''aux forêts indonésiennes.','mister geopolitix  c est gildas  un aventurier youtuber  reporter passionne qui se questionne sur les enjeux humains  l impact environnemental de nos societes et les consequences des choix politiques  pour comprendre la deforestation  gildas se lance dans un incroyable voyage autour du monde  une aventure qui nous emmene au coeur de l amazonie  dans les plaines africaines jusqu aux forets indonesiennes',64,1,15.5,'https://www.bdtheque.com/repupload/T/65942-couverture-bd-l-aventure-geopolitique-tome-1.jpeg','Ludovic Danjou',22,NULL),
	 ('Couleur de peau : Miel','couleur peau miel',9782849469507,'2007-09-25','Je savais bien que je n''étais pas japonais. Mais quand je me regardais dans un miroir, je ne me sentais pas belge non plus ! Je voyais un coréen. C''était inéluctable. Et ça ne me rappelait pas de bons souvenirs...','savais bien que je n etais pas japonais  mais quand je me regardais dans un miroir  je ne me sentais pas belge non plus   je voyais un coreen  c etait ineluctable  et ça ne me rappelait pas de bons souvenirs',144,1,17.95,'https://www.bdtheque.com/repupload/T/T_22052.JPG','Jung',14,NULL),
	 ('Joséphine Baker','josephine baker',9782203232297,'2021-09-21','"Vous savez, mes amis, que je ne mens pas quand je vous raconte que je suis entrée dans les palaces de rois et de reines, dans les maisons de présidents. Et bien plus encore. Mais je ne pouvais pas entrer dans un hôtel en Amérique et boire une tasse de café. Et cela m''a rendue furieuse." Joséphine Baker. Marche sur Washington, 28 août 1963.','vous savez  mes amis  que je ne mens pas quand je vous raconte que je suis entree dans les palaces de rois et de reines  dans les maisons de presidents  et bien plus encore  mais je ne pouvais pas entrer dans un hotel en amerique et boire une tasse de cafe  et cela m a rendue furieuse   josephine baker  marche sur washington',564,1,30.0,'https://www.bdtheque.com/repupload/T/60757-couverture-bd-josephine-baker-tome-1.jpg','José Louis Bocquet',15,NULL),
	 ('Lady S - Code Vampiir','lady code vampiir',9782800174396,'2019-11-28','Suzan ou Shania ? Qui est vraiment Lady S ? Néo-Zélandaise ou Estonienne ? Fille d''ambassadeur américain ou de Juifs dissidents d''U.R.S.S. ? Enfant perdue ou voleuse à la petite semaine ? Victime de chantage ou espionne de haut vol ?','suzan ou shania   qui est vraiment lady s   neo zelandaise ou estonienne   fille d ambassadeur americain ou de juifs dissidents d u r s s    enfant perdue ou voleuse a la petite semaine   victime de chantage ou espionne de haut vol',48,14,12.5,'https://products-images.di-static.com/image/philippe-aymond-lady-s-tome-14-code-vampiir/9782800174396-475x500-1.webp','Philippe Aymont',17,NULL),
	 ('Xoco - Cycle 1','xoco cycle 1',9782749304793,'2008-12-02','Un tueur en série terrorise la ville et l''enquête policière piétine. Les chargés de l''affaire ne savent plus quelle piste suivre. Celle d''un détraqué qui tue par folie ou celle d''un homme se livrant à des sacrifices rituels. Ou peut-être bien les deux à la fois...','un tueur en serie terrorise la ville et l enquete policiere pietine  les charges de l affaire ne savent plus quelle piste suivre  celle d un detraque qui tue par folie ou celle d un homme se livrant a des sacrifices rituels  ou peut etre bien les deux a la fois',58,1,25.5,'https://products-images.di-static.com/image/mosdi-xoco-cycle-1-tomes-1-et-2/9782749304793-475x500-1.webp','Thomas Mosdi',18,NULL);
INSERT INTO comic_cult.comic_book (title,title_keywords,isbn,date_of_release,pitch,keywords,nb_pages,volume,price,cover,author_name,category_id,user_id) VALUES
	 ('Je suis toujours vivant','je suis toujours vivant',9782075096966,'2022-01-18','Des chambres d''hôtel anonymes, sept gardes du corps, deux voitures blindées. C''est le quotidien sous haute protection de l''auteur napolitain depuis le succès phénoménal de Gomorra, son roman-enquête sur la mafia locale -la Camorra- publié en 2006. Depuis lors, sa vie a radicalement changé, mais celui qui n''est jamais plus rentré chez lui a choisi son camp:il ne se taira pas. De la crainte des voitures piégées à celle des pizzas empoisonnées, il imagine les divers scénarios de son assassinat et, évoquant son enfance, sa famille, ses ennemis, il livre un récit intime et saisissant. Le récit inédit d''une vie en sursis.','chambres d hotel anonymes  sept gardes du corps  deux voitures blindees  c est le quotidien sous haute protection de l auteur napolitain depuis le succes phenomenal de gomorra  son roman enquete sur la mafia locale  la camorra  publie en 2ââ6  depuis lors  sa vie a radicalement change  mais celui qui n est jamais plus rentre chez lui a choisi son camp il ne se taira pas  de la crainte des voitures piegees a celle des pizzas empoisonnees  il imagine les divers scenarios de son assassinat',148,1,14.99,'https://www.bdfugue.com/media/catalog/product/cache/1/image/400x/17f82f742ffe127f42dca9de82fb58b1/9/7/9782075096966_1_75.jpg','Roberto Saviano',16,NULL);
---------------------------------------------------------
-- INSERT VALUES REQUEST FOR 'comic_book_author' TABLE --
---------------------------------------------------------

INSERT INTO comic_cult.comic_book_author (comic_book_id,author_id) VALUES
	 (1,1),
	 (2,2),
	 (2,3),
	 (3,4),
	 (3,5),
	 (7,6),
	 (7,7),
	 (8,6),
	 (8,7),
	 (9,6);
INSERT INTO comic_cult.comic_book_author (comic_book_id,author_id) VALUES
	 (9,7),
	 (4,8),
	 (4,9),
	 (10,10),
	 (11,10),
	 (12,10),
	 (13,11),
	 (13,12),
	 (14,11),
	 (14,12);
INSERT INTO comic_cult.comic_book_author (comic_book_id,author_id) VALUES
	 (15,11),
	 (15,12),
	 (5,13),
	 (6,14),
	 (6,15),
	 (16,16),
	 (17,17),
	 (17,18),
	 (18,19),
	 (18,20);
INSERT INTO comic_cult.comic_book_author (comic_book_id,author_id) VALUES
	 (18,21),
	 (20,23),
	 (19,22),
	 (22,26),
	 (21,24),
	 (21,25),
	 (23,27),
	 (24,28),
	 (24,29),
	 (24,30);
INSERT INTO comic_cult.comic_book_author (comic_book_id,author_id) VALUES
	 (25,33),
	 (26,31),
	 (26,32),
	 (27,34),
	 (28,35),
	 (28,36),
	 (29,37),
	 (30,38);
