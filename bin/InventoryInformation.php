<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryItem.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Connection.php';


function getFullInventory($offset,$limit)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
		$offset = filter_var($offset, FILTER_SANITIZE_STRING);
		$limit = filter_var($limit, FILTER_SANITIZE_STRING);
        $sqlExecSP = "call getFullInventory(
			\"" . $offset . "\",
            \"" . $limit . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new InventoryItem();
            $item->item_id = $row["id"];
			$item->createdByLibraryID = $row["createdByLibraryID"];
            $item->callNumber = $row["callNumber"];
            $item->title = $row["title"];
            $item->contribution_id = $row["contribution_id"];
            $item->library_id = $row["library_id"];
            $item->author = $row["author"];
            $item->publisher = $row["publisher"];
            $item->publishYear = $row["publishYear"];
            $item->numPages = $row["numPages"];
            $item->price = $row["price"];
            $item->donatedBy = $row["donatedBy"];
            $item->image = $row["image"];
            $item->libraryName = $row["lname"];
            $item->libraryCreatedByName = $row["createdByName"];
            $inventoryItems[$i] = $item;
            $i++;
        }
        $connection = null;
        $stmt = NULL;
        $db = NULL;
        if ($i > 0) {
            return $inventoryItems;
        } else {
            return null;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}

function getSearchedInventory($searchTerm)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);
        $sqlExecSP = "call getSearchedInventory(\"" . $searchTerm . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new InventoryItem();
            $item->item_id = $row["id"];
			$item->createdByLibraryID = $row["createdByLibraryID"];
            $item->callNumber = $row["callNumber"];
            $item->title = $row["title"];
            $item->contribution_id = $row["contribution_id"];
            $item->library_id = $row["library_id"];
            $item->author = $row["author"];
            $item->publisher = $row["publisher"];
            $item->publishYear = $row["publishYear"];
            $item->numPages = $row["numPages"];
            $item->price = $row["price"];
            $item->donatedBy = $row["donatedBy"];
            $item->image = $row["image"];
            $item->libraryName = $row["lname"];
			$item->libraryCreatedByName = $row["createdByName"];
            $inventoryItems[$i] = $item;
            $i++;
        }
        $connection = null;
        $stmt = NULL;
        $db = NULL;
        if ($i > 0) {
            return $inventoryItems;
        } else {
            return null;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}


function getSearchedInventoryByID($libID, $searchTerm)
{

    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $searchTerm = filter_var($searchTerm, FILTER_SANITIZE_STRING);
        $libID = filter_var($libID, FILTER_SANITIZE_STRING);
        if ($libID == 0) {
            $sqlExecSP = "call getSearchedInventoryByID(\"" . $libID . "\",\"" . $searchTerm . "\")";
        } else {
            $sqlExecSP = "call getSearchedInventoryByBorrowerID(\"" . $libID . "\",\"" . $searchTerm . "\")";
        }
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new InventoryItem();
            $item->item_id = $row["id"];
			$item->createdByLibraryID = $row["createdByLibraryID"];
            $item->callNumber = $row["callNumber"];
            $item->title = $row["title"];
            $item->contribution_id = $row["contribution_id"];
            $item->library_id = $row["library_id"];
            $item->author = $row["author"];
            $item->publisher = $row["publisher"];
            $item->publishYear = $row["publishYear"];
            $item->numPages = $row["numPages"];
            $item->price = $row["price"];
            $item->donatedBy = $row["donatedBy"];
            $item->image = $row["image"];
            $item->libraryName = $row["lname"];
            $item->libraryCreatedByName = $row["createdByName"];
            $inventoryItems[$i] = $item;
            $i++;
        }
        $connection = null;
        $stmt = NULL;
        $db = NULL;
        if ($i > 0) {
            return $inventoryItems;
        } else {
            return null;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}

function getInventoryByLibraryId($libID,$offset,$limit)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $libID = filter_var($libID, FILTER_SANITIZE_STRING);
		$offset = filter_var($offset, FILTER_SANITIZE_STRING);
		$limit = filter_var($limit, FILTER_SANITIZE_STRING);
        if ($libID == 0) {
            $sqlExecSP = "call getFullInventory(
			\"" . $offset . "\",
            \"" . $limit . "\")";
        } else {
            $sqlExecSP = "call GetInventoryByBorrowerId(
			\"" . $libID . "\",
            \"" . $offset . "\",
			\"" . $limit . "\")";
        }

        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        $i = 0;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $item = new InventoryItem();
            $item->item_id = $row["id"];
			$item->createdByLibraryID = $row["createdByLibraryID"];
            $item->callNumber = $row["callNumber"];
            $item->title = $row["title"];
            $item->contribution_id = $row["contribution_id"];
            $item->library_id = $row["library_id"];
            $item->author = $row["author"];
            $item->publisher = $row["publisher"];
            $item->publishYear = $row["publishYear"];
            $item->numPages = $row["numPages"];
            $item->price = $row["price"];
            $item->donatedBy = $row["donatedBy"];
            $item->image = $row["image"];
            $item->libraryName = $row["lname"];
			$item->libraryCreatedByName = $row["createdByName"];
            $inventoryItems[$i] = $item;
            $i++;
        }
        $connection = null;
        $stmt = NULL;
        $db = NULL;
        if ($i > 0) {
            return $inventoryItems;
        } else {
            return null;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}


function getInventoryByItemId($itemid)
{
    try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $itemid = filter_var($itemid, FILTER_SANITIZE_STRING);
        $sqlExecSP = "CALL getInventoryByItemId(\"" . $itemid . "\")";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $item = new InventoryItem();
                $item->item_id = $row["id"];
				$item->createdByLibraryID = $row["createdByLibraryID"];
                $item->callNumber = $row["callNumber"];
                $item->title = $row["title"];
                $item->contribution_id = $row["contribution_id"];
                $item->library_id = $row["library_id"];
                $item->author = $row["author"];
                $item->publisher = $row["publisher"];
                $item->publishYear = $row["publishYear"];
                $item->numPages = $row["numPages"];
                $item->price = $row["price"];
                $item->donatedBy = $row["donatedBy"];
                $item->image = $row["image"];
                $item->libraryName = $row["lname"];
                $item->libraryCreatedByName = $row["createdByName"];
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;
            return $item;
        } else {
            return null;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
function getfullInventorySize()
{
	$return = 0;
	try {
        $connection = new Connection();
        $db = $connection->getConnection();
        $sqlExecSP = "CALL getFullLibrarySize()";
        $stmt = $db->prepare($sqlExecSP);
        $stmt->execute();
        if ($stmt->rowCount() == 1) {
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $return =  $row["total"];
            }
            $connection = null;
            $stmt = NULL;
            $db = NULL;
            return $return;
        } else {
            return 0;
        }
    } catch (Exception $e) {
        echo $e;
    } finally {
        $connection = null;
        $stmt = NULL;
        $db = NULL;
    }
}
