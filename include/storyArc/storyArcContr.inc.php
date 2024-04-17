<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "storyArc/storyArcModel.inc.php";

function getStoryArc(object $pdo) {
	return selectStoryArc($pdo);
}

function getAllAdvancedStoryArc(object $pdo) {
	return selectAdvancedStoryArc($pdo);
}	

function viewAdvancedStoryArc(object $pdo) {
	updateAdvancedStoryArc($pdo);
}
