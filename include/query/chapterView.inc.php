<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function checkInsertChapterErrors() {
	if (isset($_SESSION["errors_insert_chapter"])) {
		$errors = $_SESSION["errors_insert_chapter"];

		echo "<br>";

		foreach ($errors as $error) {
			echo "<p class='form-error'>" . $error . "</p>";
		}

		unset($_SESSION["errors_insert_chapter"]);
	}

}

