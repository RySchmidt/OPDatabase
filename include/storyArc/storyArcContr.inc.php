<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "storyArc/storyArcModel.inc.php";
require_once "chapter/chapterContr.inc.php";

function addStoryArc(object $pdo, string $story_arc_title, int $parent_story_arc_id, int $min_chapter_number, int $max_chapter_number) {
	insertStoryArc($pdo, $story_arc_title, $parent_story_arc_id);
	$result = selectStoryArcFromTitle($pdo, $story_arc_title);
	modifyChapterStoryArc($pdo, $result["id"], $parent_story_arc_id, $min_chapter_number, $max_chapter_number);
}

function modifyStoryArc(object $pdo, int $story_arc_id, string $story_arc_title, int $parent_story_arc_id, int $min_chapter_number, int $max_chapter_number) {
	updateStoryArc($pdo, $story_arc_id, $story_arc_title, $parent_story_arc_id);
	modifyChapterStoryArc($pdo, $story_arc_id, $parent_story_arc_id, $min_chapter_number, $max_chapter_number);
}

function removeStoryArc(object $pdo, int $story_arc_id) {
	deleteStoryArc($pdo, $story_arc_id);
}

function isStoryArcTitleUnique(object $pdo, string $story_arc_title) {
	if (selectStoryArcFromTitle($pdo, $story_arc_title)) {
		return false;
	}
	return true;
}

function getStoryArc(object $pdo) {
	return selectStoryArc($pdo);
}

function getAllAdvancedStoryArc(object $pdo) {
	return selectAdvancedStoryArc($pdo);
}	

function getAdvancedStoryArcFromId(object $pdo, int $story_arc_id) {
	return selectAdvancedStoryArcFromId($pdo, $story_arc_id);
}	

function viewAdvancedStoryArc(object $pdo) {
	updateAdvancedStoryArc($pdo);
}
