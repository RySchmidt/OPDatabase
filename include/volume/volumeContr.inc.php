<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "volume/volumeModel.inc.php";
require_once "sbs/sbsContr.inc.php";
require_once "chapter/chapterContr.inc.php";

function addVolume(object $pdo, int $volume_number, string $volume_title, string $volume_publish_date, int $min_chapter_number, int $max_chapter_number) {
	insertVolume($pdo, $volume_number, $volume_title, $volume_publish_date);
	modifyChapterVolumeNumber($pdo, $volume_number, $min_chapter_number, $max_chapter_number);
}

function modifyVolume(object $pdo, int $original_volume_number, int $volume_number, string $volume_title, string $volume_publish_date, int $min_chapter_number, int $max_chapter_number) {
	updateVolume($pdo, $original_volume_number, $volume_number, $volume_title, $volume_publish_date);
	modifyChapterVolumeNumber($pdo, $volume_number, $min_chapter_number, $max_chapter_number);
}

function removeVolume(object $pdo, int $volume_number) {		
	removeSBS($pdo, $volume_number);	
	deleteVolume($pdo, $volume_number);
}

function isVolumeNumberUnique(object $pdo, int $volume_number) {
	if (selectVolumeFromNumber($pdo, $volume_number)) {
		return false;
	}
	return true;
}	

function getVolumeFromNumber(object $pdo, int $volume_number) {
	return selectVolumeFromNumber($pdo, $volume_number);
}

function getAdvancedVolumeFromNumber(object $pdo, int $volume_number) {
	return selectAdvancedVolumeFromNumber($pdo, $volume_number);
}

function isVolumeTitleUnique(object $pdo, string $volume_title) {
	if (selectVolumeFromTitle($pdo, $volume_title)) {
		return false;
	}
	return true;
}	

function getAllVolumes(object $pdo) {
	return selectAllVolumes($pdo);
}	

function viewAdvancedVolumeView(object $pdo) {
	updateAdvancedVolumeView($pdo);
}

function getVolumeInputDisplay(object $pdo) {
	return selectVolumeInputDisplay($pdo);
}
