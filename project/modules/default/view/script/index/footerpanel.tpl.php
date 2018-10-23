<script type="text/javascript">
function validateEmail(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function answer(e) {
    if (e.keyCode == 13) {
      e.preventDefault();

      var subscribe_email = $('#subscribe_email').val();
      $("#validation_foot_message").removeClass("subscribe_success");
      $("#validation_foot_message").removeClass("subscribe_error");

      if(subscribe_email != ""){
         if(!validateEmail(subscribe_email)){
             $("#subscribe_email").val("");
             $("#subscribe_email").focus();
             $(".input-container").addClass("subscribeborder");
             $("#validation_foot_message").show();
             $("#validation_foot_message").html('Kindly fill a valid email address!');
             return false;
         }else{
           $(".input-container").removeClass("subscribeborder");
         }
      }else{
          $("#subscribe_email").focus();
          $(".input-container").addClass("subscribeborder");
          $("#validation_foot_message").show();
          $("#validation_foot_message").addClass("subscribe_error");
          $("#validation_foot_message").html('Kindly fill any email address!');
          return false;
      }
      var data = 'subscribe_email='+subscribe_email;
      $.ajax({
          url: MAIN_URL+"subscribe_email",
          type: "POST",
          data: data,
          cache: false,
          dataType  : 'json',
          success: function(retdata){
              $("#subscribe_email").val("");
              $("#subscribe_email").focus();
              $("#validation_foot_message").show();
              $("#validation_foot_message").addClass(retdata.msgclass);
              $("#validation_foot_message").html(retdata.message);
          }
      });

     }
}

function validate_subscription(){
    var subscribe_email = $('#subscribe_email').val();
    $("#validation_foot_message").removeClass("subscribe_success");
    $("#validation_foot_message").removeClass("subscribe_error");

    if(subscribe_email != ""){
       if(!validateEmail(subscribe_email)){
           $("#subscribe_email").val("");
           $("#subscribe_email").focus();
           $(".input-container").addClass("subscribeborder");
           $("#validation_foot_message").show();
           $("#validation_foot_message").html('Kindly fill a valid email address!');
           return false;
       }else{
         $(".input-container").removeClass("subscribeborder");
       }
    }else{
        $("#subscribe_email").focus();
        $(".input-container").addClass("subscribeborder");
        $("#validation_foot_message").show();
        $("#validation_foot_message").addClass("subscribe_error");
        $("#validation_foot_message").html('Kindly fill any email address!');
        return false;
    }
    var data = 'subscribe_email='+subscribe_email;
    $.ajax({
        url: MAIN_URL+"subscribe_email",
        type: "POST",
        data: data,
        cache: false,
        dataType  : 'json',
        success: function(retdata){
            $("#subscribe_email").val("");
            $("#subscribe_email").focus();
            $("#validation_foot_message").show();
            $("#validation_foot_message").addClass(retdata.msgclass);
            $("#validation_foot_message").html(retdata.message);
        }
    });
}
</script>

<!-- Footer -->
<section class="section-padding footer bg-grey">
         <div class="container">
            <div class="row">
               <div class="col-sm-6 col-lg-4 col-md-4 footer-stl">
                  <h4 class="mb-5">
                    <?php
                    if(PageContext::$response->companylogo <> ''){
                        /*<img src="<?php echo BASE_URL;?>project/img/logo.png">*/
                        echo PageContext::$response->companylogo;
                    }else{
                    ?>
                    <img src="<?php echo PageContext::$response->companyDefaultLogo;?>">
                    <?php } ?>
                  </h4>
                  <!--<p>Rex K. Caldwell<br>4162 James Street, Wellsville, NY 14895</p>-->
                  <?php if(trim(PageContext::$response->site_address) <> ""){ echo '<p>'.nl2br(stripslashes(PageContext::$response->site_address)).'</p>'; } ?>
                    <p class="phne">
                        <?php
                        if(trim(PageContext::$response->site_phone) <> ""){ ?>
                        <a class="text-dark" href="#"><i class="fas fa-phone contact-icon"></i><?php echo trim(PageContext::$response->site_phone); ?></a>
                        <?php
                        }
                        if(trim(PageContext::$response->site_phone) <> "" && trim(PageContext::$response->site_email) <> ""){
                            //echo "&nbsp;|&nbsp;";
                            echo "<br/>";
                        }
                        if(trim(PageContext::$response->site_email) <> ""){
                        ?>
                        <a class="text-success" href="mailto:<?php echo trim(PageContext::$response->site_email); ?>"><i class="fas fa-envelope contact-icon"></i>
                          <?php echo trim(PageContext::$response->site_email); ?>
                        </a>
                      <?php } ?>
                  </p>
               </div>
                <?php
                if(trim(PageContext::$response->footer_links_enabled) == "true"){ //If footer links are enabled only
                    if(is_array(PageContext::$response->bottomMenuItems) && count(PageContext::$response->bottomMenuItems)>0){
                        $bottom_menu_counter = 0;
                        foreach(PageContext::$response->bottomMenuItems as $bottomMenuItem){
                            if(trim($bottom_menu_counter) == 0){
                                echo '<div class="col-sm-6 col-lg-2 col-md-2 footer-stl">
                                        <h6 class="mb-4">QUICK LINKS</h6>
                                            <ul>';
                            }
                            if(trim($bottom_menu_counter) == ceil(count(PageContext::$response->bottomMenuItems)/2)){
                                echo '</ul>
                                </div>
                                <div class="col-sm-6 col-lg-2 col-md-2 footer-stl footer-stl-p">
                                    <h6 class="mb-4">LEARN MORE</h6>
                                        <ul>';
                            }
                            if(trim($bottomMenuItem->menu_item_alias) == "home"){
                                  $bottomMenuItem->menu_item_alias = "";
                            }
                            ?>
                            <li><a href="<?php echo BASE_URL.$bottomMenuItem->menu_item_alias; ?>" class="<?php if(trim($bottomMenuItem->menu_item_alias) == ""){ echo "home"; }else{ echo $bottomMenuItem->menu_item_alias; } ?>"><?php echo $bottomMenuItem->title; ?></a></li>
                            <?php
                            $bottom_menu_counter++;
                        }
                        echo '</ul></div>';
                    }else{
                        echo '<div class="col-sm-6 col-lg-2 col-md-2 footer-stl">&nbsp;</div>';
                        echo '<div class="col-sm-6 col-lg-2 col-md-2 footer-stl footer-stl-p">&nbsp;</div>';
                    }
                }else{
                    echo '<div class="col-sm-6 col-lg-2 col-md-2 footer-stl">&nbsp;</div>';
                    echo '<div class="col-sm-6 col-lg-2 col-md-2 footer-stl footer-stl-p">&nbsp;</div>';
                }
                ?>
                <?php /* <div class="col-sm-6 col-lg-2 col-md-2 footer-stl">
                  <h6 class="mb-4">QUICK LINKS</h6>
                  <ul>
                    <li><a href="<?php  echo BASE_URL;?>">Home</a></li>
                    <li><a href="<?php  echo BASE_URL;?>about">About</a></li>
                    <li><a href="<?php  echo BASE_URL;?>contact">Contact</a></li>
                  </ul>
                </div>
               <div class="col-sm-6 col-lg-2 col-md-2 footer-stl footer-stl-p">
                  <h6 class="mb-4">LEARN MORE</h6>
                  <ul>
                    <li><a href="<?php  echo BASE_URL;?>services">Services</a></li>
                    <li><a href="<?php  echo BASE_URL;?>terms-of-service">Terms &amp; Conditions</a></li>
                    <li><a href="<?php  echo BASE_URL;?>privacy">Privacy policy</a></li>
                  <ul>
               </div> */ ?>
               <div class="col-sm-6 col-lg-4 col-md-4 footer-stl">
                  <div class="input-container" id="emailsubscribediv">
                     <form id="subscription-form" name="subscription-form" role="form" method="post">
                     <input type="textbox" name="subscribe_email" id="subscribe_email" class="form-control-n" placeholder="Email Address..." aria-label="Recipient's username" aria-describedby="basic-addon2" autocomplete="off" onkeydown="return answer(event)">
                     <button type="button" name="btnSubscription" id="subscription" class="btn email-submit-btn" onclick="validate_subscription();"><i class="fas fa-arrow-right"></i></button>
                     </form>
                  </div>

                  <span id='bottom'></span>
                  <div id="validation_foot_message" class="subscribe_error"></div>
                  <?php if(trim(PageContext::$response->subscribe_succ_msg) <> ""){ ?>
                  <div class="subscribe_success"><?php echo trim(PageContext::$response->subscribe_succ_msg); ?></div>
                  <?php }if(trim(PageContext::$response->subscribe_error_msg) <> ""){ ?>
                  <div class="subscribe_error"><?php echo trim(PageContext::$response->subscribe_error_msg); ?></div>
                  <?php } ?>

                  <?php
                  if(trim(PageContext::$response->social_media_enabled) == "true"){ //If footer links are enabled only
                      if(trim(PageContext::$response->facebook_url) <> "" ||
                          trim(PageContext::$response->twitter_url) <> "" ||
                          trim(PageContext::$response->instagram_url) <> "" ||
                          trim(PageContext::$response->googleplus_url)){
                          ?>
                        <h6 class="mb-4 mt-5">GET IN TOUCH</h6>
                        <div class="footer-social">
                           <?php if(trim(PageContext::$response->facebook_url) <> ""){ ?>
                           <a href="<?php echo trim(PageContext::$response->facebook_url); ?>"><i class="fab fa-facebook-f"></i></a>
                           <?php }if(trim(PageContext::$response->twitter_url) <> ""){ ?>
                           <a href="<?php echo trim(PageContext::$response->twitter_url); ?>"><i class="fab fa-twitter"></i></a>
                           <?php }if(trim(PageContext::$response->instagram_url) <> ""){ ?>
                           <a href="<?php echo trim(PageContext::$response->instagram_url); ?>"><i class="fab fa-instagram"></i></a>
                           <?php }if(trim(PageContext::$response->googleplus_url) <> ""){ ?>
                           <a href="<?php echo trim(PageContext::$response->googleplus_url); ?>"><i class="fab fa-google-plus-g"></i></a>
                           <?php } ?>
                        </div>
                        <?php
                      }else{
                      ?>
                      <div class="footer-social">&nbsp;</div>
                      <?php
                      }
                  }else{
                  ?>
                  <div class="footer-social">&nbsp;</div>
                  <?php
                  }
                  ?>
               </div>
            </div>
         </div>
      </section>
                <div class="dark-bg copy-outer">
                <div class="container">
                  <div class="row">
                    <div class="copy-text">
                        <?php echo PageContext::$response->site_copyright; ?>
                    </div>
                  </div>
                </div>
                </div>

<?php  $page = $_SERVER['REQUEST_URI'];
          $arrs = explode('/', $page);
                $pagename = $arrs[2];
?>
<input type="hidden" id="pagename" value="<?php echo $pagename;?>"/>
<script>
//$( document ).ready(function() {
var pagename = $('#pagename').val();
if(pagename == 'about'){
  $('.about').addClass('active');
}
if(pagename == ''){
  $('.home').addClass('active');
}
if(pagename == 'contact'){
  $('.contact').addClass('active');
}
if(pagename == 'services'){
  $('.services').addClass('active');
}
if(pagename == 'products'){
  $('.products').addClass('active');
}
if(pagename == 'terms-of-service'){
  $('.terms-of-service').addClass('active');
}
if(pagename == 'privacy-policy'){
  $('.privacy-policy').addClass('active');
}
//});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
