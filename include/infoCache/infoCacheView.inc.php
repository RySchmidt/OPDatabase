<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "infoCache/infoCacheContr.inc.php";

function hiddenInfoCacheField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function infoCacheSelection(string $query_data, string $query_name) {
	echo "<select class='form' name='". $query_name . "'>";
	echo "<option value='-1'> No Info Cache </option>";

	try {
		require "dbh.inc.php";
		$results = getAllInfoCacheSelection($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data. "_query_data"][$query_name] == $result["id"]) {
					echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> " . htmlspecialchars((string)$result["selection_title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["id"]) . "'> " . htmlspecialchars((string)$result["selection_title"]) . " </option>";	
				}
			}

		}
	} catch (PDOException $e) {

		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
	echo "</select>";
}


function infoCacheLimitedSelection(string $query_data, string $query_name, string $min_name = "", string $max_name = "") {
	echo "<select class='form' name='". $query_name . "'>";
	echo "<option value='-1'> No Info Cache </option>";

	try {
		require "dbh.inc.php";

		$results = getRestrictedInfoCacheSelection($pdo, intval($_SESSION[$query_data . "_query_data"][$min_name]), intval($_SESSION[$query_data . "_query_data"][$max_name]));

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data. "_query_data"][$query_name] == $result["id"]) {
					echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> " . htmlspecialchars((string)$result["selection_title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["id"]) . "'> " . htmlspecialchars((string)$result["selection_title"]) . " </option>";	
				}
			}

		}
	} catch (PDOException $e) {

		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
	echo "</select>";
}
