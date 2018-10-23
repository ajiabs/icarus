<?php

/*
 * All cms data rending
*/

class Managecmsview {

    /**
     * To render the menu with menu Id
     * @param type $mainMenuId
     * @param type $level (N or number)
     * @param type $activeMenuId(If any menu ned to be selected)
     * @return string
     */
    public static function renderMenu($mainMenuId, $level="N", $activeMenuId = "",$divideStep="",$listClass="") {
        $menu = Managecmsdata::getMenu($mainMenuId);
        $menuItems = Managecmsdata::getMenuItems($mainMenuId, $level);
        if (!$menu)
            return null;
        if($menu[0]->menu_type==="Text") return self::renderTextMenu($menu,$menuItems,$activeMenuId,$divideStep,$listClass);
        else  if($menu[0]->menu_type==="Image") return self::renderImageMenu($menu,$menuItems,$activeMenuId,$divideStep,$listClass);
        else  if($menu[0]->menu_type==="Both") return self::renderTextImageMenu($menu,$menuItems,$activeMenuId,$divideStep,$listClass);
    }

    /**
     * Only handles the rendering of menu as text
     * @param type $menu
     * @param type $menuItems
     * @param type $activeMenuId
     * @return type string
     */
    public static function renderTextMenu($menu,$menuItems,$activeMenuId,$divideStep="",$listClass="") {
        $html = '<ul data-hover="dropdown" id="' . $menu[0]->title . '-' . $menu[0]->menus_id . '" class="' . $menu[0]->menu_class . '">';
        $cnt = 1;
        $listClass = " ".$listClass;

        if(!$activeMenuId){
            $activeMenuId = "index";
        }
        //echopre1($menuItems);
        foreach ($menuItems as $key => $menuItem){

            $html .= '<li ';
            $liClass = "";
            if($divideStep && $cnt==$divideStep && $listClass) {
                $liClass = $listClass;
                $cnt = 0;
            }

            if ($activeMenuId && $activeMenuId == $menuItem->menu_item_alias)
                $liClass = 'active dropdown'.$listClass;
            if($liClass){
              $html .= ' class="'.$liClass.'"';
            }else{
              $html .= ' class="dropdown"';
            }

            $html .= '>';
            $cnt++;
            //data-toggle="dropdown"

            $html .= '<a class="dropdown-toggle" data-hover="dropdown" href="'.BASE_URL.$menuItem->target_url.'" ';
            if($menuItem->target_type)
                $html .= ' target="'.$menuItem->target_type.'"';
            $html .= '><span>'.$menuItem->title.'</span></a>';
            if (isset($menuItem->hasChild)) {
                $html .= self::renderChildMenuTemplate($menuItem->hasChild, $activeMenuId);
            }
            $html .= '</li>';
        }
        return $html .= '</ul>';
    }

    /**
     * Only render the menu as image
     * @param type $menu
     * @param type $menuItems
     * @param type $activeMenuId
     * @return type string
     */
    public static function renderImageMenu($menu,$menuItems,$activeMenuId,$divideStep="",$listClass="") {
        $html = '<ul id="' . $menu[0]->title . '-' . $menu[0]->menus_id . '" class="' . $menu[0]->menu_class . '">';
        $cnt = 1;
        $listClass = " ".$listClass;
        foreach ($menuItems as $key => $menuItem) {

            $html .= '<li';
            $liClass = "";
            if($divideStep && $cnt==$divideStep && $listClass) {
                $liClass = $listClass;
                $cnt = 0;
            }
            if ($activeMenuId && $activeMenuId == $menuItem->menu_item_alias)
                $liClass = 'active'.$listClass.'>';
            if($liClass) $html .= ' class="'.$liClass.'"';
            $html .= '>';
            $cnt++;
            $html .= '<a href="'.BASE_URL.$menuItem->target_url.'" title="'.$menuItem->title.'"';
            if($menuItem->target_type)
                $html .= ' target="'.$menuItem->target_type.'"';
            $html .= ' ><img src="'.  Utils::getProjectFilePath($menuItem->icon).'"/></a>';
            if (isset($menuItem->hasChild)) {
                $html .= self::renderChildMenuTemplate($menuItem->hasChild, $activeMenuId,"Image");
            }
            $html .= '</li>';
        }
        return $html .= '</ul>';
    }

    /**
     * Both image and test will be there in the menu rendering
     * @param type $menu
     * @param type $menuItems
     * @param type $activeMenuId
     * @return type string
     */
    public static function renderTextImageMenu($menu,$menuItems,$activeMenuId,$divideStep="",$listClass="") {
        $html = '<ul id="' . $menu[0]->title . '-' . $menu[0]->menus_id . '" class="' . $menu[0]->menu_class . '">';
        $cnt = 1;
        $listClass = " ".$listClass;
        foreach ($menuItems as $key => $menuItem) {

            $html .= '<li';
            $liClass = "";
            if($divideStep && $cnt==$divideStep && $listClass) {
                $liClass = $listClass;
                $cnt = 0;
            }
            if ($activeMenuId && $activeMenuId == $menuItem->menu_item_alias)
                $liClass = 'active'.$listClass.'>';
            if($liClass) $html .= ' class="'.$liClass.'"';
            $html .= '>';

            $cnt++;
            $html .= '<a href="'.BASE_URL.$menuItem->target_url.'" title="'.$menuItem->title.'"';
            if($menuItem->target_type)
                $html .= 'target="'.$menuItem->target_type.'"';
            $html .= ' ><img src="'.  Utils::getProjectFilePath($menuItem->icon).'"/><span>'.$menuItem->title.'</span></a>';
            if (isset($menuItem->hasChild)) {
                $html .= self::renderChildMenuTemplate($menuItem->hasChild, $activeMenuId);
            }
            $html .= '</li>';
        }
        return $html .= '</ul>';
    }

    /**
     * Function to render the a submenu (The menu id will be the id of menu_items table)
     * @param type $subMenuId
     * @param type $menuClass
     * @param type $level
     * @param type $activeMenuId
     * @return string
     */
    public static function renderSubMenu($subMenuId,$menuClass="",$divideStep="",$listClass="",$level="N",$activeMenuId = "") {

        $menuItems = Managecmsdata::getChildMenuItems($subMenuId,$level);

//        echo "<pre>";var_dump($menuItems);exit;
        if (!$menuItems)
            return null;
        $html = '<ul>';
        if($menuClass)
            $html = '<ul class="'.$menuClass.'">';
        $cnt = 1;
        foreach ($menuItems as $key => $menuItem) {

            $html .= '<li';
            $liClass = "";
            if($divideStep && $cnt==$divideStep && $listClass) {
                $liClass = $listClass;
                $cnt = 0;
            }
            if ($activeMenuId && $activeMenuId == $menuItem['menu_item_alias'])
                $liClass = $listClass.' active';
            if($liClass) $html .= ' class="'.$liClass.'"';
            $html .= '>';

            $cnt++;
            $html .= '<a href="'.BASE_URL.$menuItem['target_url'].'" title="'.$menuItem['title'].'" target="'.$menuItem['target_type'].'"><span>'.$menuItem['title'].'</span></a>';
            if (isset($menuItem['hasChild'])) {
                $html .= self::renderChildMenuTemplate($menuItem['hasChild'], $activeMenuId);
            }
            $html .= '</li>';
        }
        return $html .= '</ul>';
    }

    /**
     * Function to give the child menu template
     * @param type $menuArray
     * @param type $activeMenuId
     * @param type $type
     * @return string
     */
    public static function renderChildMenuTemplate($menuArray, $activeMenuId,$type="Text") {
        if (!is_array($menuArray))
            return "";
        $html = '<ul class="dropdown-menu" >'; //style="padding-left:8px; margin-top:-8px;"
        foreach ($menuArray as $key => $menuItem) { //echopre($menuItem);
            if(trim($menuItem['parent_menu']) <> ""){
                $menuItem['target_url'] = strtolower($menuItem['parent_menu'])."_details/".$menuItem['target_url'];
            }

            $html .= '<li  '; //style="background-color:#fff; padding:5px; border-bottom:solid 1px #999;"
            if ($activeMenuId && $activeMenuId == $menuItem['menu_item_alias'])
                $html .= ' class="active">';
            else
                $html .= '>';
            if($type==="Text")
                $html .= '<a href="'.BASE_URL.$menuItem['target_url'].'" target="'.$menuItem['target_type'].'"><span>'.$menuItem['title'].'</span></a>';
            if($type==="Image")
                $html .= '<a href="'.BASE_URL.$menuItem['target_url'].'" target="'.$menuItem['target_type'].'"><img src="'.  Utils::getProjectFilePath($menuItem['icon']).'"/></a>';
            if($type==="Both")
                $html .= '<a href="'.BASE_URL.$menuItem['target_url'].'" target="'.$menuItem['target_type'].'"><img src="'.  Utils::getProjectFilePath($menuItem['icon']).'"/><span>'.$menuItem['title'].'</span></a>';

            if (isset($menuItem['hasChild'])) {
                $html .= self::renderChildMenuTemplate($menuItem['hasChild'], $activeMenuId);
            }
            $html .= '</li>';
        }
        $html .= '</ul>';
        return $html;
    }

    public static function renderPageFromUrl($alias,$returnResult=false) {
        $referenceDetails = Managecmsdata::getMenuFromAlias($alias);
        if(!$referenceDetails) return null;
        switch ($referenceDetails[0]->reference_type) {
            case "Section":
                return self::renderSection($referenceDetails[0]->reference_id,$returnResult);
                break;
            case "Category":
                return self::renderCategory($referenceDetails[0]->reference_id,$returnResult);
                break;
            case "Content":
                return self::renderContent($referenceDetails[0]->reference_id,$returnResult);
                break;

        }
        return null;
    }

    public static function formPagingUrl($alias,$request){
        $url   = BASE_URL.$alias;
        if($request['page']!="")  $url    .=  "page=".$request['page'];
        if($request['orderField']!="")  $url    .=  "&orderField=".$request['orderField']."&orderType=".$request['orderType'];
        if($request['searchField']!="") $url    .=  "&searchField=".$request['searchField']."&searchText=".$request['searchText'];
        if($request['parent_section']!="") $url .=  "&parent_section=".$request['parent_section'];
        if($request['parent_section']!="") $url .=  "&parent_id=".$request['parent_id'];
        return $url;
    }

    public static function section_pagination($total, $perPage =5,$url='',$page){
        $adjacents          =   "2";
        $page               =   ($page == 0 ? 1 : $page);
        $start              =   ($page - 1) * $perPage;
        $prev               =   $page - 1;
        $next               =   $page + 1;
        $lastPage           =   ceil($total/$perPage);
        $lpm1               =   $lastPage - 1;
        $pagination         =   "";
        if($lastPage > 1) {
            $pagination     .=  "<ul class='pagination'>";
            if($page>1)
                $pagination .=  "<li><a href='{$url}page=$prev'>&laquo;</a></li>";
//             if ($lastPage < 5 + ($adjacents * 2)) {
            if ($lastPage <= 5 + ($adjacents * 2)) {
                for ($counter = 1;
                $counter <= $lastPage;
                $counter++) {
                    if ($counter == $page)
                        $pagination .= "<li class='active'><a>$counter</a></li>";
                    else
                        $pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                }
            }
            elseif($lastPage > 5 + ($adjacents * 2)) {
                if($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1;
                    $counter < 4 + ($adjacents * 2);
                    $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                    $pagination .= "<li class='active'><a>..</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lastPage'>$lastPage</a></li>";
                }
                elseif($lastPage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li><a href='#'>..</a></li>";
                    for ($counter = $page - $adjacents;
                    $counter <= $page + $adjacents;
                    $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a>$counter</a></li>";
                        else
                            $pagination .= "<li><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                    $pagination .= "<li class='active'><a>..</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
                    $pagination .= "<li><a href='{$url}page=$lastPage'>$lastPage</a></li>";
                }
                else {
                    $pagination .= "<li><a href='{$url}page=1'>1</a></li>";
                    $pagination .= "<li><a href='{$url}page=2'>2</a></li>";
                    $pagination .= "<li><a href='#'>..</a></li>";
                    for ($counter = $lastPage - (2 + ($adjacents * 2));
                    $counter <= $lastPage;
                    $counter++) {
                        if ($counter == $page)
                            $pagination .= "<li class='active'><a>$counter</a></li>";
                        else
                            $pagination .= "<li class='right'><a href='{$url}page=$counter'>$counter</a></li>";
                    }
                }
            }
            if ($page < $counter - 1){
                $pagination .= "<li><a href='{$url}page=$lastPage'>&raquo;</a></li>";

            }
            //$pagination .='<li class="is-padded">Page<input type="text" name="goto" class="input goto is-padded" value="'.$page.'"> of  '.$lastPage.'</li>';
            $pagination .= "</ul>\n";
        }
        //echo $pagination;exit;
        return $pagination;
    }

    public static function renderSection($sectionId,$returnResult=false) {
        $result =  Managecmsdata::getSectionFullData($sectionId);

        if(!$result) return null;
        if($result[0]->icon)
            $html = '<div id="section_'.$sectionId.'" class="sec_'.$sectionId.'"><img src="'.Utils::getProjectFilePath($result->icon).'" /><span>'.$result[0]->title.'</span>';
        else
            $html = '<div id="section_'.$sectionId.'" class="sec"><span>'.$result[0]->title."</span>";
        foreach($result as $key=>$value) {
            if(!empty($value->child)) {
                $catArray = $value->child;
                $html .= '<div id="category_'.$key.'" class="cat">';
                foreach($catArray as $key1=>$category) {
                    $html .= '<span class="category-name"><h3>'.$category->title.'</h3></span>';
                    if($category->icon) {
                        $html .= '<span class="cat_image><img class="category-image" src="'.Utils::getProjectFilePath($category->icon).'" /></span>';
                        $result[$key]->child[$key1]->icon =Utils::getProjectFilePath($category->icon);
                    }
                    if(!empty($category->child)) {
                        $contentArray = $category->child;
                        $html .= '<div id="content_'.$key1.'" class="content-area">';
                        foreach($contentArray as $key2=>$content) {
                            $html .= '<span class="content-name"><h3>'.$content->title.'</h3></span>';
                            if($content->icon) $html .= '<span class="con_image><img class="content-image" src="'.Utils::getProjectFilePath($content->icon).'" /></span>';
                            if($content->summary) {
                                $html .= '<div class="content_summary><p>'.Utils::parseContentHtml($content->summary).'" /></p></div>';
                                $result[$key]->child[$key1]->child[$key2]->summary = Utils::parseContentHtml($content->summary);
                            }
                            if($content->description) {
                                $html .= '<div class="content_description><p>'.Utils::parseContentHtml($content->description).'" /></p></div>';
                                $result[$key]->child[$key1]->child[$key2]->description = Utils::parseContentHtml($content->description);
                            }
                            if($content->icon) {
                                $html .= '<div class="content_image><p><img src="'.  Utils::getProjectFilePath($content->icon).'"/></p></div>';
                                $result[$key]->child[$key1]->child[$key2]->icon = Utils::getProjectFilePath($content->icon);
                            }
                            $result[$key]->child[$key1]->child[$key2]->created_on = date("d-F-Y",strtotime($contentArray[$key2]->created_on));  //Utils::formatDateString($contentArray[$key2]->created_on);
                        }
                        $html .= '</div>';
                    }
                }
                $html .= '</div>';
            }
        }
        $html .= '</div>';

        if($returnResult)
            return $result;
        else
            return $html;
    }

    public static function renderCategory($categoryId,$returnResult=false) {
        $categoryArray =  Managecmsdata::categoriesFullData($categoryId);

        $html .= '<div id="category_'.$categoryId.'" class="cat">';
        foreach($categoryArray as $key1=>$category) {
            $html .= '<span class="category-name"><h3>'.$category->title.'</h3></span>';
            if($category->icon) {
                $html .= '<span class="cat_image><img class="category-image" src="'.Utils::getProjectFilePath($category->icon).'" /></span>';
                $categoryArray[$key1]->icon =Utils::getProjectFilePath($category->icon);
            }
            if(!empty($category->child)) {
                $contentArray = $category->child;
                $html .= '<div id="content_'.$key1.'" class="content-area">';
                foreach($contentArray as $key2=>$content) {
                    $html .= '<span class="content-name"><h3>'.$content->title.'</h3></span>';
                    if($content->icon) $html .= '<span class="con_image><img class="content-image" src="'.Utils::getProjectFilePath($content->icon).'" /></span>';
                    if($content->summary) {
                        $html .= '<div class="content_summary><p>'.Utils::parseContentHtml($content->summary).'" /></p></div>';
                        $contentArray[$key2]->summary = Utils::parseContentHtml($content->summary);
                    }
                    if($content->description) {
                        $html .= '<div class="content_description><p>'.Utils::parseContentHtml($content->description).'" /></p></div>';
                        $contentArray[$key2]->description = Utils::parseContentHtml($content->description);
                    }
                    if($content->icon) {
                        $html .= '<div class="content_image><p><img src="'.  Utils::getProjectFilePath($content->icon).'"/></p></div>';
                        $contentArray[$key2]->icon = Utils::getProjectFilePath($content->icon);
                    }
                    $contentArray[$key2]->created_on = ""; //Utils::formatDateString($contentArray[$key2]->created_on);
                }
                $html .= '</div>';
            }
        }
        $html .= '</div>';

        if($returnResult){
            $content               = $categoryArray[0]->child;
            $content->description  = Utils::parseContentHtml($content->description); //echopre($content[0]->description);
            $content->summary      = Utils::parseContentHtml($content->summary);
            return $content;
        }else{
            return $html;
        }

        /* if($returnResult)
            return $categoryArray;
        else
            return $html; */
    }

    public static function renderContent($contentId,$returnResult=false) {
        $content =  Managecmsdata::getContentData($contentId);
        if($content) {
            $html .= '<div id="category_'.$content['id'].'" class="cat">';

            $html .=  Utils::parseContentHtml($content[0]->description);
            $html .= '</div>';
        }
        if($returnResult) {
            $content[0]->description = Utils::parseContentHtml($content[0]->description); //echopre($content[0]->description);
            $content[0]->summary = Utils::parseContentHtml($content[0]->summary);
            return $content;
        }
        else
            return $html;
    }

}
?>
