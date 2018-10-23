
<!--<h1>{PageContext::$response->section[0]->title}</h1>-->
<?php if(PageContext::$response->activeMenu == 'home'){?>
<div class="container container-div">
<?php }else{ ?>
<div class="container container-div" style="margin-top:100px;min-height:500px">
  <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
      <li class="breadcrumb-item active">&nbsp;<?php  echo PageContext::$response->content[0]->title; ?></li>
  </ol>
<?php } ?>
<?php if(!empty(PageContext::$response->content[0]->description)){ ?>
<div class="entry">
    <h3><?php  echo PageContext::$response->content[0]->title; ?></h3>
    <?php echo stripslashes(PageContext::$response->content[0]->description); ?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
</div> <!-- Container close -->


<?php if(PageContext::$response->activeMenu != 'home'){?>
<style>
 h3{margin-top: 0}
</style>
<?php }?>
