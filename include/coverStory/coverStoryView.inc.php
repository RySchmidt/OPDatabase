<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "storyArc/storyArcContr.inc.php";

function hiddenCoverStoryTitle (string $id) {
	if (isset($_SESSION[$id . "_query_data"]["cover_story_title"])) {
		echo "<input type='hidden' name='original_cover_story_title' value='" . $_SESSION[$id . "_query_data"]["cover_story_title"] . "'>";
	}
	else {
		echo "<input type='hidden' name='originial_cover_story_title' value='-1'>";
	}
}

function coverStoryTitleField() {
	if (isset($_SESSION[$id . "_query_data"]["cover_story_title"]) && !isset($_SESSION[$id . "_cover_story_errors"]["invalid_cover_story_title"])) {
		echo "<input type='text' name='cover_story_title' value='" . $_SESSION[$id . "_query_data"]["cover_story_title"] . "'>";
	}
	else {
		echo "<input type='text' name='cover_story_title'>";
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

function checkCoverStoryErrors() {
	if (isset($_SESSION["cover_story_errors"])) {
		$errors = $_SESSION["cover_story_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION["cover_story_errors"]);
	}

	if (isset($_SESSION["modify_A_cover_story_errors"])) {
		$errors = $_SESSION["modify_A_cover_story_errors"];

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION["modify_A_cover_story_errors"]);
	}
}

