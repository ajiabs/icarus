<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>
<section class="banner_b">
<div class="container">
    <div class="row">
        <div class="col-md-5">
            <span class="bannerillustration_b">
                <img src="{php} echo IMAGE_MAIN_URL; {/php}QR_banner_illustration.png">
            </span>
        </div>
        <div class="col-md-6 col-md-offset-1">
            <p>
                BHIM(Bharat Interface for Money) is a government of India project launched by Prime
                Minister Narendra Modi. Crores of Indians are using BHIM to pay for products and services
                everyday.
                <br/>

                We will help you to accept payment from BHIM users from your clients. Accepting payment
                from your clients using bhim app is easy. Just enter your bank info here to print the QR
                sticker. Display it in your shop or taxi. When your client scans and enters the amount, it
                reaches your bank account in minutes. There is no transaction fee or commission like paytm.
                Keep all your hard earned money. It is FREE to use.
            </p>
        </div>
    </div>
</div>
</section>
<section class="stepssection">
    <div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2><span>Steps to get paid using</span> <img src="{php} echo IMAGE_MAIN_URL; {/php}bhimstepslogo.jpg"></h2>
        </div>
        <div class="clearfix"></div>
        <div class="stepsflow">
            <div class="col-md-3">
                <img src="{php} echo IMAGE_MAIN_URL; {/php}step1.jpg">
                <h4>Register to bhim.io</h4>
            </div>
            <div class="col-md-3">
                <img src="{php} echo IMAGE_MAIN_URL; {/php}step2.jpg">
                <h4>Provide your VPA</h4>
            </div>
            <div class="col-md-3">
                <img src="{php} echo IMAGE_MAIN_URL; {/php}step3.jpg">
                <h4>Print your QR code</h4>
            </div>
            <div class="col-md-3">
                <img src="{php} echo IMAGE_MAIN_URL; {/php}step4.jpg">
                <h4>Get paid</h4>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    </div>
</section>
<script>
    $(function ()
    { 
      url = window.location.href;
      url = url.substr(url.lastIndexOf('/') + 1); //alert(url)
      
      if(url == "#signup")
        $("#myTab a:last").tab('show');
    
        $(".jqpoptooltip").popover();
      
    
    });


</script>
 <!-- jQuery Version 1.11.0 -->
     

