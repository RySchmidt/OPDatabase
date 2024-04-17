<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "chapter/chapterContr.inc.php";
require_once "volume/volumeContr.inc.php";
require_once "storyArc/storyArcContr.inc.php";

function hiddenChapterField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function chapterField(string $query_data, string $query_name, string $type, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_chapter_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $query_name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {	
		echo "<input type='". $type . "' name='". $query_name . "' value='" . "'>";
	}
}

function chapterSelection(string $query_data, string $query_name) {
	echo "<select class='form' name='" . $query_name . "'>";
	echo "<option value='-1'> Select Chapter </option>";

	try {
		require "dbh.inc.php";
		$results = getAllInfoCacheChapters($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if ($_SESSION[$query_data . "_query_data"][$query_name] == $result["chapter_number"]) {
					echo "<option value='" . htmlspecialchars((string)$result["chapter_number"]) . "' selected> " . htmlspecialchars((string)$result["chapter_number"]) . " - " . htmlspecialchars($result["chapter_title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["chapter_number"]) . "'> " . htmlspecialchars((string)$result["chapter_number"]) . " - " . htmlspecialchars($result["chapter_title"]) . " </option>";
				}
			}
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}

	echo "</select>";
}

function chapterInputDisplay() {

	echo "<link rel='stylesheet' href='/OPDatabase/css/displayTable.css'>";
	echo "<h2> Chapters </h2> <br>";
	echo "<script src='/OPDatabase/javaScript/sortTable.js'></script>";

	try {
		require "dbh.inc.php";

		$results = getChapterInputDisplay($pdo);

		if (empty($results)) {
			echo "<div>";
			echo "<p> <No chapters found in database.> <p>";
			echo "<div>";
		}
		else {

			echo "<table class='display' id='chapterTable'>";

			echo "<thead>";
			echo "<tr>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 0, true)\"> Volume <br> Number </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 1, true)\"> Chapter <br> Number </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 2, false)\"> Title </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 3, false)\"> Main Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 4, false)\"> Sub Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 5, false)\"> Cover Story Title </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 6, false)\"> Cover Story Arc </th>";
			echo "<th class='display' onclick=\"sortTable('chapterTable', 7, false)\"> Publish Date </th>";
			echo "</tr>";
			echo "</thead>";

			echo "<tbody>";

			foreach ($results as $result) { 
				echo "<tr>"; 
				echo "<td class='display'>" . htmlspecialchars((string)$result["_volume_number"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["chapter_number"]) . "</td>";
				echo "<td class='display'>" . htmlspecialchars((string)$result["chapter_title"]) . "</td>";
				if (!empty($result["_parent_story_arc"])) {
					echo "<td class='display'>" . htmlspecialchars((string)$result["_parent_story_arc_title"]) . "</td>";
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

function checkChapterErrors(string $name) {
	if (isset($_SESSION[$name . "_chapter_errors"])) {
		$errors = $_SESSION[$name . "_chapter_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_chapter_errors"]);
	}
}

