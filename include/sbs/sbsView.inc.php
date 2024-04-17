<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "volume/volumeContr.inc.php";

function sbsField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "sbs_error"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}

function sbsSelection(string $query_data, string $query_name) {
	echo "<select name='". $query_name . "'>";
	echo "<option value='-1'> No SBS </option>";

	try {
		require "dbh.inc.php";
		$results = getAllSBSs($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data. "_query_date"][$query_name] == $result["sbs_number"]) {
					echo "<option value='" . htmlspecialchars((string)$result["sbs_number"]) . "' selected> " . htmlspecialchars((string)$result["sbs_number"]) . " </option>";	}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["sbs_number"]) . "'> " . htmlspecialchars((string)$result["sbs_number"]) . " </option>";
				}
			}

		}
	} catch (PDOException $e) {

		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
	echo "</select>";
}

function checkSBSErrors(string $name) {
	if (isset($_SESSION[$name . "_sbs_errors"])) {
		$errors = $_SESSION[$name . "_sbs_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_sbs_errors"]);
	}
}





