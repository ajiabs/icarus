<div id="frameworkcontrols" class="frameworkcontrols">
    <div class="framework_text">Framework Controls</div>
    <div class="controls_outer">
        <div class="control_block_grey">
            <div class="control_left">Debugger</div>
            <div class="control_right">
            <?php if( $_SESSION['debug']  && $_SESSION['debug']==1){  ?>
                <a href="<?php echo BASE_URL;?>framework/debugger/off"><img src="<?php echo ConfigUrl::root()?>public/images/turnoff.png" alt="turnoff" title="turn off"></a>
            <?php } else {?>
                <a href="<?php echo BASE_URL;?>framework/debugger/on"><img src="<?php echo ConfigUrl::root()?>public/images/trunon.png" alt="turn on" title="turn on"></a>
            <?php }?>
            </div>
             <div class="clear_both"></div>
        </div>
        <div class="control_block_white">
            <div class="control_left">Logger</div>
            <div class="control_right">
                   <?php if( $_SESSION['logger_active']  && $_SESSION['logger_active']==1){ ?>
                 <a href="<?php echo BASE_URL;?>framework/logger/off"><img src="<?php echo ConfigUrl::root()?>public/images/turnoff.png" alt="turn off" title="turn off"></a>
                <?php } else {?>
                <a href="<?php echo BASE_URL;?>framework/logger/on"><img src="<?php echo ConfigUrl::root()?>public/images/trunon.png" alt="turn on" title="turn on"></a>
                <?php }?>
            </div>
            <div class="clear_both"></div>
        </div>
        <div class="control_block_grey">
            <div class="control_left">Cache</div>
            <div class="control_right"><img src="<?php echo ConfigUrl::root()?>public/images/turnoff.png" alt="turn on" title="turn off"> </div>
            <div class="clear_both"></div>
        </div>
        <div class="control_block_white">
            <div class="control_left">Admin Error Reporting</div>
            <div class="control_right"><img src="<?php echo ConfigUrl::root()?>public/images/turnoff.png" alt="turn on" title="turn off"> </div>
             <div class="clear_both"></div>
        </div>
        <div class="control_block_grey">
            <div class="control_left">Scheduled Jobs</div>
            <div class="control_right"><img src="<?php echo ConfigUrl::root()?>public/images/turnoff.png" alt="turn on" title="turn off"> </div>
             <div class="clear_both"></div>
        </div>

    </div>

</div>
