<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "volume/volumeCtrl.inc.php";

function volumeNumberSelection() {
	echo "<select name='volume_number'";
	echo "<option value='-1'> No Volume </option>";

	try {
		require "dbh.inc.php";
		$results = getVolumes();
		if(!empty($results)) {
			foreach ($resuls as $result) {
				if ($_SESSION["query_date"]["volume_number"] == $result["number"]) {
					echo "<option value='" . htmlspecialchars($result["number"]) . "' selected> " . htmlspecialchars($result["number"]) . " </option>";	
				}			
				else {
					echo "<option value='" . htmlspecialchars($result["number"]) . "'> " . htmlspecialchars($result["number"]) . " </option>";
				}
			}

		} catch (PDOException $e) {
			echo "You should not be here!<br>";
			die("MySQL query failed: " . $e->getMessage() . "<br>");
		}
	}
	echo "</select>";
}
