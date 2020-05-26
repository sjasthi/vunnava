<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Village.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Connection.php';
try {
    $connection = new Connection();
    $db = $connection->getConnection();
    $sqlExecSP = "call GetVillageInfo()";
    $stmt = $db->prepare($sqlExecSP);
    $stmt->execute();
    $i = 0;
    $villageIDs = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $village = new Village();
        $village->name = $row["VillageName"];
        $villages[$i] = $village;
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
