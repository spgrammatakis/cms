-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2018 at 02:49 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE posts (
  post_id int NOT NULL,
  author_id int NOT NULL,
  title varchar(MAX) DEFAULT NULL,
  summary varchar(MAX) NOT NULL,
  body longtext NOT NULL,
  created_at varchar(MAX) NOT NULL,
  updated_at varchar(MAX) NOT NULL,
  PRIMARY KEY (id)
)DEFAULT CHARSET=utf8;

CREATE TABLE users (
  id int NOT NULL,
  username varchar(MAX) DEFAULT NULL,
  password varchar(MAX) NOT NULL,
  created_at datetime DEFAULT CURRENT_TIMESTAMP,
  email varchar(MAX) DEFAULT NULL,
  PRIMARY KEY (id);
)DEFAULT CHARSET=utf8;

--
-- Dumping data for table users
--

INSERT INTO `users` (`id`, `username`, `password`, `created_at`, `email`) VALUES
(1, 'admin', '$2y$10$FMSdUoQzYQyZecfLDnnrneL74wbzssRH/JXI3pwmCjH8eZ.ChOKPC', '2018-04-21 16:33:49', '$2y$10$CzgBGINUB/I/ewpEUyWuEev1Z6LxdxKyNPpiS2JJbTn8JQ7SrsaC.'),
(2, 'test', '$2y$10$08PjQJU1uTUwbsgIqKcQOObpCq9on3BdbPuJiquB7OfkQifVyRg26', '2018-04-26 20:19:03', 'test@test.com');


--
-- Indexes for table posts
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
