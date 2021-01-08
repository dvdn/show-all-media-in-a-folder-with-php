<?php

/*
* Configuration File
*
*   folderPath : path to media folder,
*   types : which Media file types will be displayed,
*   sortByName : to sort by name. Default false, Media will be sorted by last modified date,
*   reverseOrder : to invert sort order, if 'true'
*                   if sorted by date, ordered by newests Media (uses EXIF data if possible),
*                   if sorted by name order is naturally inverted,
*   displayDate : true/false, display date in label
*   dateFormat : date format in label (http://php.net/manual/en/function.date.php)
*   usePagination : true/false,
*   mediaPerPage : number of Media per pages if usePagination true
*/

return array(
    'folderPath' => "media/",
    'imgTypes' => "*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF",
    'vidTypes' => "*.avi,*.AVI,*.mp4,*.MP4,*.mov,*.MOV",
    'audioTypes' => "*.mp3,*.MP3,*.ogg,*.OGG",
    'sortByName' => true,
    'reverseOrder' => false,
    'displayDate' => true,
    'dateFormat' => "F d Y",
    'usePagination' => false,
    'mediaPerPage' => 5
);
