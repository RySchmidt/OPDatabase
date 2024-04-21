<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "occupation/occupationContr.inc.php";

function hiddenOccupationField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function occupationField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_occupation_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {	
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}


function occupationSelection(string $query_data, string $query_name, string $character_name) {
	echo "<select class='form' name='" . $query_name . "'>";
	echo "<option value='-1'> Select occupation </option>";

	try {
		require "dbh.inc.php";
		$results = getAdvancedOccupationFromCharacterId($pdo, intval($_SESSION[$query_data . "_query_data"][$character_name]));

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data . "_query_data"][$query_name] == $result["occupation"]) {	
					echo "<option value='info_cache_reveal=" . htmlspecialchars((string)$result["_info_cache_reveal"]) . "&occupation=" . htmlspecialchars((string)$result["_occupation_type_id"]) . "&organization=" . htmlspecialchars((string)$result["_organization_id"]) . "' selected> " . htmlspecialchars($result["organization_name"]) . " " . htmlspecialchars($result["occupation_name"]) . " </option>";	
				}			
				else {
					echo "<option value='info_cache_reveal=" . htmlspecialchars((string)$result["_info_cache_reveal"]) . "&occupation=" . htmlspecialchars((string)$result["_occupation_type_id"]) . "&organization=" . htmlspecialchars((string)$result["_organization_id"]) . "'> " . htmlspecialchars($result["organization_name"]) . " " . htmlspecialchars($result["occupation_name"]) . " </option>";	
				}
			}
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}

	echo "</select>";
}

function checkOccupationErrors(string $name) {
	if (isset($_SESSION[$name . "_occupation_errors"])) {
		$errors = $_SESSION[$name . "_occupation_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_occupation_errors"]);
	}
}

