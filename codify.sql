-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 18, 2023 at 02:32 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `codify`
--

-- --------------------------------------------------------

--
-- Table structure for table `chats`
--

CREATE TABLE `chats` (
  `chatId` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `senderId` int(11) DEFAULT NULL,
  `receiverId` int(11) DEFAULT NULL,
  `sendDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `chats`
--

INSERT INTO `chats` (`chatId`, `message`, `senderId`, `receiverId`, `sendDate`) VALUES
(1, 'Hello, how are you?', 1, 2, '2023-12-10 23:24:16'),
(2, 'Hi! I\'m good, thanks.', 2, 1, '2023-12-10 23:24:16'),
(3, 'Hey there!', 3, 4, '2023-12-10 23:24:16'),
(4, 'Hello! Doing well, you?', 4, 3, '2023-12-10 23:24:16'),
(5, 'Hi!', 5, 6, '2023-12-10 23:24:16'),
(6, 'Hello! Nice to meet you.', 6, 5, '2023-12-10 23:24:16'),
(7, 'Hey!', 7, 8, '2023-12-10 23:24:16'),
(8, 'Hi there! What\'s up?', 8, 7, '2023-12-10 23:24:16'),
(9, 'Greetings!', 9, 10, '2023-12-10 23:24:16'),
(10, 'Hello! How\'s it going?', 10, 9, '2023-12-10 23:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `commentId` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `postId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `dateCommented` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`commentId`, `content`, `postId`, `userId`, `dateCommented`) VALUES
(1, 'Great post!', 1, 2, '2023-12-10 23:24:16'),
(2, 'Thanks!', 1, 1, '2023-12-10 23:24:16'),
(3, 'Awesome!', 2, 3, '2023-12-10 23:24:16'),
(4, 'I agree!', 2, 4, '2023-12-10 23:24:16'),
(5, 'Nice post!', 3, 5, '2023-12-10 23:24:16'),
(6, 'Keep it up!', 3, 6, '2023-12-10 23:24:16'),
(7, 'Cool!', 4, 7, '2023-12-10 23:24:16'),
(8, 'Impressive!', 4, 8, '2023-12-10 23:24:16'),
(9, 'Well done!', 5, 9, '2023-12-10 23:24:16'),
(10, 'Love it!', 5, 10, '2023-12-10 23:24:16'),
(11, 'Gago ka derek, ALLLLLAAAAH!', 1, 4, '2023-12-11 13:44:42'),
(12, 'anan kyle galaw galaw!', 1, 9, '2023-12-11 16:30:30'),
(15, 'always pogi si Jomar, why kaya?', 1, 1, '2023-12-11 23:43:15'),
(16, 'jomjom salakam!', 1, 3, '2023-12-12 00:57:16');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `userId` int(11) NOT NULL,
  `postId` int(11) NOT NULL,
  `dateLiked` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`userId`, `postId`, `dateLiked`) VALUES
(1, 1, '2023-12-10 23:24:16'),
(2, 1, '2023-12-11 08:07:09'),
(2, 2, '2023-12-10 23:24:16'),
(4, 1, '2023-12-11 08:07:09'),
(4, 2, '2023-12-11 13:13:53'),
(4, 4, '2023-12-10 23:24:16'),
(5, 1, '2023-12-11 08:07:09'),
(5, 3, '2023-12-11 13:39:26'),
(5, 5, '2023-12-10 23:24:16'),
(6, 1, '2023-12-11 08:07:09'),
(6, 6, '2023-12-10 23:24:16'),
(7, 1, '2023-12-11 08:07:09'),
(7, 7, '2023-12-10 23:24:16'),
(8, 1, '2023-12-11 08:07:09'),
(8, 8, '2023-12-10 23:24:16'),
(9, 1, '2023-12-11 08:07:09'),
(9, 9, '2023-12-10 23:24:16'),
(10, 1, '2023-12-11 08:07:09'),
(10, 10, '2023-12-10 23:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `notificationId` int(11) NOT NULL,
  `content` text DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `isRead` tinyint(1) DEFAULT NULL,
  `notificationDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`notificationId`, `content`, `userId`, `isRead`, `notificationDate`) VALUES
(1, 'You have a new follower.', 2, 0, '2023-12-10 23:24:16'),
(2, 'Your post has been liked.', 1, 0, '2023-12-10 23:24:16'),
(3, 'New comment on your post.', 3, 0, '2023-12-10 23:24:16'),
(4, 'Your post has been reposted.', 4, 0, '2023-12-10 23:24:16'),
(5, 'You have a new follower.', 5, 0, '2023-12-10 23:24:16'),
(6, 'Your post has been liked.', 6, 0, '2023-12-10 23:24:16'),
(7, 'New comment on your post.', 7, 0, '2023-12-10 23:24:16'),
(8, 'Your post has been reposted.', 8, 0, '2023-12-10 23:24:16'),
(9, 'You have a new follower.', 9, 0, '2023-12-10 23:24:16'),
(10, 'Your post has been liked.', 10, 0, '2023-12-10 23:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `postId` int(11) NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `programmingLanguage` varchar(50) DEFAULT NULL,
  `filePath` varchar(255) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `datePost` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`postId`, `title`, `description`, `programmingLanguage`, `filePath`, `userId`, `datePost`) VALUES
(1, 'First Post', 'An article or piece is a written work published in a print or electronic medium, for the propagation of news, research results, academic analysis or debate.', 'Java', '/files/java_post.txt', 1, '2023-12-10 23:24:16'),
(2, 'Second Post', 'Another post here.', 'Python', '/files/python_post.txt', 2, '2023-12-10 23:24:16'),
(3, 'Third Post', 'A third post for variety.', 'C++', '/files/cpp_post.txt', 3, '2023-12-10 23:24:16'),
(4, 'Fourth Post', 'More posts coming your way.', 'JavaScript', '/files/js_post.txt', 4, '2023-12-10 23:24:16'),
(5, 'Fifth Post', 'Yet another post.', 'Ruby', '/files/ruby_post.txt', 5, '2023-12-10 23:24:16'),
(6, 'Sixth Post', 'Post number six!', 'Python', '/files/python_post_2.txt', 6, '2023-12-10 23:24:16'),
(7, 'Seventh Post', 'Lucky number seven post.', 'Java', '/files/java_post_2.txt', 7, '2023-12-10 23:24:16'),
(8, 'Eighth Post', 'Post number eight!', 'JavaScript', '/files/js_post_2.txt', 8, '2023-12-10 23:24:16'),
(9, 'Ninth Post', 'Almost there, post number nine.', 'C++', '/files/cpp_post_2.txt', 9, '2023-12-10 23:24:16'),
(10, 'Tenth Post', 'The tenth and final post.', 'Ruby', '/files/ruby_post_2.txt', 10, '2023-12-10 23:24:16');

-- --------------------------------------------------------

--
-- Table structure for table `reposts`
--

CREATE TABLE `reposts` (
  `repostId` int(11) NOT NULL,
  `originalPostId` int(11) DEFAULT NULL,
  `userId` int(11) DEFAULT NULL,
  `dateReposted` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reposts`
--

INSERT INTO `reposts` (`repostId`, `originalPostId`, `userId`, `dateReposted`) VALUES
(1, 1, 2, '2023-12-10 23:24:16'),
(2, 2, 3, '2023-12-10 23:24:16'),
(3, 3, 4, '2023-12-10 23:24:16'),
(4, 4, 5, '2023-12-10 23:24:16'),
(5, 5, 6, '2023-12-10 23:24:16'),
(6, 6, 7, '2023-12-10 23:24:16'),
(7, 7, 8, '2023-12-10 23:24:16'),
(8, 8, 9, '2023-12-10 23:24:16'),
(9, 9, 10, '2023-12-10 23:24:16'),
(10, 10, 1, '2023-12-10 23:24:16'),
(11, 1, 3, '2023-12-11 13:35:14'),
(12, 1, 5, '2023-12-11 13:35:14'),
(13, 1, 7, '2023-12-11 13:35:14');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userId` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `registrationDate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userId`, `firstName`, `lastName`, `username`, `email`, `password`, `registrationDate`) VALUES
(1, 'John', 'Doe', 'john_doe', 'john@example.com', '$2y$10$UFYX9I0VIrhmA2iHlXwwiOCVFPg.YO2yBaJRGSwDRF2zcK05ZSVf2', '2023-12-10 23:24:15'),
(2, 'Jane', 'Smith', 'jane_smith', 'jane@example.com', 'securepassword', '2023-12-10 23:24:15'),
(3, 'Bob', 'Johnson', 'bob_johnson', 'bob@example.com', 'pass123', '2023-12-10 23:24:15'),
(4, 'Alice', 'Jones', 'alice_jones', 'alice@example.com', 'password123', '2023-12-10 23:24:15'),
(5, 'Charlie', 'Brown', 'charlie_brown', 'charlie@example.com', 'securepass', '2023-12-10 23:24:15'),
(6, 'Eva', 'Williams', 'eva_williams', 'eva@example.com', 'pass1234', '2023-12-10 23:24:15'),
(7, 'David', 'Miller', 'david_miller', 'david@example.com', 'password', '2023-12-10 23:24:15'),
(8, 'Grace', 'Smith', 'grace_smith', 'grace@example.com', 'securepass', '2023-12-10 23:24:15'),
(9, 'Frank', 'Davis', 'frank_davis', 'frank@example.com', 'pass123', '2023-12-10 23:24:15'),
(10, 'Hannah', 'Wilson', 'hannah_wilson', 'hannah@example.com', 'password', '2023-12-10 23:24:15'),
(11, 'Jomar', 'Lazaro', 'jomar_L', 'jomarlazaro0806@gmail.com', '$2y$10$Vh4WQ6Z9gatZu2XSL3vGZOxJGwXzI9wc1.oYBUQlXF2jLcDzsGK5S', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `chats`
--
ALTER TABLE `chats`
  ADD PRIMARY KEY (`chatId`),
  ADD KEY `senderId` (`senderId`),
  ADD KEY `receiverId` (`receiverId`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`commentId`),
  ADD KEY `postId` (`postId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`userId`,`postId`),
  ADD KEY `postId` (`postId`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`notificationId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`postId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `reposts`
--
ALTER TABLE `reposts`
  ADD PRIMARY KEY (`repostId`),
  ADD KEY `originalPostId` (`originalPostId`),
  ADD KEY `userId` (`userId`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `chats`
--
ALTER TABLE `chats`
  MODIFY `chatId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `commentId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `notificationId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `postId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `reposts`
--
ALTER TABLE `reposts`
  MODIFY `repostId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `chats`
--
ALTER TABLE `chats`
  ADD CONSTRAINT `chats_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `chats_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`postId`) REFERENCES `posts` (`postId`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`parentCommentId`) REFERENCES `comments` (`commentId`),
  ADD CONSTRAINT `comments_ibfk_3` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`),
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`postId`) REFERENCES `posts` (`postId`);

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);

--
-- Constraints for table `reposts`
--
ALTER TABLE `reposts`
  ADD CONSTRAINT `reposts_ibfk_1` FOREIGN KEY (`originalPostId`) REFERENCES `posts` (`postId`),
  ADD CONSTRAINT `reposts_ibfk_2` FOREIGN KEY (`userId`) REFERENCES `users` (`userId`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
