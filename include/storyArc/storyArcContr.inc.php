<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "storyArc/storyArcModel.inc.php";

function getStoryArcs(object $pdo) {
	return selectStoryArcs($pdo);
}	

function viewStoryArcCombined(object $pdo) {
	updateViewStoryArcCombined($pdo);
}
