<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/blogentry.php';

function getBlogEntries($offset,$limit)
{
	try {
		
		$offset = filter_var($offset, FILTER_SANITIZE_STRING);
		$limit = filter_var($limit, FILTER_SANITIZE_STRING);
		$connection = new Connection();
		$db = $connection->getConnection();
		$sqlExecSP = "call getBlogEntries(
			\"" . $offset . "\",
            \"" . $limit . "\")";
		$stmt = $db->prepare($sqlExecSP);
		$stmt->execute();
		$i = 0;
		$blogs = array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$blog = new blogentry();
			$blog->id = $row["id"];
			$blog->userName = $row["username"];
			$blog->title = $row["title"];
			$blog->createdDate = $row["createdDate"];
			$blog->content = $row["content"];
			$blog->image = $row["image"];
			$blog->video = $row["video"];
			$blogs[$i] = $blog;
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
	return $blogs;
}
function getBlogEntryByID($id)
{
	try {
		
		$id = filter_var($id, FILTER_SANITIZE_STRING);
		$connection = new Connection();
		$db = $connection->getConnection();
		$sqlExecSP = "call getBlogEntryByID(
            \"" . $id . "\")";
		$stmt = $db->prepare($sqlExecSP);
		$stmt->execute();
		$blog = null;
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$blog = new blogentry();
			$blog->id = $row["id"];
			$blog->userName = $row["username"];
			$blog->title = $row["title"];
			$blog->createdDate = $row["createdDate"];
			$blog->content = $row["content"];
			$blog->image = $row["image"];
			$blog->video = $row["video"];
			
		}
		$connection = null;
		$stmt = NULL;
		$db = NULL;
		return $blog;
	} catch (Exception $e) {
		echo $e;
	} finally {
		$connection = null;
		$stmt = NULL;
		$db = NULL;
	}
	return null;
	
}