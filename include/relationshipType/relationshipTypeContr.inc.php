<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "chapter/chapterModel.inc.php";
require_once "coverStory/coverStoryContr.inc.php";

function addChapter(object $pdo, int $chapter_number, string $chapter_title, string $chapter_publish_date, int $volume_number, int $story_arc_id) {
	insertChapter($pdo, $chapter_number, $chapter_title, $chapter_publish_date, $volume_number, $story_arc_id);
}

function modifyChapter(object $pdo, int $chapter_info_cache_id, int $chapter_number, string $chapter_title, string $chapter_publish_date, int $chapter_volume_number, int $chapter_story_arc_id) {
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
	return selectChapterFromInfoCacheId($pdo, $chapter_info_cache_id);
}

function viewInfoCacheChapter(object $pdo) {
	updateInfoCacheChapter($pdo);
}

function getAllInfoCacheChapters(object $pdo) {
	return selectAllInfoCacheChapters($pdo);
}

function getChapterInputDisplay(object $pdo) {
	return selectChapterInputDisplay($pdo);
}

function modifyChapterVolumeNumber(object $pdo, int $volume_number, int $min_chapter_number, int $max_chapter_number) {
	clearChapterVolumeNumber($pdo, $volume_number);
	updateChapterVolumeNumber($pdo, $volume_number, $min_chapter_number, $max_chapter_number);	
}

function modifyChapterStoryArc(object $pdo, int $story_arc_id, int $parent_story_arc_id, int $min_chapter_number, int $max_chapter_number) {
	clearChapterStoryArc($pdo, $story_arc_id, $parent_story_arc_id);
	updateChapterStoryArc($pdo, $story_arc_id, $parent_story_arc_id, $min_chapter_number, $max_chapter_number);	
}
