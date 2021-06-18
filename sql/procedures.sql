
--
-- Dumping routines for database 'icsbinco_vunnava' 6/13/21
--
DELIMITER ;;
CREATE PROCEDURE `createUser`(IN `p_libid` INT, IN `p_username` VARCHAR(500), IN `p_pass` VARCHAR(500))
    NO SQL
INSERT INTO `users`(`username`, `password`, `libraryID`) VALUES (p_username, p_pass, p_libid) ;;

CREATE PROCEDURE `deleteAllBooks`()
    NO SQL
BEGIN
delete from inventory_item WHERE library_id = 0;
delete from borrows;
END ;;

CREATE PROCEDURE `deleteBlogEntry`(IN `p_id` INT)
    NO SQL
DELETE FROM blog WHERE blog.id = p_id ;;

CREATE PROCEDURE `deleteBlogImageURL`(IN `p_id` INT)
    NO SQL
UPDATE blog SET image = null WHERE blog.id = p_id ;;

CREATE PROCEDURE `DeleteBook`(IN `p_bookID` INT)
    NO SQL
BEGIN
Delete from inventory_item where id = p_bookID;
Delete from borrows where bookID = p_bookID;
END ;;

CREATE PROCEDURE `DeleteLibrary`(IN `p_id` INT)
    NO SQL
BEGIN
Call OrphanInventoryItems(p_id);
DELETE from library where id = p_id;
END ;;

CREATE PROCEDURE `deleteUser`(IN `p_id` INT)
    NO SQL
DELETE FROM users WHERE id = p_id ;;

CREATE PROCEDURE `getAllBorrows`()
    NO SQL
SELECT
bookID,
libraryID
FROM borrows ;;

CREATE PROCEDURE `getBlogEntries`(IN `p_offset` INT, IN `p_limit` INT)
    NO SQL
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
END ;;

CREATE PROCEDURE `getBlogEntryByID`(IN `p_id` INT)
    NO SQL
SELECT 
b.id,
u.username as username,
title,
createdDate,
content,
image,
video
FROM blog as b left join users u on b.userID = u.id
WHERE b.id = p_id ;;

CREATE PROCEDURE `getBookCostStats`()
    NO SQL
SELECT l.Name as name, max(CAST(price AS UNSIGNED)) as max, min(CAST(price AS UNSIGNED)) as min, AVG(CAST(price AS UNSIGNED)) as avg from inventory_item join library l on l.id = 0 where price > 0 ;;

CREATE PROCEDURE `getBookCostStatsByLibraryID`(IN `p_lid` INT)
    NO SQL
SELECT l.Name as name, max(CAST(price AS UNSIGNED)) as `max`, min(CAST(price AS UNSIGNED)) as `min`, AVG(CAST(price AS UNSIGNED)) as `avg` from inventory_item ii join library l on l.id = p_lid where price > 0 AND ii.id in (select bookID from borrows b where b.libraryID = p_lid) ;;

CREATE PROCEDURE `getBookCostTotals`()
    NO SQL
SELECT SUM(price)AS totalprice, l.Name as name  FROM inventory_item ii JOIN library l ON ii.library_id = l.id
WHERE price > 0 ;;

CREATE PROCEDURE `getBookCostTotalsByLibraryID`(IN `p_lid` INT)
    NO SQL
SELECT SUM(price) AS totalprice, l.Name as name FROM inventory_item ii JOIN library l ON p_lid = l.id
WHERE price > 0 AND ii.id in(SELECT bookID from borrows WHERE borrows.libraryID = p_lid AND p_lid > 0) ;;

CREATE PROCEDURE `getBookIDByKey`(IN `p_title` VARCHAR(200), IN `p_author` VARCHAR(200), IN `p_publisher` VARCHAR(200), IN `p_publishYear` VARCHAR(200))
    NO SQL
SELECT id FROM inventory_item
WHERE title = p_title AND author = p_author AND publisher = p_publisher AND publishYear = p_publishYear LIMIT 1 ;;

CREATE PROCEDURE `getBooksByPublisher`()
    NO SQL
SELECT COUNT(id) as num, publisher
FROM inventory_item
GROUP BY publisher
HAVING COUNT(id) > 2
ORDER by num DESC ;;

CREATE PROCEDURE `getBorrowsByLibraryID`(IN `p_libid` INT)
    NO SQL
SELECT 
bookID,
libraryID
from borrows b where b.libraryID = p_libid ;;

CREATE PROCEDURE `getBorrowsPerLibrary`()
    NO SQL
SELECT count(b.id) as count, 
l.Name 
from borrows b left join library l on l.id = b.libraryID
group by b.libraryID ;;

CREATE PROCEDURE `getCountsByAuthor`()
    NO SQL
SELECT COUNT(id) as num, author 
FROM inventory_item
GROUP BY author
HAVING count(id) > 2
ORDER BY num DESC ;;

CREATE PROCEDURE `getCountsByContributor`()
    NO SQL
SELECT COUNT(id) as num, donatedBy
FROM inventory_item
GROUP BY donatedBy
ORDER BY num DESC ;;

CREATE PROCEDURE `getCountsByCreator`()
    NO SQL
SELECT count(ii.id) as num, l.Name
FROM inventory_item ii JOIN library l on ii.createdByLibraryID = l.id
GROUP BY ii.createdByLibraryID
ORDER BY num DESC ;;

CREATE PROCEDURE `getFullInventory`(IN `p_offset` INT, IN `p_limit` INT)
    NO SQL
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
END ;;

CREATE PROCEDURE `getFullLibrarySize`()
    NO SQL
SELECT COUNT(id) AS total FROM inventory_item ;;

CREATE PROCEDURE `getInventoryByBorrowerID`(IN `p_lid` INT, IN `p_offset` INT, IN `p_limit` INT)
    NO SQL
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
END ;;

CREATE PROCEDURE `getInventoryByItemId`(IN `p_invID` INT)
    NO SQL
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
ORDER by ii.id ASC ;;

CREATE PROCEDURE `GetInventoryByLibraryId`()
    NO SQL
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
    ORDER by ii.id ASC ;;

CREATE PROCEDURE `GetLibraryInfo`()
    NO SQL
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
order by id ASC ;;

CREATE PROCEDURE `getParameters`()
    NO SQL
Select purpose, name, value 
from parameters ;;

CREATE PROCEDURE `getSearchedInventory`(IN `p_searchTerm` VARCHAR(500))
    NO SQL
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
ORDER by ii.id ASC ;;

CREATE PROCEDURE `getSearchedInventoryByBorrowerID`(IN `p_lid` INT, IN `p_searchTerm` VARCHAR(5000))
    NO SQL
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
ORDER by ii.id ASC ;;

CREATE PROCEDURE `getSearchedInventoryByID`(IN `p_lid` INT, IN `p_searchTerm` VARCHAR(5000))
    NO SQL
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
ORDER by ii.id ASC ;;

CREATE PROCEDURE `getSuperAdminCount`()
    NO SQL
SELECT COUNT(username) as `count` FROM users WHERE libraryID = 0 ;;

CREATE PROCEDURE `getUser`(IN `u` VARCHAR(500))
    NO SQL
Select username,
		id,
        libraryID,
        token,
        `password`
from users where username = u ;;

CREATE PROCEDURE `getUserExpiresTime`(IN `p_id` INT)
    NO SQL
SELECT expires FROM users WHERE id = p_id ;;

CREATE PROCEDURE `GetUserInfo`()
    NO SQL
SELECT id,
		username,
        libraryID
FROM users
ORDER BY libraryID ;;

CREATE PROCEDURE `getUserLibrary`(IN `p_id` INT)
    NO SQL
SELECT libraryID FROM users where id = p_id ;;

CREATE PROCEDURE `getUserToken`(IN `p_id` INT)
    NO SQL
SELECT token FROM users WHERE id = p_id ;;

CREATE PROCEDURE `GetVillageInfo`()
    NO SQL
Select DISTINCT(VillageName)
FROM library
Order by id ASC ;;

CREATE PROCEDURE `insertBlogEntry`(IN `p_userID` INT, IN `p_title` VARCHAR(5000), IN `p_content` VARCHAR(10000), IN `p_image` VARCHAR(500), IN `p_video` VARCHAR(500))
    NO SQL
INSERT INTO blog (`userID`,`createdDate`,`title`,`content`,`image`,`video`)
VALUES(p_userID,CURDATE(),p_title,p_content,p_image,p_video) ;;

CREATE PROCEDURE `insertBorrow`(IN `p_libID` INT, IN `p_bookID` INT)
    NO SQL
INSERT IGNORE INTO borrows (libraryID, bookID) values (p_libID, p_bookID) ;;

CREATE PROCEDURE `InsertInventoryItem`(IN `p_createdBy` INT, IN `p_callNumber` VARCHAR(5000), IN `p_title` VARCHAR(5000), IN `p_libraryId` INT, IN `p_author` VARCHAR(5000), IN `p_publisher` VARCHAR(5000), IN `p_publishYear` VARCHAR(5000), IN `p_numPages` INT, IN `p_price` VARCHAR(5000), IN `p_donatedBy` VARCHAR(5000), IN `p_contributionID` INT, IN `p_image` VARCHAR(500))
    NO SQL
BEGIN
INSERT IGNORE into inventory_item
(createdByLibraryID, callNumber, title, library_id, author, publisher, publishYear, numPages, price, donatedBy, contribution_id, image)
values
(p_createdBy, p_callNumber, p_title, 0 ,p_Author, p_publisher, p_publishYear, p_numPages, p_price, p_donatedBy, p_contributionID, p_image );
Select LAST_INSERT_ID() as maxID;
END ;;

CREATE PROCEDURE `InsertLibrary`(IN `p_Name` VARCHAR(5000), IN `p_Description` VARCHAR(5000), IN `p_VillageName` VARCHAR(5000), IN `p_MandalName` VARCHAR(500), IN `p_DistrictName` VARCHAR(500))
    NO SQL
BEGIN
Select IFNULL((max(id)+1),0) from library into @maxID;
Insert into library
(id, Name, Description, VillageName, MandalName, DistrictName)
values
(@maxID, p_Name, p_Description, p_VillageName, p_MandalName, p_DistrictName);
Select @maxID;
END ;;

CREATE PROCEDURE `logoutAllUsers`()
    NO SQL
UPDATE users
SET token = null,
expires = (UNIX_TIMESTAMP()-1)
where libraryID != 0 ;;

CREATE PROCEDURE `logoutUser`(IN `p_id` INT)
    NO SQL
UPDATE users
SET token = null,
expires = (UNIX_TIMESTAMP()-1)
where id = p_id ;;

CREATE PROCEDURE `OrphanInventoryItems`(IN `p_libID` INT)
    NO SQL
BEGIN
UPDATE inventory_item SET createdByLibraryID = 0 WHERE createdByLibraryID = p_libID;
DELETE FROM borrows where libraryID = p_libID;
END ;;

CREATE PROCEDURE `ReturnAllBooksByLibrary`(IN `p_libraryID` INT)
    NO SQL
delete from borrows where libraryID = p_libraryID ;;

CREATE PROCEDURE `ReturnBook`(IN `p_libID` INT, IN `p_bookID` INT)
    NO SQL
DELETE FROM borrows WHERE libraryID = p_libID and bookID = p_bookID ;;

CREATE PROCEDURE `SPTest`()
BEGIN
DECLARE i int;
declare j int;
set i = 5;
set j = 1377;
        INSERT INTO `borrows` (`id`, `bookID`, `libraryID`, `due`) 
        VALUES (i, j, 3, NULL);
        SET i=i+1;
        SET j=j+1;
END ;;

CREATE PROCEDURE `updateBlogEntry`(IN `p_id` INT, IN `p_userID` INT, IN `p_title` VARCHAR(500), IN `p_content` VARCHAR(10000), IN `p_video` VARCHAR(500))
    NO SQL
UPDATE blog SET 
userID = p_userID,
title = p_title,
content = p_content,
video = p_video
where id = p_id ;;

CREATE PROCEDURE `updateBlogImageURL`(IN `p_id` INT, IN `p_path` VARCHAR(500))
    NO SQL
UPDATE blog SET image = p_path where blog.id = p_id ;;

CREATE PROCEDURE `UpdateBook`(IN `p_id` INT, IN `p_callNumber` VARCHAR(5000), IN `p_title` VARCHAR(5000), IN `p_author` VARCHAR(5000), IN `p_publisher` VARCHAR(5000), IN `p_publishYear` VARCHAR(30), IN `p_numPages` INT(20), IN `p_donatedBy` VARCHAR(5000), IN `p_price` VARCHAR(5000), IN `p_libID` INT, IN `p_image` VARCHAR(500))
    NO SQL
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
    where id=p_id ;;

CREATE PROCEDURE `UpdateBookImage`(IN `p_id` INT, IN `p_path` VARCHAR(500))
    NO SQL
Update inventory_item
set 
    image = p_path
    where id=p_id ;;

CREATE PROCEDURE `UpdateLibrary`(IN `p_id` INT, IN `p_Name` VARCHAR(5000), IN `p_Description` VARCHAR(5000), IN `p_villageName` VARCHAR(5000), IN `p_mandalName` VARCHAR(500), IN `p_districtname` VARCHAR(500))
    NO SQL
Update library
set Name = p_Name,
	Description = p_Description,
    VillageName = p_villageName,
    MandalName = p_mandalName,
    DistrictName = p_districtName
    where id = p_id ;;

CREATE PROCEDURE `updateUsernameAndLib`(IN `p_id` INT, IN `p_libID` INT, IN `p_username` VARCHAR(500))
    NO SQL
UPDATE users SET 
username = p_username,
libraryID = p_libID
WHERE id = p_id ;;

CREATE PROCEDURE `updateUserPassword`(IN `p_id` INT, IN `p_pass` VARCHAR(500), IN `p_username` VARCHAR(500))
    NO SQL
UPDATE users SET `password` = p_pass
WHERE p_id = id AND username = p_username ;;

CREATE PROCEDURE `UpdateUserToken`(IN `p_id` INT(11), IN `p_token` VARCHAR(500), IN `p_expires` BIGINT)
    NO SQL
UPDATE users
SET token = p_token,
	expires = p_expires
WHERE id = p_id ;;
DELIMITER ;