<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <?php if(PageContext::$response->companylogo == ''){?>
            <div>
                <a class="navbar-brand" href="<?php echo BASE_URL;?>" title="<?php echo SITENAME;?>">
                <img src="<?php echo PageContext::$response->companyDefaultLogo;?>" />
                </a>
             </div>
            <?php } else {?>
                <?php echo PageContext::$response->companylogo;?><br>
                <span>
                <?php echo PageContext::$response->companyName;?>
                </span>
           <?php }?>
        