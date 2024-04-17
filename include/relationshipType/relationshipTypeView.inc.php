<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "relationshipType/relationshipTypeContr.inc.php";

function hiddenRelationshipTypeField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function relationshipTypeField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_relationship_type_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {	
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}

function relationshipTypeSelection(string $query_data, string $query_name) {
	echo "<select class='form' name='" . $query_name . "'>";
	echo "<option value='-1'> Select Relationship Type </option>";

	try {
		require "dbh.inc.php";
		$results = getAdvancedRelationshipType($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data . "_query_data"][$query_name] == $result["relationship_type_id"]) {
					echo "<option value='" . htmlspecialchars((string)$result["relationship_type_id"]) . "'selected>" . htmlspecialchars($result["relationship_type_name"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["relationship_type_id"]) . "'> " . htmlspecialchars($result["relationship_type_name"]) . " </option>";
				}
			}
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}

	echo "</select>";
}

function relationshipTypeInputDisplay() {
	echo "<link rel='stylesheet' href='/OPDatabase/css/displayTable.css'>";
	echo "<h2> Relationship Type </h2> <br>";
	echo "<script src='/OPDatabase/javaScript/sortTable.js'></script>";

	try {
		require "dbh.inc.php";

		$results = getAdvancedRelationshipType($pdo);

		if (empty($results)) {
			echo "<div>";
			echo "<p> No chapters found in database. </p>";
			echo "</div>";
		}
		else {

			echo "<table class='display' id='chapterTable'>";

			echo "<thead>";
			echo "<tr>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 0, true)\"> Relationship Type Name </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 1, true)\"> Inverse Relationship Type Name </th>";
			echo "</tr>";
			echo "</thead>";

			echo "<tbody>";

			foreach ($results as $result) { 
				echo "<tr>"; 
				echo "<td class='display'>" . htmlspecialchars((string)$result["relationship_type_name"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["inverse_relationship_name"]) . "</td>";
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


function checkRelationshipTypeErrors(string $name) {
	if (isset($_SESSION[$name . "_relationship_type_errors"])) {
		$errors = $_SESSION[$name . "_relationship_type_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_relationship_type_errors"]);
	}
}

