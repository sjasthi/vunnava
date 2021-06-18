<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Connection.php';

function get_projects() {
    try {
        $connection = new Connection();
        $db = $connection->getConnection();

        $query = "SELECT * FROM project";
        $stmt = $db->prepare($query);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } else {
            return null;
        }
    } catch (Exception $e) {
        error_log('ERROR: ' . $e->getMessage(), 0);
    }
}
