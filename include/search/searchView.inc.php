<?php
declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "search/searchContr.inc.php";

function searchTable() {
	echo "<table class='form'>";
	echo "<form action='/OPDatabase/include/formAction/searchDatabase.inc.php' method='POST'>";

	echo "<thead>";
	echo "<tr> <th class='form' colspan='2'> <h2> Search </h2> <th> </tr>";
	echo "</thead>";

	echo "<tbody>";

	echo "<tr class='form'>";
	echo "<td class='form'> <label for='max_chapter_filter'> Chapter Number: </label> </td>";
	echo "<td class='form'> <input type='number' name='max_chapter_filter' min='1' value='" . $_SESSION["max_chapter_filter"] . "' required> </td>";
	echo "</tr>";

	echo "<tr class='form'>";
	echo "<td class='form'> <input type='submit' value='Search'> </td>";
	echo "</tr>";

	echo "</tbody>";

	echo "</form>";
	echo "</table>";
}

function displayCharacterSearch($search_results_name) {

	echo "<h1> Search Results </h1>";
	echo "<link rel='stylesheet' href='/OPDatabase/css/displayTable.css'>";

	$result_ids = $_SESSION[$search_results_name];
	$max_chapter = $_SESSION["max_chapter_filter"];

	if (!empty($result_ids)) { 

			echo "<table class='display' id='SearchTable'>";

			echo "<thead>";
			echo "<tr>";
			echo "<th class='display'> Character Name </th>";
			echo "<th class='display'> Also Known As... </th>";
			echo "<th class='display'> Epithets </th>";
			echo "<th class='display'> Occupations </th>";
			echo "<th class='display'> Relationships </th>";

			echo "</tr>";
			echo "</thead>";

			echo "<tbody>";

		try {
			require_once("dbh.inc.php");


			$result_ids = extractIds($result_ids);
			$result_ids = sortIdsByName($pdo, $max_chapter, $result_ids);

			foreach ($result_ids as $result) {	

				echo "<tr>";

				$names = getSortedCharacterNames($pdo, $result["id"], $max_chapter);

				$first = true;
				$other_names = false;

				if (!empty($names)) {
					foreach ($names as $name) {
						if ($first) {
							$first = false;
							echo "<td class='display'> <h3>" . htmlspecialchars((string)$name["name"]) . "</h3> </td>";
							echo "<td class='display'>";
						}
						else {	
							echo htmlspecialchars((string)$name["name"]) . "<br>";
						}
					}
					echo "</td>";
				}
				else {	
					echo "<td class='display'> <h3> UNKNOWN </h3> </td>";
					echo "<td class='display'> </td>";
				}

				$epithets = getSortedCharacterEpithets($pdo, $result["id"], $max_chapter);

				$first = true;
				if (!empty($epithets)){
					echo "<td class='display'>";
					foreach ($epithets as $epithet) {
						echo htmlspecialchars((string)$epithet["epithet"]) . "<br>";
					}
					echo "</td>";
				}
				else {
					echo "<td class='display'> </td>";
				}

				$occupations = getSortedCharacterCurrentOccupations($pdo, $result["id"], $max_chapter);

				echo "<td class='display'>";
				$first = true;
				if (!empty($occupations)){
					foreach ($occupations as $occupation) {
							echo htmlspecialchars((string)$occupation["organization_name"]) . " " . htmlspecialchars((string)$occupation["occupation_name"]) . "<br>";
					}
				}

				$occupations = getSortedCharacterPreviousOccupations($pdo, $result["id"], $max_chapter);

				if (!empty($occupations)){
					foreach ($occupations as $occupation) {
							echo "Former " . htmlspecialchars((string)$occupation["organization_name"]) . " " . htmlspecialchars((string)$occupation["occupation_name"]) . "<br>";
					}
				}	
					echo "</td>";

				$relationships = getSortedCharacterCurrentRelationships($pdo, $result["id"], $max_chapter);

				echo "<td class='display'>";
				if (!empty($relationships)){
					foreach ($relationships as $relationship) {	
							$names = getSortedCharacterNames($pdo, $relationship["_character_b"], $max_chapter);
							if (!empty($names)) {
								echo htmlspecialchars((string)$names[0]["name"]) . "'s " . htmlspecialchars((string)$relationship["name"]) . "<br>";
							}
							else {
								echo "UNKNOWN's " . htmlspecialchars((string)$relationship["name"]) . "<br>";
							}
					}
				}

				$relationships = getSortedCharacterPreviousRelationships($pdo, $result["id"], $max_chapter);

				if (!empty($relationships)){
					echo "Relationship: <br> ";
					foreach ($relationships as $relationship) {	
							$names = getSortedCharacterNames($pdo, $relationship["_character_b"], $max_chapter);
							if (!empty($names)) {
								echo htmlspecialchars((string)$names[0]["name"]) . "'s former" . htmlspecialchars((string)$relationship["name"]) . "<br>";
							}
							else {
								echo "UNKNOWN's former" . htmlspecialchars((string)$relationship["name"]) . "<br>";
							}
					}
				}

				echo "</td>";
			}

		} catch (PDOException $e) {
			echo "<p> YOU SHOULD NOT BE HERE! </p> <br>";
			die("MySQL query failed: " . $e->getMessage() . "<br>");
		}
	}
	else {
		echo "No Character found";
	}
}
