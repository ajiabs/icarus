
<?php
$section_data     = PageContext::$response->content[0];
$arrCategories    = PageContext::$response->content[0]->child;
if(count($arrCategories) > 0){
    foreach($arrCategories as $catKey => $categoryValue){
        if(array_key_exists("child",$categoryValue)){
            $arrValidCategories[] = $categoryValue;
        }
    }
}
//echopre($arrValidCategories);
$arrCategoryKeys  = array_keys($arrValidCategories);

if(trim($section_data) == "nodata"){ //If no section data exists
?>
<div class="container container-div main_content_outer">
    <section class="countact-us-section">
        <div class="content_pannel">
            <div class="inner_contentarea">
                <div class="staticpage_content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
                        <li class="breadcrumb-item active">&nbsp;<?php  echo ucfirst(PageContext::$response->activeMenu); ?></li>
                    </ol>
                    <?php if(trim($section_data->title) <> ""){ ?><h3><?php echo $section_data->title; ?></h3><?php } ?>
                    <?php if(trim($section_data->description) <> ""){ ?>
                      <p><?php echo $section_data->description; ?></p>
                      <div class="clear">&nbsp;</div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><strong><?php echo "No data found!"; ?></strong></div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </section>
</div>
<?php
}

if(trim($section_data->viewtype) == "grid"){ //If view type is grid format
?>
<div class="container container-div main_content_outer">
    <section class="countact-us-section">
        <div class="content_pannel">
            <div class="inner_contentarea">
                <div class="staticpage_content">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
                        <li class="breadcrumb-item active">&nbsp;<?php  echo PageContext::$response->content[0]->title; ?></li>
                    </ol>
                    <?php if(trim($section_data->title) <> ""){ ?><h3><?php echo $section_data->title; ?></h3><?php } ?>
                    <?php if(trim($section_data->description) <> ""){ ?>
                      <p><?php echo $section_data->description; ?></p>
                      <div class="clear">&nbsp;</div>
                    <?php } ?>
                    <div class="row">
                        <?php                        
                        if(count($arrValidCategories) > 0){                          
                            for($counter = PageContext::$response->pageStart;$counter < PageContext::$response->pageEnd;$counter++){
                                $section_image = "";
                                if(is_array($arrValidCategories) && count($arrValidCategories)>0 && in_array($counter,$arrCategoryKeys)){
                                  $data_content   = array();
                                  $data_content   = $arrValidCategories[$counter]->child[0];  //echopre($data_content);
                                  $section_image  = Cmshelper::getImageContent($data_content->icon_1);
                                  if(trim($section_image) <> "" && file_exists("./project/files/".$section_image)){
                                      $section_image = USER_IMAGE_URL.$section_image;
                                  }else{
                                      $section_image = USER_IMAGE_URL."no_image.jpg";
                                  }
                                  if(trim($arrValidCategories[$counter]->target_type) <> ""){
                                      $target_type = trim($arrValidCategories[$counter]->target_type);
                                  }else{
                                      $target_type = "_self";
                                  }
                        ?>
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="listing_content_outer">
                                <div class="listing_content_img_outer">
                                    <a href="<?php echo BASE_URL.trim($section_data->section_alias)."_details/".trim($data_content->content_alias); ?>" target="<?php echo $target_type; ?>">
                                      <img src="<?php echo $section_image; ?>" alt="<?php echo trim($section_data->title); ?>Image" class="img-responsive">
                                    </a>
                                </div>
                                <?php if(trim($data_content->title) <> ""){ ?><h1><a href="<?php echo BASE_URL.trim($section_data->section_alias)."_details/".trim($data_content->content_alias); ?>" target="<?php echo $target_type; ?>"><?php echo trim($data_content->title); ?></a><h1><?php } ?>
                                <?php if(trim($data_content->summary) <> ""){ ?>
                                  <p>
                                    <?php
                                    echo substr(trim($data_content->summary), 0, 150);
                                    if(strlen(trim($data_content->summary)) > 150){
                                        echo "...";
                                    }
                                    ?>
                                  </p>
                                <?php } ?>
                            </div>
                        </div>
                        <?php
                            }
                          }
                        }else{
                        ?>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><strong><?php echo "No data found!"; ?></strong></div>
                        <?php
                        }
                        ?>
                        <div class="col-xs-12">
                            <div class="pagenation">
                                <?php echo PageContext::$response->pagination; ?>
                            <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </section>
</div>
<?php }else if(trim($section_data->viewtype) == "list"){ ?>
<div class="container container-div main_content_outer">
  <section class="countact-us-section">
      <div class="content_pannel">
        <div class="inner_contentarea">
            <div class="staticpage_content">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
                    <li class="breadcrumb-item active">&nbsp;<?php  echo PageContext::$response->content[0]->title; ?></li>
                </ol>
                <h3><?php if(trim($section_data->title) <> ""){ echo $section_data->title; } ?></h3>
                <div class="row">
                <?php
                if(count($arrValidCategories) > 0){
                    for($counter = PageContext::$response->pageStart;$counter < PageContext::$response->pageEnd;$counter++){
                        $section_image = "";
                        if(is_array($arrValidCategories) && count($arrValidCategories)>0 && in_array($counter,$arrCategoryKeys)){
                          $data_content   = array();
                          $data_content   = $arrValidCategories[$counter]->child[0];  //echopre($data_content);
                          $section_image  = Cmshelper::getImageContent($data_content->icon_1);
                          if(trim($section_image) <> "" && file_exists("./project/files/".$section_image)){
                              $section_image = USER_IMAGE_URL.$section_image;
                          }else{
                              $section_image = USER_IMAGE_URL."no_image.jpg";
                          }
                          if(trim($arrValidCategories[$counter]->target_type) <> ""){
                              $target_type = trim($arrValidCategories[$counter]->target_type);
                          }else{
                              $target_type = "_self";
                          }
                ?>
                  <div class="col-md-12">
                      <div class="listing_content_outer_listing">
                          <div class="listing_content_img_outer_listing">
                              <a href="<?php echo BASE_URL.trim($section_data->section_alias)."_details/".trim($data_content->content_alias); ?>" target="<?php echo $target_type; ?>">
                                <img src="<?php echo $section_image; ?>" alt="<?php echo trim($section_data->title); ?>Image" class="img-responsive">
                              </a>
                          </div>
                          <h1><?php if(trim($data_content->title) <> ""){ echo trim($data_content->title); } ?></h1>
                          <p><?php if(trim($data_content->summary) <> ""){ echo trim($data_content->summary); } ?></p>
                          <div class="new-full-width">
                          <a href="<?php echo BASE_URL.trim($section_data->section_alias)."_details/".trim($data_content->content_alias); ?>" class="btn get-start-btn" target="<?php echo $target_type; ?>">View details</a>
                      </div>
                      </div>
                  </div>
                  <?php
                      }
                    }
                  }else{
                  ?>
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><strong><?php echo "No data found!"; ?></strong></div>
                  <?php
                  }
                  ?>
                  <div class="col-xs-12">
                      <div class="pagenation">
                          <?php echo PageContext::$response->pagination; ?>
                      <div class="clearfix"></div>
                      </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="clear"></div>
            </div>
        </section>
</div>
<?php } ?>
