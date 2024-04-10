<?php 

define( 'ROOT_DIR', __DIR__);

$path = ROOT_DIR . '/include';
set_include_path($path . PATH_SEPARATOR . get_include_path());
