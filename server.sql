SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `books` (
  `BookID` int(11) NOT NULL,
  `Title` varchar(100) DEFAULT NULL,
  `Author` varchar(100) DEFAULT NULL,
  `Genre` varchar(50) DEFAULT NULL,
  `Price` decimal(5,2) DEFAULT NULL CHECK (`Price` > 0)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `books` (`BookID`, `Title`, `Author`, `Genre`, `Price`) VALUES
(1, 'The Great Gatsby', 'F. Scott Fitzgerald', 'Classic', 14.99),
(2, '1984', 'George Orwell', 'Dystopian', 19.99),
(3, 'genef', 'enginreening', 'waliem', 14.99),
(4, 'Alchemist', 'paulo coelho', 'fiction', 9.99),
(5, 'black suits you', 'Ahlem mosteghanemi', 'fiction', 14.99);

CREATE TABLE `texts` (
  `id` int(11) NOT NULL,
  `text` longtext NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



INSERT INTO `texts` (`id`, `text`, `created_at`) VALUES
(1, 'السماح للميكروفون ان يتكلم', '2024-07-08 23:56:47');

ALTER TABLE `books`
  ADD PRIMARY KEY (`BookID`);


ALTER TABLE `texts`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `texts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

