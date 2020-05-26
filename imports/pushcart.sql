-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Apr 15, 2017 at 02:28 PM
-- Server version: 5.6.33
-- PHP Version: 7.0.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `pushcart`
--

DELIMITER $$
--
-- Procedures
--
CREATE  PROCEDURE `createUser` (IN `p_libid` INT, IN `p_username` VARCHAR(500), IN `p_pass` VARCHAR(500))  NO SQL
INSERT INTO `users`(`username`, `password`, `libraryID`) VALUES (p_username, p_pass, p_libid)$$

CREATE  PROCEDURE `deleteAllBooks` ()  NO SQL
BEGIN
delete from inventory_item WHERE library_id = 0;
delete from borrows;
END$$

CREATE  PROCEDURE `deleteBlogEntry` (IN `p_id` INT)  NO SQL
DELETE FROM blog WHERE blog.id = p_id$$

CREATE  PROCEDURE `deleteBlogImageURL` (IN `p_id` INT)  NO SQL
UPDATE blog SET image = null WHERE blog.id = p_id$$

CREATE  PROCEDURE `DeleteBook` (IN `p_bookID` INT)  NO SQL
BEGIN
Delete from inventory_item where id = p_bookID;
Delete from borrows where bookID = p_bookID;
END$$

CREATE  PROCEDURE `DeleteLibrary` (IN `p_id` INT)  NO SQL
BEGIN
Call OrphanInventoryItems(p_id);
DELETE from library where id = p_id;
END$$

CREATE  PROCEDURE `deleteUser` (IN `p_id` INT)  NO SQL
DELETE FROM users WHERE id = p_id$$

CREATE  PROCEDURE `getAllBorrows` ()  NO SQL
SELECT
bookID,
libraryID
FROM borrows$$

CREATE  PROCEDURE `getBlogEntries` (IN `p_offset` INT, IN `p_limit` INT)  NO SQL
BEGIN
DECLARE valFrom INT;
DECLARE valTo   INT;
SET valFrom = p_offset;
SET valTo = p_limit;
SELECT
b.id,
createdDate,
u.username,
title,
content,
image,
video
FROM blog as b left join users u on b.userID = u.id
ORDER BY createdDate DESC,b.id DESC
LIMIT valFrom, valTo;
END$$

CREATE  PROCEDURE `getBlogEntryByID` (IN `p_id` INT)  NO SQL
SELECT 
b.id,
u.username as username,
title,
createdDate,
content,
image,
video
FROM blog as b left join users u on b.userID = u.id
WHERE b.id = p_id$$

CREATE  PROCEDURE `getBookCostStats` ()  NO SQL
SELECT l.Name as name, max(CAST(price AS UNSIGNED)) as max, min(CAST(price AS UNSIGNED)) as min, AVG(CAST(price AS UNSIGNED)) as avg from inventory_item join library l on l.id = 0 where price > 0$$

CREATE  PROCEDURE `getBookCostStatsByLibraryID` (IN `p_lid` INT)  NO SQL
SELECT l.Name as name, max(CAST(price AS UNSIGNED)) as `max`, min(CAST(price AS UNSIGNED)) as `min`, AVG(CAST(price AS UNSIGNED)) as `avg` from inventory_item ii join library l on l.id = p_lid where price > 0 AND ii.id in (select bookID from borrows b where b.libraryID = p_lid)$$

CREATE  PROCEDURE `getBookCostTotals` ()  NO SQL
SELECT SUM(price)AS totalprice, l.Name as name  FROM inventory_item ii JOIN library l ON ii.library_id = l.id
WHERE price > 0$$

CREATE  PROCEDURE `getBookCostTotalsByLibraryID` (IN `p_lid` INT)  NO SQL
SELECT SUM(price) AS totalprice, l.Name as name FROM inventory_item ii JOIN library l ON p_lid = l.id
WHERE price > 0 AND ii.id in(SELECT bookID from borrows WHERE borrows.libraryID = p_lid AND p_lid > 0)$$

CREATE  PROCEDURE `getBookIDByKey` (IN `p_title` VARCHAR(200), IN `p_author` VARCHAR(200), IN `p_publisher` VARCHAR(200), IN `p_publishYear` VARCHAR(200))  NO SQL
SELECT id FROM inventory_item

WHERE title = p_title AND author = p_author AND publisher = p_publisher AND publishYear = p_publishYear LIMIT 1$$

CREATE  PROCEDURE `getBooksByPublisher` ()  NO SQL
SELECT COUNT(id) as num, publisher
FROM inventory_item
GROUP BY publisher
HAVING COUNT(id) > 2
ORDER by num DESC$$

CREATE  PROCEDURE `getBorrowsByLibraryID` (IN `p_libid` INT)  NO SQL
SELECT 
bookID,
libraryID
from borrows b where b.libraryID = p_libid$$

CREATE  PROCEDURE `getBorrowsPerLibrary` ()  NO SQL
SELECT count(b.id) as count, 
l.Name 
from borrows b left join library l on l.id = b.libraryID
group by b.libraryID$$

CREATE  PROCEDURE `getCountsByAuthor` ()  NO SQL
SELECT COUNT(id) as num, author 
FROM inventory_item
GROUP BY author
HAVING count(id) > 2
ORDER BY num DESC$$

CREATE  PROCEDURE `getCountsByContributor` ()  NO SQL
SELECT COUNT(id) as num, donatedBy
FROM inventory_item
GROUP BY donatedBy
ORDER BY num DESC$$

CREATE  PROCEDURE `getCountsByCreator` ()  NO SQL
SELECT count(ii.id) as num, l.Name
FROM inventory_item ii JOIN library l on ii.createdByLibraryID = l.id
GROUP BY ii.createdByLibraryID
ORDER BY num DESC$$

CREATE  PROCEDURE `getFullInventory` (IN `p_offset` INT, IN `p_limit` INT)  NO SQL
BEGIN
DECLARE valFrom INT;
DECLARE valTo   INT;

SET valFrom = p_offset;
SET valTo = p_limit;
Select
ii.title,
ii.id,
ii.createdByLibraryID,
ii.callNumber,
ii.donatedBy,
ii.numPages,
ii.price,
ii.publisher,
ii.publishYear,
ii.library_id,
ii.contribution_id,
ii.author,
ii.image,
l.Name as lname,
cbl.Name as createdByName
from inventory_item ii 
	join library l on ii.library_id = l.id
    join library cbl on ii.createdByLibraryID = cbl.id
ORDER by ii.id ASC
LIMIT valFrom, valTo;
END$$

CREATE  PROCEDURE `getFullLibrarySize` ()  NO SQL
SELECT COUNT(id) AS total FROM inventory_item$$

CREATE  PROCEDURE `getInventoryByBorrowerID` (IN `p_lid` INT, IN `p_offset` INT, IN `p_limit` INT)  NO SQL
BEGIN
DECLARE valFrom INT;
DECLARE valTo   INT;
SET valFrom = p_offset;
SET valTo = p_limit;
Select
	ii.title,
	ii.id,
    ii.createdByLibraryID,
	ii.callNumber,
	ii.donatedBy,
	ii.numPages,
	ii.price,
	ii.publisher,
	ii.publishYear,
	ii.library_id,
	ii.contribution_id,
	ii.author,
	ii.image,
	l.Name as lname,
    cbl.Name as createdByName
from inventory_item ii 
	join library l on ii.library_id = l.id
    join library cbl on ii.createdByLibraryID = cbl.id
    where ii.id IN(SELECT bookID from borrows b where b.libraryID = p_lid )
    ORDER by ii.id ASC
LIMIT valFrom, valTo;
END$$

CREATE  PROCEDURE `getInventoryByItemId` (IN `p_invID` INT)  NO SQL
Select
ii.title,
ii.id,
ii.createdByLibraryID,
ii.callNumber,
ii.donatedBy,
ii.numPages,
ii.price,
ii.publisher,
ii.publishYear,
ii.library_id,
ii.contribution_id,
ii.author,
ii.image,
l.Name as lname,
cbl.Name as createdByName
from inventory_item ii 
	join library l on ii.library_id = l.id
    join library cbl on ii.createdByLibraryID = cbl.id

where ii.id = p_invID
ORDER by ii.id ASC$$

CREATE  PROCEDURE `GetInventoryByLibraryId` ()  NO SQL
Select
	ii.title,
	ii.id,
    ii.createdByLibraryID,
	ii.callNumber,
	ii.donatedBy,
	ii.numPages,
	ii.price,
	ii.publisher,
	ii.publishYear,
	ii.library_id,
	ii.contribution_id,
	ii.author,
	ii.image,
	l.Name as lname
	from inventory_item ii join library l on ii.library_id = l.id
    ORDER by ii.id ASC$$

CREATE  PROCEDURE `GetLibraryInfo` ()  NO SQL
SELECT l.id,
l.Name,
l.Description,
l.DistrictName as dName,
l.MandalName as mName,
l.VillageName as vName,
CASE when l.id = 0 THEN (SELECT COUNT(*) FROM inventory_item)  
    ELSE (SELECT COUNT(*) FROM borrows b WHERE b.LibraryID = l.id) 
END AS bookCount

from library as l
order by id ASC$$

CREATE  PROCEDURE `getParameters` ()  NO SQL
Select purpose, name, value 
from parameters$$

CREATE  PROCEDURE `getSearchedInventory` (IN `p_searchTerm` VARCHAR(500))  NO SQL
Select
ii.title,
ii.id,
ii.createdByLibraryID,
ii.callNumber,
ii.donatedBy,
ii.numPages,
ii.price,
ii.publisher,
ii.publishYear,
ii.library_id,
ii.contribution_id,
ii.author,
ii.image,
l.Name as lname,
cbl.Name as createdByName
from inventory_item ii 
	join library l on ii.library_id = l.id
    join library cbl on ii.createdByLibraryID = cbl.id
where ii.title LIKE CONCAT('%', p_searchTerm, '%') or ii.author LIKE CONCAT('%', p_searchTerm, '%') or ii.publisher LIKE CONCAT('%', p_searchTerm, '%') or ii.publishYear LIKE CONCAT('%', p_searchTerm, '%') or ii.callNumber LIKE CONCAT('%', p_searchTerm, '%') or ii.donatedBy LIKE CONCAT('%', p_searchTerm, '%')or ii.price LIKE CONCAT('%', p_searchTerm, '%')
ORDER by ii.id ASC$$

CREATE  PROCEDURE `getSearchedInventoryByBorrowerID` (IN `p_lid` INT, IN `p_searchTerm` VARCHAR(5000))  NO SQL
Select
ii.title,
ii.id,
ii.createdByLibraryID,
ii.callNumber,
ii.donatedBy,
ii.numPages,
ii.price,
ii.publisher,
ii.publishYear,
ii.library_id,
ii.contribution_id,
ii.author,
ii.image,
l.Name as lname,
cbl.Name as createdByName
from inventory_item ii 
	join library l on ii.library_id = l.id
    join library cbl on ii.createdByLibraryID = cbl.id
where (ii.title LIKE CONCAT('%', p_searchTerm, '%') or ii.author LIKE CONCAT('%', p_searchTerm, '%') or ii.publisher LIKE CONCAT('%', p_searchTerm, '%') or ii.publishYear LIKE CONCAT('%', p_searchTerm, '%') or ii.callNumber LIKE CONCAT('%', p_searchTerm, '%') or ii.donatedBy LIKE CONCAT('%', p_searchTerm, '%') or ii.price LIKE CONCAT('%', p_searchTerm, '%')) AND ii.id in (SELECT bookID from borrows b where b.libraryID = p_lid)
ORDER by ii.id ASC$$

CREATE  PROCEDURE `getSearchedInventoryByID` (IN `p_lid` INT, IN `p_searchTerm` VARCHAR(5000))  NO SQL
Select
ii.title,
ii.id,
ii.createdByLibraryID,
ii.callNumber,
ii.donatedBy,
ii.numPages,
ii.price,
ii.publisher,
ii.publishYear,
ii.library_id,
ii.contribution_id,
ii.author,
ii.image,
l.Name as lname,
cbl.Name as createdByName
from inventory_item ii 
	join library l on ii.library_id = l.id
    join library cbl on ii.createdByLibraryID = cbl.id
where ii.library_id = p_lid AND (ii.title LIKE CONCAT('%', p_searchTerm, '%') or ii.author LIKE CONCAT('%', p_searchTerm, '%') or ii.publisher LIKE CONCAT('%', p_searchTerm, '%') or ii.publishYear LIKE CONCAT('%', p_searchTerm, '%') or ii.callNumber LIKE CONCAT('%', p_searchTerm, '%') or ii.donatedBy LIKE CONCAT('%', p_searchTerm, '%') or ii.price LIKE CONCAT('%', p_searchTerm, '%'))
ORDER by ii.id ASC$$

CREATE  PROCEDURE `getSuperAdminCount` ()  NO SQL
SELECT COUNT(username) as `count` FROM users WHERE libraryID = 0$$

CREATE  PROCEDURE `getUser` (IN `u` VARCHAR(500))  NO SQL
Select username,
		id,
        libraryID,
        token,
        `password`
from users where username = u$$

CREATE  PROCEDURE `getUserExpiresTime` (IN `p_id` INT)  NO SQL
SELECT expires FROM users WHERE id = p_id$$

CREATE  PROCEDURE `GetUserInfo` ()  NO SQL
SELECT id,
		username,
        libraryID
FROM users
ORDER BY libraryID$$

CREATE  PROCEDURE `getUserLibrary` (IN `p_id` INT)  NO SQL
SELECT libraryID FROM users where id = p_id$$

CREATE  PROCEDURE `getUserToken` (IN `p_id` INT)  NO SQL
SELECT token FROM users WHERE id = p_id$$

CREATE  PROCEDURE `GetVillageInfo` ()  NO SQL
Select DISTINCT(VillageName)
FROM library
Order by id ASC$$

CREATE  PROCEDURE `insertBlogEntry` (IN `p_userID` INT, IN `p_title` VARCHAR(5000), IN `p_content` VARCHAR(10000), IN `p_image` VARCHAR(500), IN `p_video` VARCHAR(500))  NO SQL
INSERT INTO blog (`userID`,`createdDate`,`title`,`content`,`image`,`video`)
VALUES(p_userID,CURDATE(),p_title,p_content,p_image,p_video)$$

CREATE  PROCEDURE `insertBorrow` (IN `p_libID` INT, IN `p_bookID` INT)  NO SQL
INSERT IGNORE INTO borrows (libraryID, bookID) values (p_libID, p_bookID)$$

CREATE  PROCEDURE `InsertInventoryItem` (IN `p_createdBy` INT, IN `p_callNumber` VARCHAR(5000), IN `p_title` VARCHAR(5000), IN `p_libraryId` INT, IN `p_author` VARCHAR(5000), IN `p_publisher` VARCHAR(5000), IN `p_publishYear` VARCHAR(5000), IN `p_numPages` INT, IN `p_price` VARCHAR(5000), IN `p_donatedBy` VARCHAR(5000), IN `p_contributionID` INT, IN `p_image` VARCHAR(500))  NO SQL
BEGIN

INSERT IGNORE into inventory_item

(createdByLibraryID, callNumber, title, library_id, author, publisher, publishYear, numPages, price, donatedBy, contribution_id, image)
values
(p_createdBy, p_callNumber, p_title, 0 ,p_Author, p_publisher, p_publishYear, p_numPages, p_price, p_donatedBy, p_contributionID, p_image );

Select LAST_INSERT_ID() as maxID;

END$$

CREATE  PROCEDURE `InsertLibrary` (IN `p_Name` VARCHAR(5000), IN `p_Description` VARCHAR(5000), IN `p_VillageName` VARCHAR(5000), IN `p_MandalName` VARCHAR(500), IN `p_DistrictName` VARCHAR(500))  NO SQL
BEGIN
Select IFNULL((max(id)+1),0) from library into @maxID;
Insert into library

(id, Name, Description, VillageName, MandalName, DistrictName)
values
(@maxID, p_Name, p_Description, p_VillageName, p_MandalName, p_DistrictName);

Select @maxID;
END$$

CREATE  PROCEDURE `logoutAllUsers` ()  NO SQL
UPDATE users
SET token = null,
expires = (UNIX_TIMESTAMP()-1)
where libraryID != 0$$

CREATE  PROCEDURE `logoutUser` (IN `p_id` INT)  NO SQL
UPDATE users
SET token = null,
expires = (UNIX_TIMESTAMP()-1)
where id = p_id$$

CREATE  PROCEDURE `OrphanInventoryItems` (IN `p_libID` INT)  NO SQL
BEGIN
UPDATE inventory_item SET createdByLibraryID = 0 WHERE createdByLibraryID = p_libID;
DELETE FROM borrows where libraryID = p_libID;
END$$

CREATE  PROCEDURE `ReturnAllBooksByLibrary` (IN `p_libraryID` INT)  NO SQL
delete from borrows where libraryID = p_libraryID$$

CREATE  PROCEDURE `ReturnBook` (IN `p_libID` INT, IN `p_bookID` INT)  NO SQL
DELETE FROM borrows WHERE libraryID = p_libID and bookID = p_bookID$$

CREATE  PROCEDURE `updateBlogEntry` (IN `p_id` INT, IN `p_userID` INT, IN `p_title` VARCHAR(500), IN `p_content` VARCHAR(10000), IN `p_video` VARCHAR(500))  NO SQL
UPDATE blog SET 
userID = p_userID,
title = p_title,
content = p_content,
video = p_video
where id = p_id$$

CREATE  PROCEDURE `updateBlogImageURL` (IN `p_id` INT, IN `p_path` VARCHAR(500))  NO SQL
UPDATE blog SET image = p_path where blog.id = p_id$$

CREATE  PROCEDURE `UpdateBook` (IN `p_id` INT, IN `p_callNumber` VARCHAR(5000), IN `p_title` VARCHAR(5000), IN `p_author` VARCHAR(5000), IN `p_publisher` VARCHAR(5000), IN `p_publishYear` VARCHAR(30), IN `p_numPages` INT(20), IN `p_donatedBy` VARCHAR(5000), IN `p_price` VARCHAR(5000), IN `p_libID` INT, IN `p_image` VARCHAR(500))  NO SQL
Update inventory_item

set title = p_title,
	callNumber = p_callNumber,
    author = p_author,
    publisher = p_publisher,
    publishYear = p_publishYear,
    numPages = p_numPages,
    donatedBy = p_donatedBy,
    price = p_price,
    library_id = 0,
    image = p_image
    where id=p_id$$

CREATE  PROCEDURE `UpdateBookImage` (IN `p_id` INT, IN `p_path` VARCHAR(500))  NO SQL
Update inventory_item

set 
    image = p_path
    where id=p_id$$

CREATE  PROCEDURE `UpdateLibrary` (IN `p_id` INT, IN `p_Name` VARCHAR(5000), IN `p_Description` VARCHAR(5000), IN `p_villageName` VARCHAR(5000), IN `p_mandalName` VARCHAR(500), IN `p_districtname` VARCHAR(500))  NO SQL
Update library

set Name = p_Name,
	Description = p_Description,
    VillageName = p_villageName,
    MandalName = p_mandalName,
    DistrictName = p_districtName
    where id = p_id$$

CREATE  PROCEDURE `updateUsernameAndLib` (IN `p_id` INT, IN `p_libID` INT, IN `p_username` VARCHAR(500))  NO SQL
UPDATE users SET 
username = p_username,
libraryID = p_libID
WHERE id = p_id$$

CREATE  PROCEDURE `updateUserPassword` (IN `p_id` INT, IN `p_pass` VARCHAR(500), IN `p_username` VARCHAR(500))  NO SQL
UPDATE users SET `password` = p_pass
WHERE p_id = id AND username = p_username$$

CREATE  PROCEDURE `UpdateUserToken` (IN `p_id` INT(11), IN `p_token` VARCHAR(500), IN `p_expires` BIGINT)  NO SQL
UPDATE users
SET token = p_token,
	expires = p_expires
WHERE id = p_id$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `blog`
--

CREATE TABLE `blog` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `createdDate` date NOT NULL,
  `title` varchar(500) NOT NULL,
  `content` varchar(10000) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL,
  `video` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `blog`
--

INSERT INTO `blog` (`id`, `userID`, `createdDate`, `title`, `content`, `image`, `video`) VALUES
(1, 5, '2017-03-17', 'A pushcart to promote poetry - Aksharam | 10tv', 'Lorem ipsum dolor sit amet, vis cu dicunt delenit. Vis no solum fugit, delectus corrumpit mnesarchum eu his. In case phaedrum persecuti sit, eam splendide deseruisse ei. Ei his blandit perpetua.\r\n\r\nHis accusam theophrastus an. Summo utinam delicata pri cu, te per tantas quaeque accusata. Aliquam delicata maluisset ea eam. Duo ne impedit reprimique neglegentur, in impetus aliquid detracto sea, est no fuisset fabellas. Per putent detracto evertitur cu, luptatum quaestio mea ei. Dissentiet dissentiunt vituperatoribus ei vis.', NULL, 'https://www.youtube.com/embed/Q3n8Cj_oVXY'),
(2, 5, '2017-03-31', 'Books On Wheels | TV5 News', 'Lorem ipsum dolor sit amet, vis cu dicunt delenit. Vis no solum fugit, delectus corrumpit mnesarchum eu his. In case phaedrum persecuti sit, eam splendide deseruisse ei. Ei his blandit perpetua.\r\n\r\nHis accusam theophrastus an. Summo utinam delicata pri cu, te per tantas quaeque accusata. Aliquam delicata maluisset ea eam. Duo ne impedit reprimique neglegentur, in impetus aliquid detracto sea, est no fuisset fabellas. Per putent detracto evertitur cu, luptatum quaestio mea ei. Dissentiet dissentiunt vituperatoribus ei vis.', NULL, 'https://www.youtube.com/embed/ZphTDdYlprU'),
(3, 5, '2017-03-25', 'Topudu Bandi - Mobile Book Shop in Hyderabad | TV5 News', 'Lorem ipsum dolor sit amet, vis cu dicunt delenit. Vis no solum fugit, delectus corrumpit mnesarchum eu his. In case phaedrum persecuti sit, eam splendide deseruisse ei. Ei his blandit perpetua.\n\nHis accusam theophrastus an. Summo utinam delicata pri cu, te per tantas quaeque accusata. Aliquam delicata maluisset ea eam. Duo ne impedit reprimique neglegentur, in impetus aliquid detracto sea, est no fuisset fabellas. Per putent detracto evertitur cu, luptatum quaestio mea ei. Dissentiet dissentiunt vituperatoribus ei vis.', NULL, 'https://www.youtube.com/embed/sO3wBewW4nE'),
(4, 5, '2017-03-25', 'Hyderabad Man Peddles Pushcart of Telugu Books | Sakshi TV', '', NULL, 'https://www.youtube.com/embed/pcjiH03ZZDE'),
(5, 5, '2017-03-03', 'Sheik Sadiq Ali peddles poetry books using a pushcart | V6 news', 'Lorem ipsum dolor sit amet, vis cu dicunt delenit. Vis no solum fugit, delectus corrumpit mnesarchum eu his. In case phaedrum persecuti sit, eam splendide deseruisse ei. Ei his blandit perpetua.\r\n\r\nHis accusam theophrastus an. Summo utinam delicata pri cu, te per tantas quaeque accusata. Aliquam delicata maluisset ea eam. Duo ne impedit reprimique neglegentur, in impetus aliquid detracto sea, est no fuisset fabellas. Per putent detracto evertitur cu, luptatum quaestio mea ei. Dissentiet dissentiunt vituperatoribus ei vis.', NULL, 'https://www.youtube.com/embed/Z6Er2KyTRz8');

-- --------------------------------------------------------

--
-- Table structure for table `borrows`
--

CREATE TABLE `borrows` (
  `id` int(11) NOT NULL,
  `bookID` int(11) NOT NULL,
  `libraryID` int(11) NOT NULL,
  `due` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `contribution`
--

CREATE TABLE `contribution` (
  `id` int(11) NOT NULL,
  `ContributionType_id` int(11) NOT NULL,
  `Library_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contribution`
--

INSERT INTO `contribution` (`id`, `ContributionType_id`, `Library_id`) VALUES
(0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `contributiontype`
--

CREATE TABLE `contributiontype` (
  `id` int(11) NOT NULL,
  `Type` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contributiontype`
--

INSERT INTO `contributiontype` (`id`, `Type`) VALUES
(0, 'Book');

-- --------------------------------------------------------

--
-- Table structure for table `inventory_item`
--

CREATE TABLE `inventory_item` (
  `id` int(11) NOT NULL,
  `callNumber` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `library_id` int(11) NOT NULL,
  `createdByLibraryID` int(11) NOT NULL,
  `contribution_id` int(11) DEFAULT NULL,
  `author` varchar(200) DEFAULT NULL,
  `publisher` varchar(200) DEFAULT NULL,
  `publishYear` varchar(20) DEFAULT NULL,
  `numPages` int(11) DEFAULT NULL,
  `donatedBy` varchar(5000) DEFAULT NULL,
  `price` varchar(200) DEFAULT NULL,
  `image` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `library`
--

CREATE TABLE `library` (
  `id` int(11) NOT NULL,
  `Name` varchar(5000) NOT NULL,
  `DistrictName` varchar(500) DEFAULT NULL,
  `MandalName` varchar(500) DEFAULT NULL,
  `VillageName` varchar(5000) DEFAULT NULL,
  `Description` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `library`
--

INSERT INTO `library` (`id`, `Name`, `DistrictName`, `MandalName`, `VillageName`, `Description`) VALUES
(0, 'AnnaMayya Library', 'AnnaMayya District', 'AnnaMayya Mandal', 'AnnaMayya', 'Main Library AnnaMayya');

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `id` int(11) NOT NULL,
  `purpose` varchar(250) NOT NULL,
  `name` varchar(250) NOT NULL,
  `value` varchar(5000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `parameters`
--

INSERT INTO `parameters` (`id`, `purpose`, `name`, `value`) VALUES
(1, 'blurb1', 'Community Libraries', 'Topudu Bandi is a great way to get literature into the hands of community members. Check out all of the libraries for the participating villages!'),
(2, 'blurb2', 'View our Blog!', 'Find out all of the newest happenings with Topudu Bandi and our village libraries. there are new updates often, and we have video and pictures.'),
(3, 'blurb3', 'More information', 'Interested in the details? Learn more by visiting our about page or contact page. We love hearing from people from all over the world.'),
(4, 'abouttext', 'About', 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sed voluptate nihil eum consectetur similique? Consectetur, quod, incidunt, harum nisi dolores delectus reprehenderit voluptatem perferendis dicta dolorem non blanditiis ex fugiat.\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Saepe, magni, aperiam vitae illum voluptatum aut sequi impedit non velit ab ea pariatur sint quidem corporis eveniet. Odit, temporibus reprehenderit dolorum!\r\n\r\nLorem ipsum dolor sit amet, consectetur adipisicing elit. Et, consequuntur, modi mollitia corporis ipsa voluptate corrupti eum ratione ex ea praesentium quibusdam? Aut, in eum facere corrupti necessitatibus perspiciatis quis?'),
(5, 'systemname', 'name', 'Topudu Bandi'),
(6, 'maplocation', 'locationURL', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3807.1201800345884!2d78.5081594647663!3d17.406019238067376!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x50524cd95118da8a!2sRamnagar+Gundu+Bus+Stop!5e0!3m2!1sen!2sus!4v1488139528368'),
(7, 'aboutaddress', 'addresslocation', '1-9-286/2, Near Ramnagar<br>Gundu Bus Stop<br>Hyderabad - 500 044<br>\r\n                India'),
(8, 'phone1', 'phone1', ': 011.91.934 610 8090'),
(9, 'phone2', 'phone2', ': 011.91.738 686 8267'),
(10, 'facebooklink', 'facebook', '"https://www.facebook.com/Topudu-BANDI-365110060280487/?ref=page_internal&hc_ref=PAGES_TIMELINE&fref=nf"'),
(11, 'systemversion', 'version', 'v.1.0.4-9-17');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(500) NOT NULL,
  `token` varchar(500) DEFAULT NULL,
  `expires` bigint(20) DEFAULT NULL,
  `libraryID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `token`, `expires`, `libraryID`) VALUES
(5, 'admin', '$2y$10$WQtaA4BvivKovbQlVyTL0eUWDwZnrEvx.6S..cQwaz5CER7QuIB1e', 'dhcSzqTNoBVJRQvL', 1492287292, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `blog`
--
ALTER TABLE `blog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `borrows`
--
ALTER TABLE `borrows`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `bookID` (`bookID`,`libraryID`);

--
-- Indexes for table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`id`),
  ADD KEY `Contribution_ContributionType` (`ContributionType_id`),
  ADD KEY `Contribution_Library` (`Library_id`);

--
-- Indexes for table `contributiontype`
--
ALTER TABLE `contributiontype`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `inventory_item`
--
ALTER TABLE `inventory_item`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`title`,`author`,`publisher`,`publishYear`),
  ADD KEY `Inventory_Item_Contribution` (`contribution_id`),
  ADD KEY `Inventory_Item_Library` (`library_id`),
  ADD KEY `createdByLibraryID` (`createdByLibraryID`);

--
-- Indexes for table `library`
--
ALTER TABLE `library`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `purpose` (`purpose`);

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
-- AUTO_INCREMENT for table `blog`
--
ALTER TABLE `blog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `borrows`
--
ALTER TABLE `borrows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `inventory_item`
--
ALTER TABLE `inventory_item`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `contribution`
--
ALTER TABLE `contribution`
  ADD CONSTRAINT `Contribution_ContributionType` FOREIGN KEY (`ContributionType_id`) REFERENCES `contributiontype` (`id`),
  ADD CONSTRAINT `Contribution_Library` FOREIGN KEY (`Library_id`) REFERENCES `library` (`id`);

--
-- Constraints for table `inventory_item`
--
ALTER TABLE `inventory_item`
  ADD CONSTRAINT `Inventory_Item_Contribution` FOREIGN KEY (`contribution_id`) REFERENCES `contribution` (`id`),
  ADD CONSTRAINT `Inventory_Item_CreatedByLibrary` FOREIGN KEY (`createdByLibraryID`) REFERENCES `library` (`id`),
  ADD CONSTRAINT `Inventory_Item_Library` FOREIGN KEY (`library_id`) REFERENCES `library` (`id`);
