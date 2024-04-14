<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';


function isInputEmpty(string $number, string $title, string $publish_date) {
	if (empty($number)) {
		return true;
	}
	if (empty($title)) {
		return true;
	}
	if (empty($publish_date)) {
		return true;
	}
	return false;
}	

function isChapterNumberUnique(object $pdo, string $number) {
	if (selectChapterNumber($pdo, $number)) {
		return false;
	}
	else {
		return true;
	}
}	

function isChapterTitleUnique(object $pdo, string $title) {
	if (selectChapterTitle($pdo, $title)) {
		return false;
	}
	else {
		return true;
	}
}	
