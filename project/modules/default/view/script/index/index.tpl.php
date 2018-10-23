<script src="<?php echo ConfigUrl::root()?>public/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo ConfigUrl::root()?>public/js/skel.min.js" type="text/javascript"></script>
<script src="<?php echo ConfigUrl::root()?>public/js/responsiveslides.min.js" type="text/javascript"></script>

      <script>
      // You can also use "$(window).load(function() {"
      $(function () {
        // Slideshow 4
        $("#slider4").responsiveSlides({
        auto: true,
        pager: true,
        nav: true,
        speed: 500,
        namespace: "callbacks",
        before: function () {
          $('.events').append("<li>before event fired.</li>");
        },
        after: function () {
          $('.events').append("<li>after event fired.</li>");
        }
        });

      });

      $(window).on("scroll", function() {
    if($(window).scrollTop() > 50) {
        $(".navbar-fixed-top").addClass("active");
    } else {
        //remove the background property so it comes transparent again (defined in your css)
       $(".navbar-fixed-top").removeClass("active");
    }
});
      </script>
      <script type="text/javascript">

$(function(){
    $("#submit_button").click(function(){
        var someText = $("#inputEmail3").val();
         var salesrep_email = $("#inputEmail3").val();
          var salesrep_password = $("#inputPassword3").val();
        $.post("<?php  echo BASE_URL;?>",{btnLogin:someText,salesrep_email:salesrep_email,salesrep_password:salesrep_password},function(resp){
          //debugger;
            var res = JSON.parse(resp);
            if(res.records !== "success"){
                $('#messagedisplay').show();
                $('#messagedisplay').html(res.records);
                $('#messagedisplay').delay(3000).slideUp(function(){
                $('#messagedisplay').html('');
              });
                //alert("ERROR OCCURED "+resp)
            }else{
              //alert(res.records);
              window.location.href = "<?php echo BASE_URL;?>schools";
            }
        });
    });

     $("#forgot_button").click(function(){
        var someText = $("#inputEmail4").val();
        $.post("<?php  echo BASE_URL;?>",{btnForgot:someText},function(resp){
          //debugger;
            var res = JSON.parse(resp);
            if(res.records !== "success"){
                $('#messagedisplay2').show();
                $('#messagedisplay2').html(res.records);
                $('#messagedisplay2').delay(3000).slideUp(function(){
                $('#messagedisplay2').html('');
              });
                //alert("ERROR OCCURED "+resp)
            }else{
              //alert(res.records);
              //window.location.href = "<?php echo BASE_URL;?>schools";
            }
        });
    });


  $('#inputPassword3').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    $('#submit_button').click();
    return false;
  }
});

    $("#forgotpassword").click(function(){
      $("#loginbox").hide();
      $("#loginlink").show();
      $("#forgotpassword").hide();
      $("#forgotbox").show("slow");
     });

    $("#loginlink").click(function(){
      $("#forgotbox").hide();
      $("#loginlink").hide();
      $("#forgotpassword").show();
      $("#loginbox").show("slow");
     });

});

$(".drop-width").click(function(e){
  e.stopPropagation();
});

</script>
<!--Header -->

<?php
//echopre(PageContext::$response->sliding_banners);
if(trim(PageContext::$response->homepage_slider_enabled) == "true"){ //If footer links are enabled only
    if(is_array(PageContext::$response->sliding_banners) && count(PageContext::$response->sliding_banners)>0){
?>
<div id="myCarousel" class="carousel slide" data-ride="carousel">
<div class="container">
  <div class="button-outer">
     <?php if(trim(PageContext::$response->banner_button1_label) <> "" && trim(PageContext::$response->banner_button1_alias) <> ""){ ?>
     <button type="button" class="btn carousal-get-start-btn" onclick="location.href='<?php echo BASE_URL.trim(PageContext::$response->banner_button1_alias);?>';"><?php echo trim(PageContext::$response->banner_button1_label); ?></button>
     <?php }if(trim(PageContext::$response->banner_button2_label) <> "" && trim(PageContext::$response->banner_button2_alias) <> ""){ ?>
     <button type="button" class="btn carousal-get-start-btn" onclick="location.href='<?php echo BASE_URL.trim(PageContext::$response->banner_button2_alias);?>';"><?php echo trim(PageContext::$response->banner_button2_label); ?></button>
     <?php }if(trim(PageContext::$response->banner_button3_label) <> "" && trim(PageContext::$response->banner_button3_alias) <> ""){ ?>
     <button type="button" class="btn carousal-get-start-btn" onclick="location.href='<?php echo BASE_URL.trim(PageContext::$response->banner_button3_alias);?>';"><?php echo trim(PageContext::$response->banner_button3_label); ?></button>
     <?php } ?>
  </div>
</div>

	  <ol class="carousel-indicators">
      <?php
      $banner_counter = 0;
      foreach(PageContext::$response->sliding_banners as $banner){ ?>
	         <li data-target="#myCarousel" data-slide-to="<?php echo $banner_counter; ?>" <?php if(trim($banner_counter) == 0){ ?>class="active" <?php } ?>></li>
      <?php
          $banner_counter++;
      }
      ?>
	    <!--<li data-target="#myCarousel" data-slide-to="1"></li>
	    <li data-target="#myCarousel" data-slide-to="2"></li>-->
	  </ol>

	  <!-- Wrapper for slides -->
	  <div class="carousel-inner">
      <?php
      $banner_counter = 0;
      foreach(PageContext::$response->sliding_banners as $banner){
          $bimage = $banner['banner_image'];
      ?>
      <div class="item <?php if(trim($banner_counter) == 0){ echo "active"; } ?>">
          <div class="container">
              <div class="carousel-text section">
                  <p class="carousel-text-sm"><?php if(trim($banner["banner_title"]) <> ""){ echo trim($banner["banner_title"]); } ?></p>
                  <p class="carousel-text-bg"><?php if(trim($banner["banner_content"]) <> ""){ echo nl2br(stripslashes($banner["banner_content"])); } ?></p>

              </div>
          </div>
          <div class="mask-banner"></div>
          <img src="<?php echo USER_IMAGE_URL.$bimage; ?>" alt="<?php if(trim($banner["banner_name"]) <> ""){ echo $banner["banner_name"]; } ?>">
      </div>
      <?php
          $banner_counter++;
      }
      ?>
	  </div>

	  <!-- Left and right controls -->
	  <!-- <a class="left carousel-control" href="#myCarousel" data-slide="prev">
	    <span class="glyphicon glyphicon-chevron-left"></span>
	    <span class="sr-only">Previous</span>
	  </a>
	  <a class="right carousel-control" href="#myCarousel" data-slide="next">
	    <span class="glyphicon glyphicon-chevron-right"></span>
	    <span class="sr-only">Next</span>
	  </a> -->
</div>
<?php
    }
}
if(is_array(PageContext::$response->static_contents) && count(PageContext::$response->static_contents) > 0){
    $countr = 0;
    foreach(PageContext::$response->static_contents as $static_content){
      if($countr){
          $padding = " 0px 0px 25px 0px";
      }else{
          $padding = " 25px 0px 10px 0px";
      }

      if(trim($static_content->cnt_button_text) <> "" && trim($static_content->cnt_button_text) <> "-"){
          $homepage_min_height = "328px";
      }else{
          $homepage_min_height = "228px";
      }
?>
<!--  HOME PAGE TEXT BLOCK  -->

<div class="container" style="min-height:<?php echo $homepage_min_height; ?>; padding: <?php echo $padding; ?>;">
	<div class="banner_area text-center">
        <div class="banner_content_container sitewidth">
            <div class="banner_content">
                <h3><?php echo trim($static_content->cnt_title); ?></h3>
                <div class="clear"></div>
                <p><?php echo stripslashes($static_content->cnt_summary); ?></p>
                <?php if(trim($static_content->cnt_button_text) <> "" && trim($static_content->cnt_button_text) <> "-"){  ?>
                <a href="<?php echo BASE_URL."content/".trim($static_content->cnt_alias); ?>" class="btn get-start-btn"><?php echo trim($static_content->cnt_button_text); ?></a>
              <?php } ?>
            </div>
        </div>
    </div>
</div>
<!--  HOME PAGE TEXT BLOCK  -->
<?php
      $countr++;
    }
}

/********************************************** RANDOM SECTION AREA *********************************************/
if(is_array(PageContext::$response->random_homepage_sections) && count(PageContext::$response->random_homepage_sections)>0){
    foreach(PageContext::$response->random_homepage_sections as $random_homepage_section){
        $random_section_data      = $random_homepage_section->data[0];
        $arrRandomCategories      = $random_homepage_section->data[0]->child;
        $arrRandomValidCategories = array();

        if(count($arrRandomCategories) > 0){
            foreach($arrRandomCategories as $randomKey => $randomCategory){
                if(array_key_exists("child",$randomCategory)){
                    $arrRandomValidCategories[] = $randomCategory;
                }
            }
        }
        if(count($arrRandomValidCategories) > 0){
?>
<div class="container-fluid grey-bg">
    <div class="container Service-section" style="padding-top:20px; padding-bottom:44px;">  <!--style="padding-top:40px; padding-bottom:74px;"-->
	    <div class="section_title text-center">
	    	<?php if(trim($random_section_data->title) <> ""){ ?><h3><?php echo "Our ".ucfirst($random_section_data->title); ?></h3><?php } ?>
	    	<?php if(trim($random_section_data->description) <> ""){ ?><p><?php echo stripslashes($random_section_data->description); ?></p><?php } ?>
	    </div>
	  <div class="row">
      <?php
      for($counter = 0;$counter < count($arrRandomValidCategories);$counter++){
          $data_content   = array();
          $data_content   = $arrRandomValidCategories[$counter]->child[0];  //echopre($data_content);
          $section_image  = Cmshelper::getImageContent($data_content->icon_1);
          if(trim($section_image) <> "" && file_exists("./project/files/".$section_image)){
              $section_image = USER_IMAGE_URL.$section_image;
          }else{
              $section_image = USER_IMAGE_URL."no_image.jpg";
          }
      ?>
	    <div class="col-sm-6 col-md-4">
        <div class="service_box">
    			<div class="icon text-center">
            <a href="<?php echo BASE_URL.trim($random_section_data->section_alias)."_details/".trim($data_content->content_alias); ?>">
              <img src="<?php echo $section_image; ?>" alt="<?php echo trim($random_section_data->title); ?>Image" class="img-responsive">
            </a>
    			</div>
    			<div class="full-width">
    				<?php if(trim($data_content->title) <> ""){ ?>
              <h5>
                <a href="<?php echo BASE_URL.trim($random_section_data->section_alias)."_details/".trim($data_content->content_alias); ?>">
                  <?php echo trim($data_content->title); ?>
                </a>
              </h5>
            <?php } ?>
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
	    </div>
      <?php
          }
      ?>
      <div class="clear"></div>
      <div style="text-align:center;">
        <a href="<?php echo BASE_URL.trim($random_section_data->section_alias); ?>" class="btn get-start-btn"><?php echo "View All ".trim($random_section_data->title); ?></a>
      </div>
	  </div>
	</div>
</div>
<?php
    }
  }
}
/********************************************** RANDOM SECTION AREA *********************************************/

/********************************************** SLIDER SECTION AREA *********************************************/
if(is_array(PageContext::$response->slider_homepage_sections) && count(PageContext::$response->slider_homepage_sections)>0){
    foreach(PageContext::$response->slider_homepage_sections as $slider_homepage_section_key => $slider_homepage_section){

      $slider_section_data      = $slider_homepage_section->data[0];
      $arrSliderCategories      = $slider_homepage_section->data[0]->child;
      //echopre($slider_section_data);
      $arrSliderValidCategories = array();

      if(count($arrSliderCategories) > 0){
          foreach($arrSliderCategories as $sliderKey => $sliderCategory){
              if(array_key_exists("child",$sliderCategory)){
                  $arrSliderValidCategories[] = $sliderCategory;
              }
          }
      }
      //echopre($arrSliderValidCategories);

      if(count($arrSliderValidCategories) > 0){
?>
<div class="container white-bg slideshow-container" style="padding-top: 42px; padding-bottom: 68px;">
          <div class="section_title text-center">
            <?php if(trim($slider_section_data->title) <> ""){ ?><h3><?php echo "Featured ".ucfirst($slider_section_data->title); ?></h3><?php } ?>
            <div class="featured_products">
                <a class="prev" onclick="plusSlides_<?php echo $slider_homepage_section_key; ?>(-1)">Prev</a>
                <a class="next" onclick="plusSlides_<?php echo $slider_homepage_section_key; ?>(1)">Next</a>
            </div>
          </div>
          <div class="clear"></div>
          <?php
              for($counter = 0,$flow_cnt = 0;$counter < count($arrSliderValidCategories);$counter++,$flow_cnt++){
                $data_content   = array();
                $data_content   = $arrSliderValidCategories[$counter]->child[0];  //echopre($data_content);
                $section_image  = Cmshelper::getImageContent($data_content->icon_1);
                if(trim($section_image) <> "" && file_exists("./project/files/".$section_image)){
                    $section_image = USER_IMAGE_URL.$section_image;
                }else{
                    $section_image = USER_IMAGE_URL."no_image.jpg";
                }
                if($flow_cnt == 3){
                    $flow_cnt = 0;
                    echo '</div></div>';
                }
                if($flow_cnt == 0){
          ?>
          <div class="mySlides_<?php echo $slider_homepage_section_key; ?>">
              <div class="row">
          <?php } ?>

          <div class="col-xs-4 col-sm-4 col-md-4">
            <a href="<?php echo BASE_URL.trim($slider_section_data->section_alias)."_details/".trim($data_content->content_alias); ?>" class="box_service tp-box-num" style="background-image: url('<?php echo $section_image; ?>');">
                <div class="clear"></div>
            </a>
                <div class="content text-center">
                   <?php if(trim($data_content->title) <> ""){ ?>
                      <h5>
                        <a href="<?php echo BASE_URL.trim($slider_section_data->section_alias)."_details/".trim($data_content->content_alias); ?>">
                          <?php echo trim($data_content->title); ?>
                        </a>
                      </h5>
                    <?php } ?>
                </div>
          </div>
          <?php
              }
          ?>
        </div>
      </div>
      <div style="text-align:center;">
          <a href="<?php echo BASE_URL.trim($slider_section_data->section_alias); ?>" class="btn get-start-btn"><?php echo "View All ".trim($slider_section_data->title); ?></a>
      </div>
</div>
<?php
    }
  }
}

if(PageContext::$response->testimonial_enabled == "true"){
    if(is_array(PageContext::$response->testimonials) && count(PageContext::$response->testimonials)>0){
?>
<div class="testimnial-bg" style="min-height:525px;">
<div class="mask-testimonials">
  <div class="container-fluid">
    <div>
        <h3>Testimonials</h3>
        <div class="seprator"></div>
            <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
              <!-- Wrapper for slides -->
              <div class="carousel-inner">
                <?php
                  $cntr = 0;
                  foreach (PageContext::$response->testimonials as $testimonial){
                      $testimonial_image  = "";
                      $testi_image        = $testimonial->testi_image;
                      if(trim($testi_image) <> "" && file_exists("./project/files/".$testi_image)){
                          $testimonial_image = USER_IMAGE_URL.$testi_image;
                      }else{
                          $testimonial_image = USER_IMAGE_URL."no_image.jpg";
                      }
                  ?>
                <div class="item <?php if(trim($cntr) == 0){ echo "active"; } ?>">
                      <div class="carousel-wrap">
                          <div class="test-pic">
                              <img src="<?php echo trim($testimonial_image); ?>" width="100" height="100" class="img-circle"/>
                          </div>
                          <div class="test-txt">
                          <ul id="testimonial-list" class="clearfix">
                            <i class="fontawesome-icon  fa fa-quote-left circle-no" style="font-size:32px;margin-right:21px;color:#ffffff;"></i>
                            <?php if(trim($testimonial->testi_desc) <> ""){ echo stripslashes($testimonial->testi_desc)."<br><br>"; } ?>
                      <span class="test-name"><?php if(trim($testimonial->testi_name) <> ""){ echo trim($testimonial->testi_name); }
                      if(trim($testimonial->testi_location) <> ""){ echo ",&nbsp;".trim($testimonial->testi_location); } ?></span>
                          </ul>
                      </div>
                      </div>
                </div>
              <?php
                $cntr++;
              }
              ?>
              <!-- <div class="item">
                    <div class="carousel-wrap">
                          <div class="test-pic"><img src="img/user2.jpg"  width="100" height="100" class="img-circle"/></div>
                          <div class="test-txt">
                          <ul id="testimonial-list" class="clearfix">
                            <i class="fontawesome-icon  fa fa-quote-left circle-no" style="font-size:32px;margin-right:21px;color:#ffffff;"></i>
                            Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium,  totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.
                      Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui
                      ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci.<br><br>
                      <span class="test-name">Helen Maria, USA</span>
                          </ul>
                          </div>
                    </div>
              </div> -->
              </div>
            <div class="controls testimonial_control">
                <a class="left fa fa-chevron-left btn test-nav-btn testimonial_btn" href="#carousel-example-generic" data-slide="prev"></a>
                <a class="right fa fa-chevron-right btn test-nav-btn testimonial_btn" href="#carousel-example-generic" data-slide="next"></a>
            </div>
            </div>
            </div>
          </div>
        </div>
      </div>
<?php
    }
}
?>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>-->

<script>
<?php
if(is_array(PageContext::$response->slider_homepage_sections) && count(PageContext::$response->slider_homepage_sections)>0){
    foreach(PageContext::$response->slider_homepage_sections as $slider_homepage_section_key => $slider_homepage_section){
?>
var slideIndex = 1;
showSlides_<?php echo $slider_homepage_section_key; ?>(slideIndex);

function currentSlide_<?php echo $slider_homepage_section_key; ?>(n) {
  showSlides_<?php echo $slider_homepage_section_key; ?>(slideIndex = n);
}

function plusSlides_<?php echo $slider_homepage_section_key; ?>(n) {
  showSlides_<?php echo $slider_homepage_section_key; ?>(slideIndex += n);
}

function showSlides_<?php echo $slider_homepage_section_key; ?>(n) {
    var i;
    var slides = document.getElementsByClassName("mySlides_<?php echo $slider_homepage_section_key; ?>");
    //
    if (n > slides.length) {slideIndex = 1}
    if (n < 1) {slideIndex = slides.length}
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex-1].style.display = "block";
    /*var dots = document.getElementsByClassName("dot");
    for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
    }
    dots[slideIndex-1].className += " active"; */
}
<?php
    }
}
?>
</script>
