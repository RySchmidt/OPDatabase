<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "volume/volumeModel.inc.php";

function getVolumes(object $pdo) {
	return selectVolumes($pdo);
}	
