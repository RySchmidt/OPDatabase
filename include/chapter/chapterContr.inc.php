<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "chapter/chapterModel.inc.php";
require_once "coverStory/coverStoryContr.inc.php";

function addChapter(object $pdo, int $chapter_number, string $chapter_title, string $chapter_publish_date, int $volume_number, int $story_arc_id) {
	insertChapter($pdo, $chapter_number, $chapter_title, $chapter_publish_date, $volume_number, $story_arc_id);
}

function modifyChapter(object $pdo, int $original_chapter_number, int $chapter_number, string $chapter_title, string $chapter_publish_date, int $chapter_volume_number, int $chapter_story_arc_id) {
	$result = getChapterFromNumber($pdo, $original_chapter_number);
	$chapter_info_cache_id = $result["_chapter_info_cache_id"];

	updateChapter($pdo, $chapter_info_cache_id, $chapter_number, $chapter_title, $chapter_publish_date, $chapter_volume_number, $chapter_story_arc_id);
}

function removeChapter(object $pdo, int $chapter_number) {		
	removeCoverStory($pdo, $chapter_number);	
	deleteChapter($pdo, $chapter_number);
}

function isChapterNumberUnique(object $pdo, int $chapter_number) {
	if (selectChapterFromNumber($pdo, $chapter_number)) {
		return false;
	}
	return true;
}	

function getChapterFromNumber(object $pdo, int $chapter_number) {
	return selectChapterFromNumber($pdo, $chapter_number);
}

function isChapterTitleUnique(object $pdo, string $chapter_title) {
	if (selectChapterFromTitle($pdo, $chapter_title)) {
		return false;
	}
	return true;
}	

function getChapterFromInfoCacheId(object $pdo, int $chapter_info_cache_id) {
	return selectChapterFromInfoCacheId($pdo, $chapter_info_cach_id);
}

function viewInfoCacheChapter(object $pdo) {
	updateInfoCacheChapter($pdo);
}

function getAllInfoCacheChapters(object $pdo) {
	return selectAllInfoCacheChapters($pdo);
}

function getAllChaptersCoverStories(object $pdo) {
	return selectAllInfoCacheChaptersCoverStories($pdo);
}
