<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/InventoryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/LibraryInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/VillageInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/BlogInformation.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/vunnava/bin/adminFunctions.php';
$method = $_SERVER['REQUEST_METHOD'];

$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$input = json_decode(file_get_contents('php://input'), true);
// retrieve the table and key from the path
$table = preg_replace('/[^a-z0-9_]+/i', '', array_shift($request));
$key = array_shift($request) + 0;

switch ($table) {
    case('inventory_item'):
        $item = getInventoryByItemId($key);
        if ($item != null) {
            header('Content-Type: application/json; charset=utf-8');
            echo output($item);
            break;
        } else {
            http_response_code(404);
            die();
        }
    case('inventory_items'):
        if ($key != null) {
            if ($key > 0 && in_array($key, $libraryIDs)) {
                header('Content-Type: application/json; charset=utf-8');
                echo output(getInventoryByLibraryId($key,0,200000));
                break;
            }else if($key == 0)
			{
				header('Content-Type: application/json; charset=utf-8');
            	echo output(getFullInventory(0,200000));
            	break;
			}else {
                http_response_code(404);
                die();
            }
        } else if ($key == null) {
            header('Content-Type: application/json; charset=utf-8');
            echo output(getFullInventory(0,200000));
            break;
        }
        break;
    case('libraries'):
        header('Content-Type: application/json; charset=utf-8');
        echo output($libraries);
        break;
    case('library'):
        //echo in_array($key,$libraryIDs);
        if ($key < 0 || !in_array($key, $libraryIDs)) {
            http_response_code(404);
            die();
        } else {
            header('Content-Type: application/json; charset=utf-8');
            foreach($libraries as $lib) {
                if ($lib->id == $key)
                    echo output($lib);
            }
            break;
        }
    case('villages'):
        header('Content-Type: application/json; charset=utf-8');
        echo output($villages);
        break;
    case('borrows'):
		if($key == null)
		{
        	header('Content-Type: application/json; charset=utf-8');
        	echo output(getAllBorrows());
        	break;
		}
		else if($key > 0 && in_array($key, $libraryIDs)){
			header('Content-Type: application/json; charset=utf-8');
        	echo output(getBorrowsByLibraryID($key));
        	break;
		}
		else{
			http_response_code(404);
            die();
		}
	case('blogs'):
		if($key == null)
		{
        	header('Content-Type: application/json; charset=utf-8');
        	echo output(getBlogEntries(0,10000));
        	break;
		}
		else{
			http_response_code(404);
            die();
		}
		case('blog'):
		if($key == null)
		{
			http_response_code(404);
            die();
        	
		}
		else if($key > 0){
			header('Content-Type: application/json; charset=utf-8');
			$blog = getBlogEntryByID($key);
			if($blog != null){
				echo output(getBlogEntryByID($key));
				break;
			}else{
				http_response_code(404);
				die();
			}
		}
		else{
			http_response_code(404);
            die();
		}
	case('CostsPerLibrary'):
		$data = getTotalCostPerLibrary($libraryIDs);
		//print_r($data);
		if($data != null)
		{
			echo output($data);
			break;
		}
	case('PriceStats'):
		$data = getPriceStats($libraryIDs);
		//print_r($data);
		if($data != null)
		{
			echo output($data);
			break;
		}
	
	case('CountsByCreator'):
		$data = getCountsByCreator();
		//print_r($data);
		if($data != null)
		{
			echo output($data);
			break;
		}
	//CountsByAuthor
	case('CountsByAuthor'):
		$data = getCountsByAuthor();
		//print_r($data);
		if($data != null)
		{
			echo output($data);
			break;
		}
	//getBorrowsPerLibrary
	case('BorrowsPerLibrary'):
		$data = getBorrowsPerLibrary();
		//print_r($data);
		if($data != null)
		{
			echo output($data);
			break;
		}
    default :
        echo json_encode(array());
}
function output($item)
{
    return json_encode($item, JSON_UNESCAPED_UNICODE);
}
