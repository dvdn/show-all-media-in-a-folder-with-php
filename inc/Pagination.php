<?php

/**
*
* Pagination class
*
*/

class Pagination {
    private $limit;
    private $total;
    public $last;

    public function __construct( Array $images) {
        $this->total = count($images);
    }

    /**
     *
     * Filter data paginated
     *
     * @param    array $imagesList to render
     * @param    integer $page, number
     * @return    Array $pageImages, list images to display
     *
     */
    public function getPageData( Array $images, $limit, $page = 1) {
        $this->limit = $limit;
        $this->last = ceil( $this->total / $limit );
        $page = $page-1; // for human read
        $offset = $page * $limit;
        $pageImages = array_slice($images, $offset, $limit);
        return $pageImages;
    }

    /**
     *
     * Render pagination html
     *
     * @param    integer $pageActive, number
     * @return    Array $pageImages, list images to display
     *
     */
    public function renderPaginationHtml($pageActive = 1) {
        $html = '<div class="pagination"><span>&gt;</span><span>';
        for ( $i = 1 ; $i <= $this->last; $i++ ) {
            $html .= '<a title="page '.$i.'" href="?page='.$i.'"';
            if ($i == $pageActive) {
                $html .= 'class="active"';
            }
            $html .= '>'.$i.'</a>';
        }
        $html .= '</span></div>';
        return $html;
    }
}

?>
