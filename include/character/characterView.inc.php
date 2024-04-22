<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "character/characterContr.inc.php";
require_once "infoCache/infoCacheView.inc.php";
require_once "occupation/occupationView.inc.php";
require_once "occupationType/occupationTypeView.inc.php";
require_once "relationshipType/relationshipTypeView.inc.php";
require_once "organization/organizationView.inc.php";
require_once "name/nameContr.inc.php";
require_once "name/nameView.inc.php";
require_once "epithet/epithetContr.inc.php";
require_once "epithet/epithetView.inc.php";
require_once "relationship/relationshipContr.inc.php";
require_once "occupation/occupationContr.inc.php";
require_once "relationship/relationshipView.inc.php";


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
		echo "<form action='/OPDatabase/include/formAction/insertCharacterRelationship.inc.php' method='POST'>";

		hiddenCharacterField("insert", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id_b'> Select Character: </label> </td>";
		echo "<td class='form'>";

		characterSelection("insert", "character_id_b");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_relationship'> Relationship Type: </label> </td>";
		echo "<td class='form'>";

		relationshipTypeSelection("insert", "character_relationship");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_reveal'> Relationship Revealed: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('insert', 'info_cache_reveal', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_invalid'> Relationship Broken: </label> </td>";
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
	default:
	}
}

function informationModifyDisplay(string $query_data) {
	switch ($_SESSION[$query_data . "_query_data"]["info_type"]) {
		//Name
	case 1:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/populateCharacterModifyNameForm.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_id", "character_id");
		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_name'> Select Name: </label> </td>";
		echo "<td class='form'>";

		nameSelection("modify", "character_name", "character_id");

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
		echo "<form action='/OPDatabase/include/formAction/populateCharacterModifyEpithetForm.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_id", "character_id");
		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_epithet'> Select Epithet: </label> </td>";
		echo "<td class='form'>";

		epithetSelection("modify", "character_epithet", "character_id");

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
		echo "<form action='/OPDatabase/include/formAction/populateCharacterModifyOccupationForm.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_id", "character_id");
		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_occupation'> Select Occupation: </label> </td>";
		echo "<td class='form'>";

		occupationSelection("modify", "character_occupation", "character_id");

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
		echo "<form action='/OPDatabase/include/formAction/populateCharacterModifyRelationshipForm.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_id", "character_id");
		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_relationship'> Select Relationship: </label> </td>";
		echo "<td class='form'>";

		relationshipSelection("modify", "character_relationship");

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

function informationModify(string $query_data) {
	switch ($_SESSION[$query_data . "_query_data"]["info_type"]) {
		//Name
	case 1:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/modifyCharacterName.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_name", "original_name");
		hiddenCharacterField("modify", "info_cache_reveal", "original_info_cache");
		hiddenCharacterField("modify", "character_id", "character_id");

		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_name'> Character Name: </label> </td>";
		echo "<td class='form'>";

		characterField($query_data, "character_name", "text", $query_data, "invalid_character_name");

		echo "</td>";
		echo "</tr>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_reveal'> Introduced In: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('modify', 'info_cache_reveal', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form' colspan='2'>"; 
		echo "<input type='reset' value='Reset'>";
		echo "<input type='submit' value='Submit'>";
		echo "</td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Epithet
	case 2:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/modifyCharacterEpithet.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_epithet", "original_epithet");
		hiddenCharacterField("modify", "info_cache_reveal", "original_info_cache");
		hiddenCharacterField("modify", "character_id", "character_id");

		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_epithet'> Character Epithet: </label> </td>";
		echo "<td class='form'>";

		characterField($query_data, "character_epithet", "text", $query_data, "character_epithet");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_reveal'> Introduced In: </label> </td>";

		echo "<td class='form'>";

		infoCacheLimitedSelection('modify', 'info_cache_reveal', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form' colspan='2'>"; 
		echo "<input type='reset' value='Reset'>";
		echo "<input type='submit' value='Submit'>";
		echo "</td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Occupation
	case 3:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/modifyCharacterOccupation.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_occupation", "original_occupation");
		hiddenCharacterField("modify", "character_organization", "original_organization");
		hiddenCharacterField("modify", "info_cache_reveal", "original_info_cache");
		hiddenCharacterField("modify", "info_cache_invalid", "original_info_cache_invalid");
		hiddenCharacterField("modify", "character_id", "character_id");

		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";
		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_occupation'> Character Occupation: </label> </td>";
		echo "<td class='form'>";

		occupationTypeSelection("modify", "character_occupation");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_organization'> Organization: </label> </td>";
		echo "<td class='form'>";

		organizationSelection("modify", "character_organization", "character_organization");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_reveal'> Membership Revealed: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('modify', 'info_cache_reveal', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_invalid'> Membership Revoked: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('modify', 'info_cache_invalid', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form' colspan='2'>"; 
		echo "<input type='reset' value='Reset'>";
		echo "<input type='submit' value='Submit'>";
		echo "</td>";
		echo "</tr>";

		echo "</form>";
		echo "</tbody>";
		echo "</table>";

		break;

		//Relationship
	case 4:

		echo "<table class='form'>";
		echo "<form action='/OPDatabase/include/formAction/modifyCharacterRelationship.inc.php' method='POST'>";

		hiddenCharacterField("modify", "character_id_b", "original_character_id_b");
		hiddenCharacterField("modify", "character_relationship", "original_relationship");
		hiddenCharacterField("modify", "info_cache_reveal", "original_info_cache");
		hiddenCharacterField("modify", "character_id", "character_id");
		hiddenCharacterField("modify", "info_cache_invalid", "original_info_cache_invalid");

		hiddenCharacterField("modify", "info_cache_id_reveal", "info_cache_id_reveal");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id_b'> Select Character: </label> </td>";
		echo "<td class='form'>";

		characterSelection("modify", "character_id_b");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_relationship'> Relationship Type: </label> </td>";
		echo "<td class='form'>";

		relationshipTypeSelection("modify", "character_relationship");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_reveal'> Relationship Revealed: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('modify', 'info_cache_reveal', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='info_cache_invalid'> Relationship Broken: </label> </td>";
		echo "<td class='form'>";

		infoCacheLimitedSelection('modify', 'info_cache_invalid', "min_info_cache_id");

		echo "</td>";
		echo "</tr>";

		echo "<tr class='form'>";
		echo "<td class='form' colspan='2'>"; 
		echo "<input type='reset' value='Reset'>";
		echo "<input type='submit' value='Submit'>";
		echo "</td>";
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
		echo "<form action='/OPDatabase/include/formAction/deleteCharacterName.inc.php' method='POST'>";

		hiddenCharacterField("delete", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_id'> Select Name: </label> </td>";
		echo "<td class='form'>";

		nameSelection("delete", "character_name", "character_id");

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
		echo "<form action='/OPDatabase/include/formAction/deleteCharacterEpithet.inc.php' method='POST'>";

		hiddenCharacterField("delete", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_epithet'> Select Epithet: </label> </td>";
		echo "<td class='form'>";

		epithetSelection("delete", "character_epithet", "character_id");

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
		echo "<form action='/OPDatabase/include/formAction/deleteCharacterOccupation.inc.php' method='POST'>";

		hiddenCharacterField("delete", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_occupation'> Select Occupation: </label> </td>";
		echo "<td class='form'>";

		occupationSelection("delete", "character_occupation", "character_id");

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
		echo "<form action='/OPDatabase/include/formAction/deleteCharacterRelationship.inc.php' method='POST'>";

		hiddenCharacterField("delete", "character_id", "character_id");

		echo "<tbody>";

		echo "<tr class='form'>";
		echo "<td class='form'> <label name='character_relationship'> Select Relationship: </label> </td>";
		echo "<td class='form'>";

		relationshipSelection("delete", "character_relationship");

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

function characterInputDisplay() {

	echo "<link rel='stylesheet' href='/OPDatabase/css/displayTable.css'>";
	echo "<h2> Characters </h2> <br>";
	echo "<script src='/OPDatabase/javaScript/sortTable.js'></script>";

	try {
		require "dbh.inc.php";

		$results = getCharacterSelection($pdo);

		if (empty($results)) {
			echo "<div>";
			echo "<p> No characters found in database. </p>";
			echo "</div>";
		}
		else {

			echo "<table class='display' id='characterTable'>";

			echo "<thead>";
			echo "<tr>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 0, true)\"> Most Recent Character Name </th>";
			echo "<th class='display'> Other Character Name </th>";
			echo "<th class='display' onclick=\"sortTable('characterTable', 2, true)\"> Most Recent Character Epithet </th>";
			echo "<th class='display'> Other Character Epithets </th>";
			echo "<th class='display'> Relationships </th>";
			echo "<th class='display'> Occupations </th>";

			echo "</tr>";
			echo "</thead>";

			echo "<tbody>";

			foreach ($results as $result) { 

				echo "<tr>";
				//Names

				$character_names = getNameDisplayFromCharacterId($pdo, $result["id"]);
				$first = true;

				if (empty($character_names)) {
					echo "<td class='display'> UNKNOWN </td>";
					echo "<td class='display'> </td>";
				}
				else {
					echo "<td class='display'>";
					foreach ($character_names as $name) {
						if ($first) {
							$first = false;	
							echo htmlspecialchars((string)$name["name"]) . "</td>";
							echo "<td class='display'>";
						}
						else {
							echo htmlspecialchars((string)$name["name"]) . "<br>";
						}
					}
					echo "</td>";
				}

				//Epithets

				$character_epithet = getEpithetDisplayFromCharacterId($pdo, $result["id"]);
				$first = true;

				if (empty($character_epithet)) {
					echo "<td class='display'> UNKNOWN </td>";
					echo "<td class='display'> </td>";
				}
				else {
					echo "<td class='display'>";
					foreach ($character_epithet as $epithet) {
						if ($first) {
							$first = false;	
							echo htmlspecialchars((string)$epithet["epithet"]) . "</td>";
							echo "<td class='display'>";
						}
						else {
							echo htmlspecialchars((string)$epithet["epithet"]) . "<br>";
						}
					}
					echo "</td>";
				}

				//Relationships

				$character_relationships = getRelationshipDisplayFromCharacterId($pdo, $result["id"]);

				echo "<td class='display'>";
				if (!empty($character_relationships)) {
					foreach ($character_relationships as $relationship) {
						echo htmlspecialchars((string)$relationship["character_name_b"]) . "'s " . htmlspecialchars((string)$relationship["relationship_name"]) . "<br>";
					}
				}
				echo "</td>";

				//Occupations

				$character_occupations = getOccupationDisplayFromCharacterId($pdo, $result["id"]);

				echo "<td class='display'>";
				if (!empty($character_occupations)) {
					foreach ($character_occupations as $occupation) {
						echo htmlspecialchars((string)$occupation["organization_name"]) . " " . htmlspecialchars((string)$occupation["occupation_name"]) . "<br>";
					}
				}
				echo "</td>";

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

function checkCharacterErrors(string $name) {
	if (isset($_SESSION[$name . "_character_errors"])) {
		$errors = $_SESSION[$name . "_character_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_character_errors"]);
	}
}

