<script src="{php} echo BASE_URL; {/php}project/js/validations.js"></script>

<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h3 class="bhimqr"><span>BHIM QR CODE</span></h3>
            <div class="clearfix"></div>
            <div class="dash_qr_block">
                <form class="" method="post" id="frmlogin" name="frmlogin" novalidate="novalidate">
                    <img src="{PageContext::$response->QR}"/>
                </form>
                <a class="dash_qr_block_edit" href="#"><i class="fa fa-pencil" aria-hidden="true"></i></a>
            </div>
            <div class="dashboard_actions">
                <button name="btnRegister" id="btnRegister" type="submit" class="btn btn-secondary marg10px_top_bottom">REQUEST QR CODE <i class="fa fa-paper-plane" aria-hidden="true"></i></button>
                <button name="btnRegister" id="btnRegister" type="submit" class="btn btn-secondary marg10px_top_bottom">PRINT QR CODE <i class="fa fa-print" aria-hidden="true"></i></button>
                <button name="btnRegister" id="btnRegister" type="submit" class="btn btn-default marg10px_top_bottom">DOWNLOAD QR CODE <i class="fa fa fa-download" aria-hidden="true"></i></button>
            </div>
        </div>
        <div class="col-md-4">
            <div class="right_panel">
                <div class="user_img">
                    <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                </div>
                <div class="userinfo">
                    <h3><span>User Info<span></h3>
                    <div class="clearfix"></div>
                    <div class="userinfo_detail">
                        <div class="row marg_top_15px">
                            <div class="col-md-2"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                            <div class="col-md-10">John Alexander</div>
                        </div>
                        <div class="row marg_top_15px">
                            <div class="col-md-2"><i class="fa fa-envelope-o" aria-hidden="true"></i></div>
                            <div class="col-md-10">johnalexander@gmail.com</div>
                        </div>
                        <div class="row marg_top_15px">
                            <div class="col-md-2"><i class="fa fa-mobile" aria-hidden="true"></i></div>
                            <div class="col-md-10">000 1111 222</div>
                        </div>
                        <div class="row marg_top_15px">
                            <div class="col-md-2"><i class="fa fa-map-marker" aria-hidden="true"></i></div>
                            <div class="col-md-10">506 Milwaukee Ave. #123,
Deerfield, IL. 60015 USA</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function ()
    { $(".jqpoptooltip").popover();
    });
</script>
