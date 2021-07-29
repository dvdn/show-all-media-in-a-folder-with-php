Show all media in a folder with PHP
------------------------------------

A simple webpage to display all images, video and audio files in a folder with PHP.

Large images will be displayed smaller than their original dimensions.

Video and Audio files will display HTML5 controls and can be played by HTML5 player.

You can specify how many media you want to display per pages.

See [Demo](http://dvdn.online.fr/show-all-media-in-folder/)

### Setup
#### The easy way
This works out of the box, so you can either [download the zip](https://github.com/dvdn/show-all-media-in-a-folder-with-php/archive/master.zip) or 'git clone' this repository.

#### The other way
Copy 'inc' folder [`inc`](https://github.com/dvdn/show-all-media-in-a-folder-with-php/blob/master/inc/) in your root folder (or wherever your index file is).

In your index page :

in the head

    <!-- style for media insertion -->
    <link rel="stylesheet" type="text/css" href="inc/ins-media.css">

in the body

    <!-- media insertion -->
    <?php include "ins-media.php"; ?>


### Settings
Adapt values in [`config.php`](https://github.com/dvdn/show-all-media-in-a-folder-with-php/blob/master/inc/config.php) according to your needs.

    *   folderPath : path to media folder,
    *   types : which Media file types will be displayed,
    *   sortByName : to sort by name. Default false, Media will be sorted by last modified date,
    *   reverseOrder : to invert sort order, if 'true'
    *                   if sorted by date, ordered by newests Media (uses EXIF data if possible),
    *                   if sorted by name order is naturally inverted,
    *   dateFormat : date format in label (http://php.net/manual/en/function.date.php)
    *   usePagination : true/false,
    *   mediaPerPage : number of Media per pages if usePagination true

### Origin
This project is an evolution of https://github.com/dvdn/show-all-images-in-a-folder-with-php.

Features addition :
- support for Audio and Video files

### Contributions
Very welcomed.
