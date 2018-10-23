
<script>

    
    $( document ).ready(function() {
        
   /*htmlbody = '<html><head><link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet"><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/styles/bootstrap.css" type="text/css" /><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/themes/default/css/style.css" type="text/css" media="screen" title="default" /></head> <body onload="window.print()" style="text-align:center;"><div class="container min-ht550" style="margin-top:5%;" id="html-content-holder"><div><div class="row"><div class="col-md-6 col-md-offset-3"><div class="printpreview_img"><img src="{php} echo IMAGE_MAIN_URL; {/php}bhimlogoprint.png"></div><div class="printpreview_username" style="margin: 25px 0;"><div style="padding-bottom:0!important;font-size:18px;" class="pay_to">To Pay</div><label style="width: 100%;border-bottom: 1px solid #1cc09f;padding-bottom: 5px;color: #353537;font-size: 34px;text-align: center;font-family: Maven Pro, sans-serif!important;">{PageContext::$response->user_fname} {PageContext::$response->user_lname}</label></div><div style="font-family:Maven Pro, sans-serif!important;text-align: center; font-size: 18px;color: #1c1c1c;" class="generated_qr">Scan <b>bhim.io</b> code</div><div class="clearfix"></div><div class="preview_QR"><img src="{php} echo BASE_URL;{/php}project/lib/phpqrcode/temp/{PageContext::$response->qrcode_bigimage}"></div><div style="font-family:Maven Pro, sans-serif!important;text-align: center; font-size: 16px;color: #1c1c1c;" class="generated_qr">Generated with <b>bhim.io</b></div></div></div><div class="clearfix"></div></div></div></body></html>';*/
   
   htmlbody = '<html><head><link href="https://fonts.googleapis.com/css?family=Maven+Pro" rel="stylesheet"><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/styles/bootstrap.css" type="text/css" /><link rel="stylesheet" href="{php} echo BASE_URL;{/php}project/themes/default/css/style.css" type="text/css" media="screen" title="default" /></head> <body onload="window.print()" style="text-align:center;"><div class="container min-ht550" style="margin-top:3%;" id="html-content-holder"><div><div class="row"><div class="col-md-6 col-md-offset-3"><div class="printpreview_img"><img src="{php} echo IMAGE_MAIN_URL; {/php}bhimlogoprint.png"></div><div class="printpreview_username" style="margin: 15px 0;"><div style="padding-bottom:0!important;font-size:18px;" class="pay_to">To Pay</div><label style="border-bottom: 1px solid #1cc09f;padding-bottom: 5px;color: #353537;font-size: 33px;text-align: center;font-family: Maven Pro, sans-serif!important;">{PageContext::$response->user_fname} {PageContext::$response->user_lname}</label></div><div style="font-family:Maven Pro, sans-serif!important;text-align: center; font-size: 18px;color: #1c1c1c;" class="generated_qr">Scan this <b>bhim.io</b> code</div><div class="clearfix"></div><div class="preview_QR"><img style="max-width:100%;" src="{php} echo BASE_URL;{/php}project/lib/phpqrcode/temp/{PageContext::$response->qrcode_bigimage}"></div><div style="font-family:Maven Pro, sans-serif!important;text-align: center; font-size: 16px;color: #1c1c1c;" class="generated_qr">Generated with <b>bhim.io</b></div></div></div><div class="clearfix"></div></div></div></body></html>';
        
        
        var popupWin = window.open('', '_blank', 'width=800,height=960,scrollbars=1');
                   popupWin.document.open();
                   popupWin.document.write(htmlbody);
                  /* popupWin.document.print();*/
                   popupWin.document.close(); window.close();

    });
</script>






