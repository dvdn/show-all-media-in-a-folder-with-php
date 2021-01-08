<?php

$configs = include "config.php";
require_once "Media.php";

/**
* Media insertions
*/

$Media  = new Media($configs);
$MediaList = $Media->sortMediaList($Media->MediaList);
$dataToDisplay = $Media->managePagination($MediaList);
//render full html
$Media->renderHtmlData($dataToDisplay);
