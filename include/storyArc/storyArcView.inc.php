<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "storyArcContr.inc.php";

function storyArcSelection() {
	echo "<select name='story_arc_id'";
	echo "<option value='-1'> No Story Arc </option>";

	try {
		require "dbh.inc.php";
		$results = getStoryArcs($pdo);

		if(!empty($results)) {
			foreach ($resuls as $result) {
				if ($_SESSION["query_date"]["story_arc_id"] == $result["id"]) {
					echo "<option value='" . htmlspecialchars($result["id"]) . "' selected> " . htmlspecialchars($result["title"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars($result["id"]) . "'> " . htmlspecialchars($result["title"]) . " </option>";
				}
			}

		} catch (PDOException $e) {
			echo "You should not be here!<br>";
			die("MySQL query failed: " . $e->getMessage() . "<br>");
		}
	}
	echo "</select>";
}
