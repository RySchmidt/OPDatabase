<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "coverStory/coverStoryModel.inc.php";

function isCoverStoryEmpty(string $cover_story_title) {
	if (empty($cover_story_title)) {
		return true;
	}
	return false;
}	

function isCoverStoryTitleUnique(object $pdo, string $cover_story_title) {
	if (selectCoverStoryTitle($pdo, $cover_story_title)) {
		return false;
	}
	return true;
}	

function getCoverStoryFromChapterNumber(object $pdo, int $chapter_number) {
	return selectCoverStoryChapterNumber($pdo, $chapter_number);
}

function getAllCoverStories(object $pdo) {
	return selectAllCoverStories($pdo);
}

function removeCoverStory(object $pdo, int $chapter_number) {
	return deleteCoverStory($pdo, $chapter_number);
}

function addCoverStory(object $pdo, int $chapter_number, string $cover_story_title, string $publish_date, int $cover_story_arc_id) {
	insertCoverStory($pdo, $chapter_number, $cover_story_title, $publish_date, $cover_story_arc_id);
}

function modifyCoverStory(object $pdo, int $chapter_number, string $cover_story_title, int $cover_story_arc_id, string $publish_date) {
	updateCoverStory($pdo, $chapter_number, $cover_story_title, $cover_story_arc_id, $publish_date);
}

function viewInfoCacheCoverStory(object $pdo) {
	updateViewInfoCacheCoverStory($pdo);
}

