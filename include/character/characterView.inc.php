<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "character/characterContr.inc.php";
require_once "infoCache/infoCacheView.inc.php";
require_once "occupation/occupationView.inc.php";
require_once "occupationType/occupationTypeView.inc.php";
require_once "relationshipType/relationshipTypeView.inc.php";
require_once "organization/organizationView.inc.php";

function hiddenCharacterField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function characterField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_character_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {	
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}

function characterSelection(string $query_data, string $query_name) {
	echo "<select class='form' name='" . $query_name . "'>";
	echo "<option value='-1'> Select Character </option>";

	try {
		require "dbh.inc.php";
		$results = getCharacterSelection($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data . "_query_data"][$query_name] == $result["id"]) {
					if (empty($result["name"])) {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> UNKNOWN - " . htmlspecialchars($result["notes"]) . " </option>";	
					}
					else {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> " . htmlspecialchars($result["name"]) . " </option>";	
					}
				}			
				else {
					if (empty($result["name"])) {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' > UNKNOWN - " . htmlspecialchars($result["notes"]) . " </option>";	
					}
					else {
						echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' > " . htmlspecialchars($result["name"]) . " </option>";	
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

function informationTypeDisplay(string $query_data) {
	switch ($_SESSION[$query_data . "_query_data"]["info_type"]) {
		//Name
	case 1:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/insertCharacterName.inc.php' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_name'> Character Name: </label> </td>";
		echo "<td class='form'>";

		characterField($query_data, "character_name", "text", $query_data, "invalid_character_name");

		echo "</td>";
		echo "</tr>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_id'> Introduced In: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('insert', 'info_cache_id', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Epithet
	case 2:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/insertCharacterEpithet.inc.php' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_epithet'> Character Epithet: </label> </td>";
		echo "<td class='form'>";

		characterField($query_data, "character_epithet", "text", $query_data, "character_epithet");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_id'> Introduced In: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('insert', 'info_cache_id', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Occupation
	case 3:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/insertCharacterOccupation.inc.php' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_occupation'> Character Occupation: </label> </td>";
		echo "<td class='form'>";

		occupationTypeSelection("insert", "character_occupation");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_organization'> Organization: </label> </td>";
		echo "<td class='form'>";

		organizationSelection("insert", "character_organization", "character_organization");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_reveal'> Membership Revealed: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('insert', 'info_cache_reveal', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_invalid'> Membership Revoked: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('insert', 'info_cache_invalid', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Relationship
	case 4:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Character: </label> </td>";
		echo "<td class='form'>";

		characterSelection("insert", "character_id_A");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='relationship_type'> Relationship Type: </label> </td>";
		echo "<td class='form'>";

		relationshipTypeSelection("insert", "relationship_type");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_reveal'> Relationship Revealed: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('insert', 'info_cache_id', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_invalid'> Relationship Broken: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('insert', 'info_cache_id', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;
	default:
	}
}

function informationModifyDisplay(string $query_data) {
	switch ($_SESSION[$query_data . "_query_data"]["info_type"]) {
		//Name
	case 1:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Name: </label> </td>";
		echo "<td class='form'>";

		//nameSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Epithet
	case 2:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Epithet: </label> </td>";
		echo "<td class='form'>";

		//epithetSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Occupation
	case 3:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Occupation: </label> </td>";
		echo "<td class='form'>";

		//occupationSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";
		echo "<tr class='form'>";

		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Relationship
	case 4:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Relationship: </label> </td>";
		echo "<td class='form'>";

		//relationshipSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;
	default:
	}
}

function informationDeleteDisplay(string $query_data) {
	switch ($_SESSION[$query_data . "_query_data"]["info_type"]) {
		//Name
	case 1:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Name: </label> </td>";
		echo "<td class='form'>";

		//nameSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Epithet
	case 2:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Epithet: </label> </td>";
		echo "<td class='form'>";

		//epithetSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Occupation
	case 3:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Occupation: </label> </td>";
		echo "<td class='form'>";

		//occupationSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";
		echo "<tr class='form'>";

		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Relationship
	case 4:

		echo "<table class='form'>";
		echo "<form action='' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Relationship: </label> </td>";
		echo "<td class='form'>";

		//relationshipSelection("modify", "character_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <input type='submit' value='Submit'> </td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;
	default:
	}
}

/*
function characterInputDisplay() {

	echo "<link rel='stylesheet' href='/OPDatabase/css/displayTable.css'>";
	echo "<h2> Characters </h2> <br>";
	echo "<script src='/OPDatabase/javaScript/sortTable.js'></script>";

	try {
		require "dbh.inc.php";

		$results = getCharacterInputDisplay($pdo);

		if (empty($results)) {
			echo "<div>";
			echo "<p> No characters found in database. </p>";
			echo "</div>";
		}
		else {

			echo "<table class='display' id='characterTable'>";

			echo "<thead>";
			echo "<tr>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 0, true)\"> Volume <br> Number </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 1, true)\"> Character <br> Number </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 2, false)\"> Title </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 3, false)\"> Main Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 4, false)\"> Sub Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 5, false)\"> Cover Story Title </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 6, false)\"> Cover Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 7, false)\"> Publish Date </th>";
			echo "</tr>";
			echo "</thead>";

			echo "<tbody>";

			foreach ($results as $result) { 
				echo "<tr>"; 
				echo "<td class='display'>" . htmlspecialchars((string)$result["_volume_number"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["character_number"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["character_title"]) . "</td>";
				if (!empty($result["_parent_story_arc"])) {
					echo "<td class='display'>" . htmlspecialchars((string)$result["parent_arc_title"]) . "</td>";
					echo "<td class='display'>" . htmlspecialchars((string)$result["story_arc_title"]) . "</td>";
				}
				else {
					echo "<td class='display'>" . htmlspecialchars((string)$result["story_arc_title"]) . "</td>";
					echo "<td class='display'> </td>";
				}

				echo "<td class='display'>" . htmlspecialchars((string)$result["cover_story_title"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["_cover_story_arc_title"]) . "</td>";
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
 */

function checkCharacterErrors(string $name) {
	if (isset($_SESSION[$name . "_character_errors"])) {
		$errors = $_SESSION[$name . "_character_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_character_errors"]);
	}
}

