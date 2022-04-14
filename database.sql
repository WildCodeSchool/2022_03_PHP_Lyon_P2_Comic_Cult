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
-- CREATION AND USE REQUEST                         --
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
    email VARCHAR(100) NOT NULL,
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
    isbn BIGINT,
    date_of_release DATE,
    pitch TEXT NOT NULL,
    nb_pages INT,
    volume INT,
    price FLOAT,
    cover BLOB,
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
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL
    );

------------------------------------------------------
-- REQUEST FOR 'keywords_search' TABLE CREATION     --
------------------------------------------------------

CREATE TABLE keywords_search (
	keyword VARCHAR(80));