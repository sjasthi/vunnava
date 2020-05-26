<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Connection.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/Parameter.php';

function getParameters()
{
	$parameters = array();
	try {
		$connection = new Connection();
		$db = $connection->getConnection();
		$sqlExecSP = "call getParameters()";
		$stmt = $db->prepare($sqlExecSP);
		$stmt->execute();
		$i = 0;

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$parameter = new Parameter();
			$parameter->usage = $row["purpose"];
			$parameter->name = $row["name"];
			$parameter->value = $row["value"];
			$parameters[$row["purpose"]] = $parameter;
			$i++;
		}
		$connection = null;
		$stmt = NULL;
		$db = NULL;
		if($parameters['LibrarySingleMode']->value == 1)
		{
			$parameters['LibrarySingleMode']->value = true;
		}
		else
		{
			$parameters['LibrarySingleMode']->value = false;
		}
		if($parameters['AllowMultipleAdmins']->value == 1)
		{
			$parameters['AllowMultipleAdmins']->value = true;
		}
		else
		{
			$parameters['AllowMultipleAdmins']->value = false;
		}
		if($parameters['HideLibraryExport']->value == 1)
		{
			$parameters['HideLibraryExport']->value = true;
		}
		else
		{
			$parameters['HideLibraryExport']->value = false;
		}
		return $parameters;
	} catch (Exception $e) {
		echo $e;
	} finally {
		$connection = null;
		$stmt = NULL;
		$db = NULL;
	}
}
