<?php
$content_data = PageContext::$response->content[0];
$section_image  = Cmshelper::getImageContent($content_data->icon_1);
if(trim($section_image) <> "" && file_exists("./project/files/".$section_image)){
    $section_image = USER_IMAGE_URL.$section_image;
}else{
    $section_image = USER_IMAGE_URL."no_image.jpg";
}
?>
<div class="container container-div main_content_outer">
    <section class="countact-us-section">
        <div class="content_pannel">
            <div class="inner_contentarea">
                <div class="staticpage_content">
                    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
      <?php if(trim($content_data->section_title) <> ""){ ?>
      <li class="breadcrumb-item"><a href="<?php echo BASE_URL.trim($content_data->section_alias);?>"><?php echo trim($content_data->section_title); ?></a></li>
      <?php } ?>
      <li class="breadcrumb-item active">&nbsp;<?php  echo PageContext::$response->content[0]->title; ?></li>
  </ol>
                <?php if(trim($content_data->section_title) <> ""){ ?><h3><?php echo $content_data->section_title; ?></h3><?php } ?>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="listing_content_outer_listing">
                                <div class="listing_content_outer_details">
                                    <img src="<?php echo $section_image;?>" alt="<?php echo $content_data->title; ?>Image" class="img-responsive">
                                </div>
                                <?php if(trim($content_data->title) <> ""){ ?><h1><?php echo $content_data->title; ?></h1><?php } ?>
                                <?php if(trim($content_data->	description) <> ""){ ?><p><?php echo stripslashes($content_data->	description); ?></p><?php } ?>
                                <!--<div class="new-full-width text-center">
                                <a href="#" class="btn get-start-btn">View details</a>
                                </div>-->
                                </div>
                        </div>
                    </div>
                </div>
                </div>
                <div class="clear"></div>
              </div>
    </section>
</div>
