<nav <?php if(PageContext::$response->activeMenu != ''){ ?> id="mainNavInner" <?php }else{ ?> id="mainNav" <?php } ?> class="navbar navbar-default navbar-fixed-top no-border new-nav-pad">
        <div class="container">
          <?php  if(PageContext::$response->userdetails['user_type']!=''){?>
                    <span class="pull-right welcomename">Welcome <?php echo PageContext::$response->userdetails['first_name'];?></span>
                    <div class="clearfix"></div>
                  <?php }else{?>
                    <span class="pull-right">&nbsp;</span>
                    <div class="clearfix"></div>
                  <?php

                  }?>
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> <i class="fa fa-bars"></i>
                </button>


                 <?php if(PageContext::$response->companylogo == ''){?>

                <a class="navbar-brand page-scroll" href="<?php echo BASE_URL;?>" title="<?php echo SITENAME;?>">
                <img src="<?php echo PageContext::$response->companyDefaultLogo;?>" />
                </a>

                <?php } else {?>
                    <?php echo PageContext::$response->companylogo;?>
                    <span>
                    <?php echo PageContext::$response->companyName;?>
                    </span>
               <?php }?>
               <div class="clear"></div>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                 <?php echo PageContext::$response->topMenu; ?>

                 <?php /* <ul class="nav navbar-nav navbar-right">
                    <li class="home">
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>">Home</a>
                    </li>
                    <li class="about">
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>about">About</a>
                    </li>
                    <li class="services">
                        <a class="page-scroll dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false" href="<?php  echo BASE_URL;?>services">Services<span class="caret"></span</a>
                          <ul class="dropdown-menu">
                <li><a href="#">Action</a></li>
                <li><a href="#">Another action</a></li>
                <li><a href="#">Something else here</a></li>

                <li><a href="#">Separated link</a></li>
                <li><a href="#">One more separated link</a></li>
              </ul>
                    </li>
                    <li class="products">
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>products">Products</a>
                    </li>
                      <li class="contact">
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>contact">Contact</a>
                    </li>
                    <?php  if(PageContext::$response->userdetails['user_type']!=''){?>
                     <li class="schools">
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>schools">Schools</a>
                    </li>
                      <li class="bulk_order">
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>bulk_order">Bulk Buy</a>
                    </li>
                    <li class="cart">
                      <a href="<?php  echo BASE_URL;?>orders" class="page-scroll" >Cart ( <span id="cart-info2">
                    <?php
                    if(isset($_SESSION["products"])){
                      echo count($_SESSION["products"]);
                    }else{
                      echo 0;
                    }
                    ?>
                    </span> )
                    </a>
                    </li>
                    <li>
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>cms?section=dashboard">My account</a>
                    </li>

                     <li>
                        <a class="page-scroll" href="<?php  echo BASE_URL;?>index/logout">Logout</a>
                    </li>
                    <?php }?>
                </ul> */ ?>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>
