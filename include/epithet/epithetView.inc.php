<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";

function hiddenNameField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function nameField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_name_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {	
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}

/*
function nameSelection(string $query_data, string $query_name) {
	echo "<select class='form' name='" . $query_name . "'>";
	echo "<option value='-1'> Select Name </option>";

	try {
		require "dbh.inc.php";
		//$results = getAllNameSelection($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data . "_query_data"][$query_name] == $result["id"]) {
					if (empty($result["name"])) {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> UNKNOWN - " . htmlspecialchars($result["note"]) . " </option>";	
					}
					else {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> " . htmlspecialchars($result["name"]) . " </option>";	
					}
				}			
				else {
					if (empty($result["name"])) {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> UNKNOWN - " . htmlspecialchars($result["note"]) . " </option>";	
					}
					else {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> " . htmlspecialchars($result["name"]) . " </option>";	
					}
				}
			}
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}

	echo "</select>";
}
 */

function checkEpithetErrors(string $name) {
	if (isset($_SESSION[$name . "_epithet_errors"])) {
		$errors = $_SESSION[$name . "_epithet_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_epithet_errors"]);
	}
}

