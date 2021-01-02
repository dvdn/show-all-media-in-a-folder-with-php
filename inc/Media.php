<?php

/**
* Media management class
*
* Configuration :
*   folderPath : path to media folder,
*   types : which Media file types will be displayed,
*   sortByName : to sort by name. Default false, Media will be sorted by last modified date,
*   reverseOrder : to invert sort order, if 'true'
*                   if sorted by date, ordered by newests Media (uses EXIF data if possible),
*                   if sorted by name order is naturally inverted,
*   dateFormat : date format in label (http://php.net/manual/en/function.date.php)
*   pagination : [usePagination : true/false, MediaPerPage : number of Media per pages]
*
*/

require_once "Pagination.php";

class Media {

    public function __construct() {
        $this->folderPath = "media/";
        $this->imgTypes = "*.jpg,*.JPG,*.jpeg,*.JPEG,*.png,*.PNG,*.gif,*.GIF";
        $this->vidTypes = "*.avi,*.AVI,*.mp4,*.MP4,*.mov,*.MOV";
        $this->audioTypes = "*.mp3,*.MP3,*.ogg,*.OGG";
        $this->types = "{".$this->imgTypes.",".$this->vidTypes.",".$this->audioTypes."}";
        $this->sortByName = true;
        $this->reverseOrder = false;
        $this->dateFormat = "F d Y"; //"F d Y H:i:s"
        $this->pagination = array (
                    "usePagination" => false,
                    "mediaPerPage" => 5
                    );
        # Media array list generation
        $this->MediaList = glob($this->folderPath.$this->types, GLOB_BRACE);
    }

    /**
     *
     * Sort Media list
     *
     * @param    array $MediaList to sort
     * @return    array $sortedMedia
     *
     */
    public function sortMediaList(Array $MediaList){
        $sortedMedia = array();
        # check sort by name or by date
        if ($this->sortByName) {
            $sortedMedia = $MediaList;
            if ($this->reverseOrder) {
                rsort($sortedMedia);
            } else {
                natsort($sortedMedia);
            }
        } else {
            # sort by 'last modified' timestamp
            $count = count($MediaList);
            for ($i = 0; $i < $count; $i++) {
                $sortedMedia[date('YmdHis', $this->getLastTimestamp($MediaList[$i])) . $i] = $MediaList[$i];
            }
            if ($this->reverseOrder) {
                krsort($sortedMedia);
            } else {
                ksort($sortedMedia);
            }
        }

        return $sortedMedia;
    }

    /**
     *
     * Html Media list rendering
     *
     * @param    array $MediaList to render
     * @return    void, echoes Html
     *
     */
    public function renderMediaHtml(Array $MediaList) {
        foreach ($MediaList as $media) {

            $ext = pathinfo($media, PATHINFO_EXTENSION);


            if (strpos($this->imgTypes, $ext) !== false) {
                $this->renderImageHtml($media);
            } elseif (strpos($this->vidTypes, $ext) !== false)  {
                //$this->renderHtmlVid($media);
                $this->renderHtmlMedia($media, 'video');
            } elseif (strpos($this->audioTypes, $ext) !== false)  {
                //$this->renderHtmlAudio($media);
                $this->renderHtmlMedia($media, 'audio');
            }
        }
    }

    /**
     *
     * get media info
     *
     * @param    string $media to fetch
     * @return    array($mediaName, $label)
     *
     */
    private function getMediaInfo($media) {
        # Get media name without path and extension
        $mediaName = basename($media);
        $mediaName = pathinfo($mediaName, PATHINFO_FILENAME);

        $date = date($this->dateFormat , $this->getLastTimestamp($media));
        $dateLabel = '(last modified : ' . $date . ')';

        $label = $mediaName.' '.$dateLabel;

        return array($mediaName, $label);

    }

    /**
     *
     * Html image rendering
     *
     * @param    string $image to render
     * @return    void, echoes Html
     *
     */
    private function renderImageHtml($image) {

        $imageInfos = $this->getMediaInfo($image);
        $imageName = $imageInfos[0];
        $label = $imageInfos[1];


        # html
        echo <<<EOT
        <li class="item">
            <div class="media" onclick=this.classList.toggle("zoom");>
                <a name="$image" href="#$image ">
                    <img src="$image" alt="$imageName" title="$imageName">
                </a>
            </div>
            <div class="media-label">$label</div>
        </li>
EOT;
    }

    /**
     *
     * Html media rendering
     *
     * @param    string $media to render
     * @param    string $type tag to render
     * @return    void, echoes Html
     *
     */
    private function renderHtmlMedia($media, $type) {

        $imageInfos = $this->getMediaInfo($media);
        $imageName = $imageInfos[0];
        $label = $imageInfos[1];


        # html
        echo <<<EOT
        <li class="item">
            <div class="media">
                <$type controls= "controls" src="$media">
                    Your browser does not support the $type element.
                </$type>
            </div>
            <div class="media-label">$label</div>
        </li>
EOT;
    }

    /**
     *
     * Get media last modification date timestamp
     * using EXIF data if possible
     *
     * @param    string $media to render
     * @return    string $datetimestamp
     *
     */
    private function getLastTimestamp($image) {
        if (exif_imagetype($image) == 2 && exif_read_data($image) !== false) {
            $exifData = exif_read_data($image);
            if (array_key_exists('DateTimeOriginal', $exifData)) {
                $rawDate = $exifData['DateTimeOriginal'];
            } else if (array_key_exists('DateTime', $exifData)) {
                $rawDate = $exifData['DateTime'];
            }
            if (isset($rawDate)) {
                $d = new DateTime($rawDate);
                $datetimestamp = $d->getTimestamp();
            }
        }

        if (false == isset($datetimestamp)) {
            // last modified date
            $datetimestamp =  filemtime($image);
        }

        return $datetimestamp;
    }

    /**
     *
     * Manage pagination
     *
     * @param    array $MediaList
     * @return    array data to display, array MediaToDisplay and html for pagination
     *
     */
    public function managePagination(Array $MediaList) {
        $htmlPagination = false;
        if ($this->pagination['usePagination']) {
            $Pagination  = new Pagination($MediaList);
            $pageNumber = 1;
            if (isset($_GET['page']) && is_numeric($_GET['page']) && ($_GET['page'] > 0)) {
                $pageNumber = (int) $_GET['page'];
            }
            $MediaToDisplay = $Pagination->getPageData($MediaList, $this->pagination['mediaPerPage'], $pageNumber);
            $htmlPagination = $Pagination->renderPaginationHtml($pageNumber);
        } else {
            $MediaToDisplay = $MediaList;
        }
        return array("MediaToDisplay"=>$MediaToDisplay, "htmlPagination"=>$htmlPagination);
    }

    /**
     *
     * Action render Media list and eventually pagination
     *
     * @param    array $dataToDisplay
     * @return    void, echoes html
     *
     */
    public function renderHtmlData(Array $dataToDisplay) {
        echo('<ul class="items">');
            $this->renderMediaHtml($dataToDisplay["MediaToDisplay"]);
        echo('</ul>');
        echo $dataToDisplay["htmlPagination"];
    }


}
