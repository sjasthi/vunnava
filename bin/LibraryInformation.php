<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Library.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Connection.php';

$libraryIDs = array();
try {
    $connection = new Connection();
    $db = $connection->getConnection();
    $sqlExecSP = "call GetLibraryInfo()";
    $stmt = $db->prepare($sqlExecSP);
    $stmt->execute();
    $i = 0;

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $library = new Library();
        $library->id = $row["id"];
        Array_push($libraryIDs,$row['id']);
        $library->name = $row["Name"];
        $library->description = $row["Description"];
		$library->mandalName = $row["mName"];
		$library->districtName = $row["dName"];
        $library->villageName = $row["vName"];
        $library->bookCount = $row["bookCount"];
        $libraries[$i] = $library;
        $i++;
    }
    $connection = null;
    $stmt = NULL;
    $db = NULL;
} catch (Exception $e) {
    echo $e;
} finally {
    $connection = null;
    $stmt = NULL;
    $db = NULL;
}
