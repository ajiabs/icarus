<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/html2canvas.js"></script>
<script src="{php} echo BASE_URL; {/php}project/js/jquery.blockUI.js"></script>

<div class="container min-ht550">
    
    <h3 class="bhimqr marg_bot_15px"><span>Generate Your QR Code</span></h3>
    
    <div class="clearfix"></div>
    {PageContext::$response->message}
    <div class="generateqr_form">
    <div class="row" id="html-content-holder">
            <div class="col-md-6 col-md-offset-3">
                <div class="printpreview_img">
                    <img src="{php} echo IMAGE_MAIN_URL; {/php}bhimlogoprint.png">
                </div>
                <div class="printpreview_username">
                    <div class="pay_to">To Pay</div>
                    <label>{PageContext::$response->user_fname} {PageContext::$response->user_lname}</label>
                </div>
                <div class="generated_qr">Scan this <b>bhim.io</b> code</div>
                <div class="clearfix"></div>
                <div class="preview_QR">
                    <img src="{php} echo BASE_URL;{/php}project/lib/phpqrcode/temp/{PageContext::$response->qrcode_bigimage}">
                </div>
                <div class="generated_qr">Generated with <b>bhim.io</b></div>
            </div>
    </div>
    <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
    <div class="col-md-2"><a class="backlink pull-left" href="{php} echo BASE_URL;{/php}user"><i class="fa fa-arrow-left" aria-hidden="true"></i> BACK</a><div class="clearfix"></div></div>
    <div class="col-md-10">
        <div class="dashboard_actions marg_bot_15px pull-right">
             <button name="btnRegister" id="btnRegister" type="submit" class="btn btn-secondary marg10px_top_bottom" data-toggle="modal" data-target="#myModalRequestSticker">REQUEST STICKER <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
            <button name="btnRegister" id="btnRegister" onclick="printsticker()" class="btn btn-secondary marg10px_top_bottom">PRINT STICKER <i class="fa fa-print" aria-hidden="true"></i></button>
            <a id="btn-Convert-Html2Image" href="javascript:void(0)"><button name="btnRegister" id="btnRegister" type="submit" class="btn btn-default marg10px_top_bottom">DOWNLOAD STICKER <i class="fa fa fa-download" aria-hidden="true"></i></button></a>
            <a style="display:none;" id="btn-Convert-Html2ImageTemp" href="#"><button name="btnRegister" id="btnRegister" type="submit" class="btn btn-default marg10px_top_bottom">DOWNLOAD STICKER <i class="fa fa fa-download" aria-hidden="true"></i></button></a>
        </div>
        <div class="clearfix"></div>
    </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" id="myModalRequestSticker" style="z-index:1050 !important;">
    <form class="" method="post" id="frmrequeststicker" name="frmrequeststicker" novalidate="novalidate" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header pad_bot0">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times" aria-hidden="true"></i></button>
        <h3 class="bhimqr" id="gridSystemModalLabel"><span>QR Code Request</span></h3>
        
      </div>
      <div class="modal-body">
        <div class="alert alert-warning" role="alert">The QR code will be delivered within 3-4 business days</div>
        <div class="row marg10px_bottom">
          <div class="col-md-4">Customer Name</div>
          <div class="col-md-8">
              <input value="{PageContext::$response->user_fname} {PageContext::$response->user_lname}" type="text" class="form-control {literal} {validate:{required:true, messages:{required:'Please enter your name'}}} {/literal}" id="user_name" name="user_name" placeholder="First Name*" >
          </div>
        </div>
        
          <div class="row marg10px_bottom">
          <div class="col-md-4">Shop Name</div>
          <div class="col-md-8">
              <input value="{PageContext::$response->shop_name}" type="text" class="form-control" id="user_name" name="shop_name" placeholder="Shop Name" >
          </div>
        </div>
          
          <div class="row marg10px_bottom">
          <div class="col-md-4">Email</div>
          <div class="col-md-8">
              <input value="{PageContext::$response->user_email}" type="text" class="form-control {literal} {validate:{required:true,email:true, messages:{required:'Please enter your email',email:'Please enter a valid email',}}} {/literal}" id="user_email" name="user_email" placeholder="Email*" >
          </div>
        </div>
          <div class="row marg10px_bottom">
          <div class="col-md-4">Mobile</div>
          <div class="col-md-8">
              <input value="{PageContext::$response->user_phone}" type="text" class="form-control {literal} {validate:{required:true,number:true, messages:{required:'Please enter your mobile number',number:'Please enter valid mobile number'}}} {/literal}" id="user_phone" name="user_phone" placeholder="Mobile*" >
          </div>
        </div>
          <div class="row marg10px_bottom">
          <div class="col-md-4">Address</div>
          <div class="col-md-8">
              <textarea class="form-control {literal} {validate:{required:true, messages:{required:'Please enter your address'}}} {/literal}" id="address" name="address" placeholder="Address*" >{PageContext::$response->address}</textarea>
          </div>
        </div>
          <div class="row marg10px_bottom">
          <div class="col-md-4">Pin-code</div>
          <div class="col-md-8">
              <input value="{PageContext::$response->pin_code}" type="text" class="form-control {literal} {validate:{required:true,number:true, messages:{required:'Please enter your pin code',number:'Please enter valid pin code'}}} {/literal}" id="pin_code" name="pin_code" placeholder="Pin Code*" >
          </div>
        </div>
          <div class="row marg10px_bottom">
          <div class="col-md-4">City</div>
          <div class="col-md-8">
              <input value="{PageContext::$response->city}" type="text" class="form-control {literal} {validate:{required:true, messages:{required:'Please enter your city'}}} {/literal}" id="city" name="city" placeholder="City*" >
          </div>
        </div>
          <div class="row marg10px_bottom">
          <div class="col-md-4">State</div>
          <div class="col-md-8">
              <input value="{PageContext::$response->state}" type="text" class="form-control {literal} {validate:{required:true, messages:{required:'Please enter your state'}}} {/literal}" id="state" name="state" placeholder="State*" >
          </div>
        </div>
         
   
      </div>
      <div class="modal-footer">
        <button type="submit" id="btnFrmRequestSticker" name="btnFrmRequestSticker" class="btn btn-default">REQUEST STICKER</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
    </form>
</div>


<style>
.centerSpinnerInv {
  background: url("{php} echo BASE_URL;{/php}project/styles/images/ajax-loader-big.gif") no-repeat scroll 50% 50% #fff;
  border-radius: 20px;
  height: 129px;
  left: 40%;
  position: absolute;
  text-align: center;
  top:130%;
  width: 146px;
  z-index: 99999;
}

.opaqueWrapInv{
    opacity:    0.5;
    background: #000;
    width:      100%;
    height:     100%;
    z-index:    10;
    top:        0;
    left:       0;
    position:   fixed;
    overflow-x: hidden;

}
</style>

 <div id="bck1" class="centerSpinnerInv js-loader" style="display:none;" ></div>
 <div id="bck2" class="opaqueWrapInv js-loader" style="display:none;"></div>

<script>
    function printsticker(temp)
    { //alert(temp);
        
        /*htmlbody = '<html><head><link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet"><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/styles/bootstrap.css" type="text/css" /><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/themes/default/css/style.css" type="text/css" media="screen" title="default" /></head> <body onload="window.print()" style="text-align:center;"><div class="container min-ht550" id="html-content-holder"><div><div class="row"><div class="col-md-6 col-md-offset-3"><div class="printpreview_img"><img src="{php} echo IMAGE_MAIN_URL; {/php}bhimlogoprint.png"></div><div class="printpreview_username"><label>{PageContext::$response->user_fname} {PageContext::$response->user_lname}</label></div><div class="preview_QR"><img src="{php} echo BASE_URL;{/php}project/lib/phpqrcode/temp/{PageContext::$response->qrcode_bigimage}"></div><div class="generated_qr">Generated with <b>bhim.io</b></div></div></div><div class="clearfix"></div></div></div></body></html>';*/
         
         htmlbody = '<html><head><link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet"><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/styles/bootstrap.css" type="text/css" /><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/themes/default/css/style.css" type="text/css" media="screen" title="default" /></head> <body onload="window.print()" style="text-align:center;"><div class="container min-ht550" style="margin-top:3%;" id="html-content-holder"><div><div class="row"><div class="col-md-6 col-md-offset-3"><div class="printpreview_img"><img src="{php} echo IMAGE_MAIN_URL; {/php}bhimlogoprint.png"></div><div class="printpreview_username" style="margin: 15px 0;"><div style="padding-bottom:0!important;font-size:18px;" class="pay_to">To Pay</div><label style="border-bottom: 1px solid #1cc09f;padding-bottom: 5px;color: #353537;font-size: 33px;text-align: center;font-family: Maven Pro, sans-serif!important;">{PageContext::$response->user_fname} {PageContext::$response->user_lname}</label></div><div style="font-family:Maven Pro, sans-serif!important;text-align: center; font-size: 18px;color: #1c1c1c;" class="generated_qr">Scan this <b>bhim.io</b> code</div><div class="clearfix"></div><div class="preview_QR"><img style="max-width:100%;" src="{php} echo BASE_URL;{/php}project/lib/phpqrcode/temp/{PageContext::$response->qrcode_bigimage}"></div><div style="font-family:Maven Pro, sans-serif!important;text-align: center; font-size: 16px;color: #1c1c1c;" class="generated_qr">Generated with <b>bhim.io</b></div></div></div><div class="clearfix"></div></div></div></body></html>';
        
        
        var popupWin = window.open('', '_blank', 'width=800,height=960,scrollbars=1');
                   popupWin.document.open();
                   popupWin.document.write(htmlbody);
                  /* popupWin.document.print();*/
                   popupWin.document.close(); 
    }
    
    $( document ).ready(function() {
        
    var element = $("#html-content-holder"); // global variable
    var getCanvas; // global variable
 
    //$("#btn-Preview-Image").on('click', function () {
//         html2canvas(element, {
//         onrendered: function (canvas) {
//                //$("#previewImage").append(canvas);
//                getCanvas = canvas;
//             }
//         });
    //});

//	$("#btn-Convert-Html2Image").on('click', function () {
//    var imgageData = getCanvas.toDataURL("image/png");
//    // Now browser starts downloading it instead of just showing it
//    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
//    $("#btn-Convert-Html2Image").attr("download", "your_qr.png").attr("href", newData);
//	});


$("#btn-Convert-Html2Image").on('click', function () {
    
//    $.blockUI({
//        message:'<h4><img src="{php} echo BASE_URL;{/php}project/styles/images/loading.gif" /></h4>'
//    });

$(".js-loader").show();
//$("#bck2").css('display','block');
       
         html2canvas(element, {
         onrendered: function (canvas) {
                //$("#previewImage").append(canvas);
                getCanvas = canvas;
             },onclone: function(document) {
            hiddenDiv = document.getElementById("html-content-holder");
            hiddenDiv.style.display = 'block';
        }
         });
         
          setTimeout(function(){ 
          
          var imgageData = getCanvas.toDataURL("image/png");
    // Now browser starts downloading it instead of just showing it
    var newData = imgageData.replace(/^data:image\/png/, "data:application/octet-stream");
    $("#btn-Convert-Html2ImageTemp").attr("download", "your_qr.png").attr("href", newData);
   // $.unblockUI();
    $(".js-loader").hide();
   //$("#bck1").css('display','none');
//$("#bck2").css('display','none');
    //$(".js-loader").hide();
      //$("#btn-Convert-Html2ImageTemp").trigger("click");    
          document.getElementById('btn-Convert-Html2ImageTemp').click();
      }, 5000);
    });
    
    });
</script>








