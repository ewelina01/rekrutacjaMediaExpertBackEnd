-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Czas generowania: 20 Cze 2022, 20:54
-- Wersja serwera: 10.4.21-MariaDB
-- Wersja PHP: 7.4.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Baza danych: `rekrutacjamediaexpert`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `history`
--

CREATE TABLE `history` (
  `id` int(11) NOT NULL,
  `number` int(11) NOT NULL,
  `statusH` int(11) NOT NULL,
  `dateModified` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `history`
--

INSERT INTO `history` (`id`, `number`, `statusH`, `dateModified`) VALUES
(1, 1, 1, '2022-06-20 16:55:20'),
(2, 2, 4, '2022-06-20 16:55:49'),
(3, 3, 3, '2022-06-20 16:55:49'),
(4, 4, 1, '2022-06-20 17:58:52'),
(8, 1, 4, '2022-06-20 18:36:38'),
(9, 1, 3, '2022-06-20 20:38:20');

-- --------------------------------------------------------

--
-- Struktura tabeli dla tabeli `object`
--

CREATE TABLE `object` (
  `number` int(11) NOT NULL,
  `dateCreated` datetime NOT NULL DEFAULT current_timestamp(),
  `status` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_polish_ci;

--
-- Zrzut danych tabeli `object`
--

INSERT INTO `object` (`number`, `dateCreated`, `status`) VALUES
(1, '2022-06-20 16:54:58', 3),
(2, '2022-06-20 16:54:58', 2),
(3, '2022-06-20 16:55:34', 4),
(4, '2022-06-20 17:58:52', 1);

--
-- Indeksy dla zrzutów tabel
--

--
-- Indeksy dla tabeli `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`id`);

--
-- Indeksy dla tabeli `object`
--
ALTER TABLE `object`
  ADD PRIMARY KEY (`number`);

--
-- AUTO_INCREMENT dla zrzuconych tabel
--

--
-- AUTO_INCREMENT dla tabeli `history`
--
ALTER TABLE `history`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT dla tabeli `object`
--
ALTER TABLE `object`
  MODIFY `number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=66;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
