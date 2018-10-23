    <section id="services" class="inner-top-mrgin">

        <div class="container" style="min-height:350px">
            <div class="row">
            <div class="col-md-12 signup-box">
            <?php
            if(trim(PageContext::$response->success_msg) <> ""){
            ?>
            <h3><span>Message</span></h3>
            <p style="color:#006400;"><?php echo trim(PageContext::$response->success_msg); ?></p>
            <?php
            }
            if(trim(PageContext::$response->error_msg) <> ""){
            ?>
            <h3><span>Message</span></h3>
            <p style="color:red;"><?php echo trim(PageContext::$response->error_msg); ?></p>
            <?php
            }
            ?>
            <a href="<?php echo BASE_URL;?>">Back to Home</a>
        </div>
        </div>
    </div>
</section>



<style>
#mainNav{
    background:#0074bd;
    border-color: rgba(34, 34, 34, 0.05);
    height:79px;
}
</style>
