<?php

/*
 * Manage CMS datas for a page
 */

class Managecmsdata {

    /**
     * Function to get main menu
     * @param type $menuId
     * @return type array
     */
    public static function getMenu($menuId) {
        $table = 'cms_menus';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND menus_id='" . $menuId . "' ";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

    /**
     * Function to get child menus upto nth level
     * @param type $parentId
     * @param type $level(if N it will give all otherwise up to that count in a tree level)
     * @return type array
     */
    public static function getChildMenuItems($parentId, $level) {

        $db = new Db();
        $i = 0;
        $childrenData = array();
        $childrens = array();
        $where = " M.enabled = 'Y' AND M.menu_parent_id = '$parentId'";
        $order = " ORDER BY M.display_order ASC";
        $query = "SELECT
                      M.menu_item_id,
                      M.reference_id,
                      M.title,
                      M.reference_type,
                      M.menu_item_alias,
                      M.target_type,
                      M.display_order,
                      M.target_url,
                      M.icon,
                      PM.menu_item_alias as parent_menu
                  FROM
                      cms_menu_items M
                        LEFT JOIN `cms_menu_items` PM ON PM.`menu_item_id` = M.`menu_parent_id`
                  WHERE
                      $where
                      $order";
        $childrens = $db->selectQuery($query);
        if ($level != "N") {
            --$level;
        }
        foreach ($childrens as $child) {
            $child = (array) $child;
            $newchild = "";
            if ($level === "N" || $level != 0) {
                if (count(self::getChildMenuItems($child['menu_item_id'])) > 0){
                    $newchild = self::getChildMenuItems($child['menu_item_id']);
                }
            }
            $childrenData[$i] = $child;

            if ($newchild != "") {
                $childrenData[$i]['hasChild'] = (array) $newchild;
            }
            $i++;
        }
        //echopre1($childrenData);
        return $childrenData;
    }

    /**
     * Function to get menu items within a particular menu
     * @param type $menuId
     * @param type $level
     * @return type
     */
    public static function getMenuCmsItems($menuId, $reference_type='', $excluded_arrlist) {
        $table    = 'cms_menu_items';
        $db       = new Db();
        $fileds   = "DISTINCT menu_item_alias,menu_item_id,reference_type,reference_id,title,target_type,target_url,display_order,icon";
        $where    = " enabled = 'Y' AND menu_parent_id = 0 ";
        if(trim($menuId) <> ""){
            $where .= " AND `menus_id` = '".$menuId."'";
        }
        if(trim($reference_type) <> ""){
            $where .= " AND `reference_type` = '".trim($reference_type)."' AND menu_parent_id=0 ";
        }
        if(is_array($excluded_arrlist) && count($excluded_arrlist) > 0){
            $excluded_list = "'".implode("','",$excluded_arrlist)."'";
            $where        .= " AND `menu_item_alias` NOT IN(".$excluded_list.")";
        }
        $order  = " ORDER BY display_order ASC";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where $order");

        if ($level !== "N" && $level <= 1)
            return $result;
        if ($level !== "N")
            $level = --$level;
        foreach ($result as $key => $menu) {
            $child = self::getChildMenuItems($menu->menu_item_id, $level);
            $menu = (array) $menu;
            if (sizeof($child) > 0) {
                $result[$key]->hasChild = $child;
            }
        }
        return $result;
    }

    /**
     * Function to get menu items within a particular menu
     * @param type $menuId
     * @param type $level
     * @return type
     */
    public static function getMenuItems($menuId, $level) {
        $table = 'cms_menu_items';
        $db = new Db();
        $fileds = "menu_item_id,reference_type,reference_id,title,menu_item_alias,target_type,target_url,display_order,icon";
        $where = " enabled = 'Y' AND menus_id='" . $menuId . "' AND menu_parent_id=0  ";
        $order = " ORDER BY display_order ASC";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where $order");
        if ($level !== "N" && $level <= 1)
            return $result;
        if ($level !== "N")
            $level = --$level;
        foreach ($result as $key => $menu) {
            $child = self::getChildMenuItems($menu->menu_item_id, $level);
            $menu = (array) $menu;
            if (sizeof($child) > 0) {
                $result[$key]->hasChild = $child;
            }
        }
        return $result;
    }

    /**
     * Function to get section menu items details for routing on routes.php file
     * @param type $menuId
     * @return type array
     */
    /*public static function getSectionMenuAliasForRouting(){
        $db = new Db();
        $contentDetails = $db->selectQuery("SELECT `menu_item_alias` FROM `cms_menu_items` WHERE `menu_item_id` IN(SELECT DISTINCT `menu_parent_id` FROM `cms_menu_items` WHERE `reference_type` = 'Category')");
        return $contentDetails;
    }*/

    public static function getSectionMenuAliasForRouting(){
        $db = new Db();
        $contentDetails = $db->selectQuery("SELECT `menu_item_alias` FROM `cms_menu_items` WHERE `reference_type` = 'Section'");
        return $contentDetails;
    }

    public static function getSectionOtherAliasForRouting(){
        $db = new Db();
        $contentDetails = $db->selectQuery("SELECT `section_alias` FROM `cms_page_sections` WHERE 1=1 AND `show_homepage` = '1' AND `section_alias` NOT IN(SELECT `menu_item_alias` FROM `cms_menu_items` WHERE `reference_type` = 'Section')");
        return $contentDetails;
    }

    /**
     * Function to get menu details from alias name
     * @param type $menuId
     * @return type array
     */
    public static function getMenuFromAlias($alias) {
        $table = 'cms_menu_items';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND menu_item_alias='" . $alias . "' ";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

     /**
     * Function to get section
     * @param type $menuId
     * @return type array
     */
    public static function getSectionData($sectionId) {
        $table = 'cms_page_sections';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND section_id='" . $sectionId . "' ";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

     /**
     * Function to get section complete data ie categories under the section and contents under the categories
     * @param type $menuId
     * @return type array
     */
    public static function getSectionFullData($sectionId) {
        $section = self::getSectionData($sectionId);
        if(!$section) return null;

        $category = self::categoriesFullDataBySection($sectionId);
        if(!$category) return $section;
        $section[0]->child = $category;
        return $section;
    }

    /**
    * Function to get section complete data ie categories under the section and contents under the categories by alias
    * @param type $alias
    * @return type array
    **/
    public static function getSectionFullDataByAlias($alias){
       $sectionId = self::getSectionIdByAlias($alias);
       if(!$sectionId){
          $category[0] = "nodata";
          return $category;
       }

       $section = self::getSectionData($sectionId);
       if(!$section) return null;

       $category = self::categoriesFullDataBySection($sectionId);
       if(!$category) return $section;

       $section[0]->child = $category;
       return $section;
    }

    /**
    * Function to get section complete data ie categories under the section and contents under the categories by alias
    * @param type $alias
    * @return type array
    **/
    public static function getSectionRandomDataByAlias($alias){
       $sectionId = self::getSectionIdByAlias($alias);
       if(!$sectionId) return null;

       $section = self::getSectionData($sectionId);
       if(!$section) return null;

       $category = self::categoriesRandomDataBySection($sectionId);
       if(!$category) return $section;

       $section[0]->child = $category;
       return $section;
    }

    /**
    * Function to get section complete data ie categories under the section and contents under the categories by alias
    * @param type $alias
    * @return type array
    **/
    public static function getSectionHomeSliderDataByAlias($alias){
       $sectionId = self::getSectionIdByAlias($alias);
       if(!$sectionId) return null;

       $section = self::getSectionData($sectionId);
       if(!$section) return null;

       $category = self::categoriesHomeSliderDataBySection($sectionId);
       if(!$category) return $section;

       $section[0]->child = $category;
       return $section;
    }

    /**
    * Function to get homepage random block data contents
    * @return type array
    */
    public static function getHomePageRandomSections(){
       $random_sections = self::getHomePageRandomSectionData();
       //echopre($random_sections);
       if(is_array($random_sections) && count($random_sections) > 0){
          foreach($random_sections as $random_section_id => $random_section){
              if(trim($random_section->section_alias) <> ""){
                  $random_section_content  = self::getSectionRandomDataByAlias(trim($random_section->section_alias));
                  $random_sections[$random_section_id]->data   = $random_section_content;
              }
          }
       }
       return $random_sections;
    }

    /**
    * Function to get section
    * @return type array
    */
    public static function getHomePageRandomSectionData(){
       $table    = 'cms_page_sections';
       $db       = new Db();
       $fileds   = " `section_id`,title,section_alias ";
       $where    = " `enabled` = 'Y' AND `show_homepage` = '1' AND `homepage_viewformat` = 'block' ";
       $orderby  = ' ORDER BY `homepage_order` ASC';
       $result   = $db->selectQuery("SELECT $fileds FROM $table WHERE $where $orderby");
       return $result;
    }

    /**
    * Function to get homepage random block data contents
    * @return type array
    */
    public static function getHomePageSliderSections(){
       $slider_sections = self::getHomePageSliderSectionData();
       //echopre($random_sections);
       if(is_array($slider_sections) && count($slider_sections) > 0){
          foreach($slider_sections as $slider_section_id => $slider_section){
              if(trim($slider_section->section_alias) <> ""){
                  $slider_section_content  = self::getSectionHomeSliderDataByAlias(trim($slider_section->section_alias));
                  $slider_sections[$slider_section_id]->data   = $slider_section_content;
              }
          }
       }
       return $slider_sections;
    }

    /**
    * Function to get section
    * @return type array
    */
    public static function getHomePageSliderSectionData(){
       $table    = 'cms_page_sections';
       $db       = new Db();
       $fileds   = " `section_id`,title,section_alias ";
       $where    = " `enabled` = 'Y' AND `show_homepage` = '1' AND `homepage_viewformat` = 'slider' ";
       $orderby  = ' ORDER BY `homepage_order` ASC';
       $result   = $db->selectQuery("SELECT $fileds FROM $table WHERE $where $orderby");
       return $result;
    }

   /**
   * Function to get section
   * @param type $menuId
   * @return type array
   */
   public static function getSectionIdByAlias($alias) {
      $table    = 'cms_page_sections';
      $db       = new Db();
      $fileds   = " section_id ";
      $where    = " `enabled` = 'Y' AND `section_alias` = '".$alias."' ";
      $result   = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
      return $result[0]->section_id;
    }

     /**
     * Function to get section complete data ie categories under the section and contents under the categories
     * @param type $sectionId
     * @return type array
     */
    public static function categoriesFullDataBySection($sectionId) {
        $categories = self::getSectionCategories($sectionId); //echopre($categories);
        if(!$categories) return null;
        foreach($categories as $key=>$category)
        {
            $contents = self::getCategoryContents($category->category_id);
            if($contents)
            {
                $categories[$key]->child = $contents;
            }
            if(trim($category->category_alias) <> ""){ //To fetch the target type associated with the menu item entry
                $target_type  = self::getTargetTypeOfMenuByAlias($category->category_id);
                $categories[$key]->target_type = $target_type[0]->target_type;
            }
        }
        return $categories;
    }

    public static function getTargetTypeOfMenuByAlias($category_id) {
        $table    = 'cms_menu_items';
        $db       = new Db();
        $fileds   = "target_type";
        $where    = " reference_id = '".$category_id."' AND reference_type ='Category'";
        $result   = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

    /**
    * Function to get section complete data ie categories under the section and contents under the categories
    * @param type $sectionId
    * @return type array
    */
   public static function getContentDetailsByAlias($alias) {
       $contents = self::getSectionContentByAlias($alias);
       if(!$contents)
          return null;
       else
          return $contents;
   }

    /**
    * Function to get section random data ie categories under the section and contents under the categories
    * @param type $sectionId
    * @return type array
    */
     public static function categoriesRandomDataBySection($sectionId){
         $categories = self::getSectionRandomCategories($sectionId);

         if(!$categories) return null;

         foreach($categories as $key=>$category)
         {
             $contents = self::getCategoryContents($category->category_id);
             if($contents)
             {
                 $categories[$key]->child = $contents;
             }
         }
         return $categories;
     }

     /**
     * Function to get section slider data ie categories under the section and contents under the categories
     * @param type $sectionId
     * @return type array
     */
      public static function categoriesHomeSliderDataBySection($sectionId) {
          $categories = self::getSectionHomeSliderCategories($sectionId);
          if(!$categories) return null;
          foreach($categories as $key=>$category)
          {
              $contents = self::getCategoryContents($category->category_id);
              if($contents)
              {
                  $categories[$key]->child = $contents;
              }
          }
          return $categories;
      }


    /**
     * Function to get section complete data ie categories under the section and contents under the categories
     * @param type $menuId
     * @return type array
     */
    public static function categoriesFullData($categoryId) {
        $category = self::getCategoryData($categoryId);
        if($category){
            $category[0]->child = self::getCategoryContents($categoryId);
        }
        if(!$category) return null;
        else return $category;
    }

     /**
     * Function to get category
     * @param type $menuId
     * @return type array
     */
    public static function getCategoryData($categoryId) {
        $table = 'cms_category';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND category_id='" . $categoryId . "' ";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

     /**
     * Function to get content
     * @param type $contentId
     * @return type array
     */
    public static function getContentData($contentId) {
        $table    = 'cms_content';
        $db       = new Db();
        $fileds   = " * ";
        $where    = " enabled = 'Y' AND content_id='" . $contentId . "' ";
        $result   = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        //echo "SELECT $fileds FROM $table WHERE $where";
        return $result;
    }

    /**
    * Function to get content by alias name
    * @param type $alias
    * @return type array
    */
    public static function getContentDataFromAlias($alias=''){
        $db           = new Db();
        $tablePrefix  = $db->tablePrefix;
        $table        = $tablePrefix.'contents';
        $fileds       = " * ";
        $where        = " `cnt_status` = 'Y' ORDER BY `cnt_order` ASC ";
        $result       = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

    /**
    * Function to get content by alias name
    * @param type $alias
    * @return type array
    */
    public static function getStaticContentsData(){
        $table = 'cms_content';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND content_alias = '" . $alias . "' ";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

    /**
     * Function to get section categories
     * @param type $sectionId
     * @return type array
     */
    public static function getSectionCategories($sectionId) {
        $table = 'cms_category';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND section_id='" . $sectionId . "' ORDER BY category_id ASC";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

    /**
     * Function to get section content
     * @param type $content_alias
     * @return type array
     */
    public static function getSectionContentByAlias($content_alias) {
        $table    = 'cms_content c';
        $db       = new Db();
        $fileds   = " c.*,s.section_alias,s.title as section_title ";
        $where    = " c.enabled = 'Y' AND c.`content_alias` = '".$content_alias."'";
        $join = " LEFT JOIN cms_page_sections s ON s.section_id = c.section_id ";

        $result   = $db->selectQuery("SELECT $fileds FROM $table $join WHERE $where");
        return $result;
    }

    /**
     * Function to get section random categories
     * @param type $sectionId
     * @return type array
     */
    public static function getSectionRandomCategories($sectionId) {
        $table    = 'cms_category';
        $db       = new Db();
        $fileds   = " * ";
        $where    = " enabled = 'Y' AND section_id='".$sectionId."' AND `show_homepage` = '1' ORDER BY `homepage_order` ASC";
        $result   = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

    /**
     * Function to get section homepage slider categories
     * @param type $sectionId
     * @return type array
     */
    public static function getSectionHomeSliderCategories($sectionId) {
        $table    = 'cms_category';
        $db       = new Db();
        $fileds   = " * ";
        $where    = " enabled = 'Y' AND `section_id` ='".$sectionId."' AND `show_homepage` = '1' ORDER BY `homepage_order` ASC";

        $result   = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

     /**
     * Function to get content
     * @param type $contentId
     * @return type array
     */
    public static function getCategoryContents($categoryId) {
        $table = 'cms_content';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND category_id='" . $categoryId . "' ";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

     /**
     * Function to get filename using cms_files alias
     * @param type $contentId
     * @return type array
     */
    public static function getFileId($alias) {
        $table = 'cms_files';
        $db = new Db();
        $fileds = " * ";
        $where = " enabled = 'Y' AND file_alias='" . $alias . "' ";
        $result = $db->selectQuery("SELECT $fileds FROM $table WHERE $where");
        return $result;
    }

}

?>
