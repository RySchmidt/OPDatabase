<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "storyArc/storyArcContr.inc.php";

function hiddenCoverStoryField(string $query_data, string $query_name, string $name, string $default_value = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name])) {
		echo "<input type='hidden' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='hidden' name='". $name . "' value='" . $defualt_value . "'>";
	}
}

function coverStoryField(string $query_data, string $query_name, string $type, string $name, string $error_data = "", string $error = "") {
	if (isset($_SESSION[$query_data . "_query_data"][$query_name]) && !isset($_SESSION[$error_data . "_cover_story_errors"][$error])) {
		echo "<input type='" . $type . "' name='" . $name . "' value='" . $_SESSION[$query_data . "_query_data"][$query_name] . "'>";
	}
	else {
		echo "<input type='". $type . "' name='". $name . "'>";
	}
}

function coverStoryArcSelection(string $id) {
	echo "<select class='form' name='cover_story_arc_id'>";
	echo "<option value='-1'> No Story Arc </option>";

	try {
		require "dbh.inc.php";
		$results = getStoryArcs($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if (isset($_SESSION[$id . "_query_data"]["cover_story_arc_id"]) && $_SESSION[$id . "_query_data"]["cover_story_arc_id"] == $result["id"]) {
					echo "<option value='" . htmlspecialchars((string)$result["id"]) . "' selected> " . htmlspecialchars($result["title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["id"]) . "'> " . htmlspecialchars($result["title"]) . " </option>";
				}
			}
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}

	echo "</select>";
}

function coverStorySelection(string $id) {
	echo "<select class='form' name='chapter_number'>";
	echo "<option value=''> Select Cover Story </option>";

	try {
		require "dbh.inc.php";
		$results = getAllCoverStories($pdo);

		if(!empty($results)) {
			foreach ($results as $result) {
				if (isset($_SESSION[$id . "_query_data"]["chapter_number"]) && $_SESSION[$id . "_query_data"]["chapter_number"] == $result["number"]) {
					echo "<option value='" . htmlspecialchars((string)$result["_chapter_number"]) . "' selected> " . htmlspecialchars((string)$result["_chapter_number"]) . " - " . htmlspecialchars($result["title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars((string)$result["_chapter_number"]) . "'> " . htmlspecialchars((string)$result["_chapter_number"]) . " - " . htmlspecialchars($result["title"]) . " </option>";
				}
			}
		}

	} catch (PDOException $e) {
		echo "You should not be here!<br>";
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}

	echo "</select>";
}

function checkCoverStoryErrors(string $name) {
	if (isset($_SESSION[$name . "_cover_story_errors"])) {
		$errors = $_SESSION[$name . "_cover_story_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION[$name . "_cover_story_errors"]);
	}
}

