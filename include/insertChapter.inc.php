<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {	

	$chapter_number = $_POST["chapter_number"];
	//UNIQUE
	//NOT NULL

	$chapter_title = $_POST["chapter_title"];
	//UNIQUE
	//NOT NULL

	$cover_story_id = $_POST["cover_story_id"];
	//UNIQUE

	$publish_date = $_POST["chapter_publish_date"];
	//NOT NULL

	//NO CONSTRAINTS
	$volume_number = $_POST["volume_number"];
	$story_arc_id = $_POST["story_arc_id"];

	try {

		require_once "dbh.inc.php";

		//-------------------------------------------------------------------------------------------------
		//DATA VALIDATION

		$throw_exception = false;
		$exception_message = "";

		//Primary Key Check
		//Does not need to be checked because info cache will always make a new id.

		//Unique Check
		$select_query = "SELECT *
			FROM _chapter
			WHERE number = :chapter_number OR title = :chapter_title OR _cover_story_id = :cover_story_id;";

		$select_stmt = $pdo->prepare($select_query);
		$select_stmt->bindParam(":chapter_number", $chapter_number);
		$select_stmt->bindParam(":chapter_title", $chapter_title);
		$select_stmt->bindParam(":cover_story_id", $cover_story_id);

		$select_stmt->execute();
		$select_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

		if (!empty($select_results)) {
			$throw_exception = true;
			for ($i = 0; $i < sizeof($select_results); $i++) {
				if ($chapter_number != NULL && $select_results[$i]["number"] == $chapter_number) {
					$exception_message = $exception_message . "chapter.number " . $chapter_number . " already exists in the database and must be unique.<br>";
				}
				if ($chapter_title != NULL && $select_results[$i]["title"] == $chapter_title) {
					$exception_message = $exception_message . "chapter.title " . $chapter_title . " already exists in the database and must be unique.<br>";
				}
				if ($cover_story_id != NULL && $select_results[$i]["_cover_story_id"] == $cover_story_id) {
					$exception_message = $exception_message . "chapter._cover_story_id " . $cover_story_id . " already exists in the database and must be unique.<br>";
				}
			}
		}

		$select_query = NULL;
		$select_stmt = NULL;
		$select_results = NULL;

		//Not Null Check
		if ($chapter_number == NULL) {
			$throw_exception = true;
			$exception_message = $exception_message . "chapter.number cannot be NULL.<br>";
		}

		if ($chapter_title == NULL) {
			$throw_exception = true;
			$exception_message = $exception_message . "chapter.title cannot be NULL.<br>";
		}

		if ($publish_date == NULL) {
			$throw_exception = true;
			$exception_message = $exception_message . "info_cache.release_date cannot be NULL.<br>";
		}

		if ($throw_exception) {
			throw new Exception($exception_message);
		}

		//-------------------------------------------------------------------------------------------------

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
				INTO _chapter (number, title, _info_cache_id, _cover_story_id, _volume_number, _story_arc_id) 
				VALUES (:chapter_number, :chapter_title, :info_cache_id, :cover_story_id, :volume_number, :story_arc_id);";

			$insert_stmt = $pdo->prepare($insert_query);
			$insert_stmt->bindParam(":chapter_number", $chapter_number);
			$insert_stmt->bindParam(":chapter_title", $chapter_title);
			$insert_stmt->bindParam(":info_cache_id", $info_cache_id);
			$insert_stmt->bindParam(":cover_story_id", $cover_story_id);
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

else {
	header("Location: /OPDatabase/pages/chapter.php");
}
