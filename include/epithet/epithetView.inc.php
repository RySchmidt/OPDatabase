<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";

function hiddenEpithetField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function epithetField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_name_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {	
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}


function epithetSelection(string $query_data, string $query_name, string $character_name) {
	echo "<select class='form' name='" . $query_name . "'>";
	echo "<option value='-1'> Select Epithet </option>";

	try {
		require "dbh.inc.php";
		$results = getEpithetFromCharacterId($pdo, intval($_SESSION[$query_data . "_query_data"][$character_name]));

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data . "_query_data"][$query_name] == $result["epithet"]) {	
						echo "<option value='info_cache_reveal=" . htmlspecialchars((string)$result["_info_cache_reveal"]) . "&epithet=" . htmlspecialchars((string)$result["epithet"]) . "' selected> " . htmlspecialchars($result["epithet"]) . " </option>";	
				}			
				else {
						echo "<option value='info_cache_reveal=" . htmlspecialchars((string)$result["_info_cache_reveal"]) . "&epithet=" . htmlspecialchars((string)$result["epithet"]) . "'> " . htmlspecialchars($result["epithet"]) . " </option>";	
				}
			}
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}

	echo "</select>";
}

function checkEpithetErrors(string $name) {
	if (isset($_SESSION[$name . "_epithet_errors"])) {
		$errors = $_SESSION[$name . "_epithet_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_epithet_errors"]);
	}
}

