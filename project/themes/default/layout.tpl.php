<link rel="stylesheet" type="text/css" href="<?php PageContext::printThemePath(); ?>css/style.css">
<link rel="stylesheet" type="text/css" href="<?php PageContext::printThemePath(); ?>css/jquery-ui.css">
<script src="<?php echo BASE_URL ?>project/js/jquery-ui.js" type="text/javascript"></script>
<div class="outer_wrapper">

    <!-- header starts ------------------------------------------------------------- -->
    <?php PageContext::renderRegisteredPostActions('header'); ?>
    <!-- header ends --------------------------------------------------------------- -->
    <!-- header starts ------------------------------------------------------------- -->
    <?php PageContext::renderRegisteredPostActions('smbmenu'); ?>
    <!-- header ends --------------------------------------------------------------- -->

    <?php PageContext::renderRegisteredPostActions('center-main'); ?>
    <!-- footer starts -------------------------------------------------------->
    <?php PageContext::renderRegisteredPostActions('footer'); ?>
    <!-- footer ends---------------------------------------    ---------------->


    <div class="clear"></div>
</div>





















