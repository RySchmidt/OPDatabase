<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "chapter/chapterModel.inc.php";
require_once "coverStory/coverStoryContr.inc.php";

function isChapterInfoCacheIdEmpty(int $info_cache_id) {
	if ($info_cache_id <= 0) {
		return true;
	}
	return false;
}	

function chapterIsEmpty(int $chapter_number, string $chapter_title, string $publish_date) {
	if ($chapter_number <= 0) {
		return true;
	}
	if (empty($chapter_title)) {
		return true;
	}
	if (empty($publish_date)) {
		return true;
	}
	return false;
}

function chapterNumberIsEmpty(int $chapter_number) {
	if ($chapter_number <= 0) {
		return true;
	}
	return false;
}

function isChapterNumberUnique(object $pdo, int $chapter_number) {
	if (selectChapterNumber($pdo, $chapter_number)) {
		return false;
	}
	return true;
}	

function isChapterTitleUnique(object $pdo, string $chapter_title) {
	if (selectChapterTitle($pdo, $chapter_title)) {
		return false;
	}
	return true;
}	

function getAllChapters(object $pdo) {
	return selectAllChapters($pdo);
}

function getAllChaptersData(object $pdo) {
	return selectAllChaptersData($pdo);
}

function getChapterNumber(object $pdo, int $chapter_number) {
	return selectChapterNumber($pdo, $chapter_number);
}

function getChapterInfoCacheId(object $pdo, int $chapter_info_cache_id) {
	return selectChapterInfoCacheId($pdo, $chapter_info_cach_id);
}

function removeChapter(object $pdo, int $chapter_number) {		
	removeCoverStory($pdo, $chapter_number);	
	deleteChapter($pdo, $chapter_number);
}

function addChapter(object $pdo, int $chapter_number, string $chapter_title, string $chapter_publish_date, int $volume_number, int $story_arc_id) {
	insertChapter($pdo, $chapter_number, $chapter_title, $chapter_publish_date, $volume_number, $story_arc_id);
}

function modifyChapter(object $pdo, int $chapter_info_cache_id, int $chapter_number, string $chapter_title, string $chapter_publish_date, int $chapter_volume_number, int $chapter_story_arc_id) {
	updateChapter($pdo, $chapter_info_cache_id, $chapter_number, $chapter_title, $chapter_publish_date, $chapter_volume_number, $chapter_story_arc_id);
}

