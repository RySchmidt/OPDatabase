<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "volume/volumeContr.inc.php";

function hiddenVolumeField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function volumeField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_volume_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}

function volumeSelection(string $query_data, string $query_name) {
	echo "<select class='form' name='". $query_name . "'>";
	echo "<option value='-1'> No Volume </option>";

	try {
		require "dbh.inc.php";
		$results = getAllVolumes($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data. "_query_data"][$query_name] == $result["number"]) {
					echo "TESTING";
					echo "<option value='" . htmlspecialchars((string)$result["number"]) . "' selected> " . htmlspecialchars((string)$result["number"]) . " - " . htmlspecialchars($result["title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["number"]) . "'> " . htmlspecialchars((string)$result["number"]) . " - " . htmlspecialchars($result["title"]) . " </option>";	
				}
			}

		}
	} catch (PDOException $e) {

		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
	echo "</select>";
}

function volumeInputDisplay() {

	echo "<link rel='stylesheet' href='/OPDatabase/css/displayTable.css'>";
	echo "<h2> Volumes </h2> <br>";
	echo "<script src='/OPDatabase/javaScript/sortTable.js'></script>";

	try {
		require "dbh.inc.php";

		$results = getVolumeInputDisplay($pdo);

		if (empty($results)) {
			echo "<div>";
			echo "<p> No volumes found in database. </p>";
			echo "</div>";
		}
		else {

			echo "<table class='display' id='volumeTable'>";

			echo "<thead>";
			echo "<tr>";
			echo "<th class='display' onclick=\"sortTable('volumeTable', 0, true)\"> Volume <br> Number </th>";
			echo "<th class='display' onclick=\"sortTable('volumeTable', 1, false)\"> Title </th>";
			echo "<th class='display' onclick=\"sortTable('volumeTable', 2, true)\"> SBS Number </th>";
			echo "<th class='display' onclick=\"sortTable('volumeTable', 3, true)\"> Min <br> Chapter Number </th>";
			echo "<th class='display' onclick=\"sortTable('volumeTable', 4, true)\"> Max <br> Chapter Number </th>";
			echo "<th class='display' onclick=\"sortTable('volumeTable', 5, false)\"> Publish Date </th>";
			echo "</tr>";
			echo "</thead>";

			echo "<tbody>";

			foreach ($results as $result) { 
				echo "<tr>"; 
				echo "<td class='display'>" . htmlspecialchars((string)$result["volume_number"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["volume_title"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["sbs_number"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["min_chapter"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["max_chapter"]) . "</td>";	
				echo "<td class='display'>" . htmlspecialchars((string)$result["publish_date"]) . "</td>";
				echo "</tr>";
			}
			echo "<tbody>";
			echo "</table>";
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
}

function checkVolumeErrors(string $name) {
	if (isset($_SESSION[$name . "_volume_errors"])) {
		$errors = $_SESSION[$name . "_volume_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_volume_errors"]);
	}
}

