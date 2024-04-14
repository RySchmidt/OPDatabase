<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {	

	$chapter_number = $_POST["chapter_number"];
	$chapter_title = $_POST["chapter_title"];
	$publish_date = $_POST["chapter_publish_date"];

	$volume_number = $_POST["volume_number"];
	$story_arc_id = $_POST["story_arc_id"];

	try {

		require_once "dbh.inc.php";
		require_once "query/chapterModel.inc.php";
		require_once "query/chapterContr.inc.php";

		// ERROR 

		$errors = [];

		if (isInputEmpty($chapter_number, $chapter_title, $publish_date)) {
			$errors["empty_input"] = "Fill in required fields (Chapter Number, Chapter Title and Publish Date).";	
		}
		if (!isChapterNumberUnique($pdo, $chapter_number)) {
			$errors["invalid_chapter_number"] = "Chapter number (" . $chapter_number . ") already exists within the database.";
		}
		if (!isChapterTitleUnique($pdo, $chapter_title)) {
			$errors["invalid_chapter_title"] = "Chapter title (" . $chapter_title . ") already exists within the database.";
		}
		
		require_once "configSession.inc.php";

		if ($errors) {
			$_SESSION["errors_insert_chapter"] = $errors;
			header("Location: /OPDatabase/pages/chapter.php");
		}

	} catch (PDOException $e) {
		echo "<p> YOU SHOULD NOT BE HERE </p> <br>
		die("MySQL query failed: " . $e->getMessage() . "<br>");
	}
}

else {
	header("Location: /OPDatabase/pages/chapter.php");
	die();
}

/*

		try {

			$insert_query = "INSERT 
				INTO _info_cache (release_date) 
				VALUES (:release_date);";

			$insert_stmt = $pdo->prepare($insert_query);
			$insert_stmt->bindParam(":release_date", $publish_date);

			$insert_stmt->execute();

			$info_cache_id = $pdo->lastInsertId("id");

			$insert_query = NULL;
			$insert_stmt = NULL;

			$insert_query = "INSERT 
				INTO _chapter (number, title, _info_cache_id, _volume_number, _story_arc_id) 
				VALUES (:chapter_number, :chapter_title, :info_cache_id, :volume_number, :story_arc_id);";

			$insert_stmt = $pdo->prepare($insert_query);
			$insert_stmt->bindParam(":chapter_number", $chapter_number);
			$insert_stmt->bindParam(":chapter_title", $chapter_title);
			$insert_stmt->bindParam(":info_cache_id", $info_cache_id);
			$insert_stmt->bindParam(":volume_number", $volume_number);
			$insert_stmt->bindParam(":story_arc_id", $story_arc_id);

			$insert_stmt->execute();

			$insert_query = NULL;
			$insert_stmt = NULL;

			$pdo = null;

			header("Location: /OPDatabase/pages/chapter.php");

			die();

		} catch (PDOException $e) {
			echo "You should not be here!<br>";
			die("MySQL query failed: " . $e->getMessage() . "<br>");
		}

	} catch (PDOException $e) {

		die("MySQL query failed: " . $e->getMessage() . "<br>");
	} catch (Exception $e) {

		die("Insert query will fail.<br>" . $e->getMessage());
	}
}

 */
