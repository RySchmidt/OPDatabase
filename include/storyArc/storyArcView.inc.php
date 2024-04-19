<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "storyArc/storyArcContr.inc.php";

function hiddenStoryArcField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function storyArcField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {	
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}

function storyArcSelection(string $query_data, string $query_name) {

	echo "<select class='form' name='". $query_name ."'>";
	echo "<option value='-1'> No Story Arc </option>";

	try {
		require "dbh.inc.php";
		$results = getAllAdvancedStoryArc($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data . "_query_data"][$query_name] == $result["story_arc_id"]) {
					echo "<option value='" . htmlspecialchars((string)$result["story_arc_id"]) . "' selected> " . htmlspecialchars($result["story_arc_title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["story_arc_id"]) . "'> " . htmlspecialchars($result["story_arc_title"]) . " </option>";
				}
			}
		}
		else if ($multipleSelection) {

		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
	echo "</select>";
}

function storyArcsInputDisplay() {

	echo "<link rel='stylesheet' href='/OPDatabase/css/displayTable.css'>";
	echo "<h2> Story Arcs </h2> <br>";
	echo "<script src='/OPDatabase/javaScript/sortTable.js'></script>";

	try {
		require "dbh.inc.php";

		$results = getAllAdvancedStoryArc($pdo);

		if (empty($results)) {
			echo "<div>";
			echo "<p> No chapters found in database. </p>";
			echo "</div>";
		}
		else {

			echo "<table class='display' id='chapterTable'>";

			echo "<thead>";
			echo "<tr>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 0, false)\"> Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 1, false)\"> Parent Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 2, true)\"> Min Chapter </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 3, true)\"> Max Chapter Arc </th>";
			echo "</tr>";
			echo "</thead>";

			echo "<tbody>";

			foreach ($results as $result) { 
				echo "<tr>"; 
				echo "<td class='display'>" . htmlspecialchars((string)$result["story_arc_title"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["parent_arc_title"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["min_chapter"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["max_chapter"]) . "</td>";
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


function checkStoryArcErrors(string $name) {
	if (isset($_SESSION[$name . "_story_arc_errors"])) {
		$errors = $_SESSION[$name . "_story_arc_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_story_arc_errors"]);
	}
}

