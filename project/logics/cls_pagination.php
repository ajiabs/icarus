<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

// +----------------------------------------------------------------------+
// | File name : cls_pagination.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems                                      |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Pagination {
    /*
     * function for pagination
     * $currentPage --Your current page
     * $recordsPerPageLimit - Items per page
     * $totalRecords -Total no of records
     * $targetpage -url 
     */
    
    

    public function paginate($currentPage, $recordsPerPageLimit, $totalRecords,$targetpage,$adjacents='2') {
       /* Setup page vars for display. */
        if ($currentPage == 0)
        $currentPage = 1; //if no page , default to 1.
        $prev = $currentPage - 1; //previous page is page - 1
        $next = $currentPage + 1; //next page is page + 1
        $lastpage = ceil($totalRecords / $recordsPerPageLimit); //lastpage is = total records / items per page, rounded up.
        $lpm1 = $lastpage - 1; //last page minus 1
        /*
          Now we apply our rules and draw the pagination object.
          We're actually saving the code to a variable in case we want to draw it more than once.
         */
        //echo "<br>page", $currentPage;
        $pagination = "";
        if ($lastpage >=1) {
            $pagination .= "<div class=\"pagination\">";
            //previous button
            if ($currentPage > 1) {
                $pagination.= "<a href=\"$targetpage&page=$prev\">Previous</a>";
            } else {
                $pagination.= "<span class=\"disabled\">Previous</span>";
            }
            //echo "<br>Page begin",$pagination;
            //pages	
            if ($lastpage < 7 + ($adjacents * 2)) { //not enough pages to bother breaking it up
                for ($counter = 1; $counter <= $lastpage; $counter++) {
                    if ($counter == $currentPage) {
                        $pagination.= "<span class=\"current\">$counter</span>";
                    } else {
                        $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                    }
                }
            } elseif ($lastpage > 5 + ($adjacents * 2)) { //enough pages to hide some
            //close to beginning; only hide later pages
                //echo"else";
                if ($currentPage < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $currentPage) {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        } else {
                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                        }
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                }
                //in middle; hide some front and some back
                elseif ($lastpage - ($adjacents * 2) > $currentPage && $currentPage > ($adjacents * 2)) {
                    $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                    $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                    $pagination.= "...";
                    for ($counter = $currentPage - $adjacents; $counter <= $currentPage + $adjacents; $counter++) {
                        if ($counter == $currentPage) {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        } else {
                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                        }
                    }
                    $pagination.= "...";
                    $pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";
                }
                //close to end; only hide early pages
                else {
                    $pagination.= "<a href=\"$targetpage&page=1\">1</a>";
                    $pagination.= "<a href=\"$targetpage&page=2\">2</a>";
                    $pagination.= "...";
                    for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++) {
                        if ($counter == $currentPage) {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        } else {
                            $pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";
                        }
                    }
                }
            }
            //next button
            if ($currentPage < $counter - 1) {
                $pagination.= "<a href=\"$targetpage&page=$next\">Next </a>";
            } else {
                $pagination.= "<span class=\"disabled\">Next</span>";
            }
            $pagination.= "</div>\n";
        }
        
        return $pagination;
    }

}

?>