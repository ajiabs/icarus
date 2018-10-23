<div class="app animated fadeInLeft2">
                <?php  echo "<div class='app-view-header'>".PageContext::$response->sectionName."</div>"; ?>

        <?php if(PageContext::$response->message!="") { ?><div class="alert alert-success text-center alert-failure-div"> <button type="button" class="close" data-dismiss="alert">x</button>  <?php echo PageContext::$response->message ?></div> <?php } ?>
        <?php if( pageContext::$response->errorMessage!="") { ?> <div class="alert alert-danger text-center alert-failure-div"> <button type="button" class="close" data-dismiss="alert">Ã—</button>   <?php echo  pageContext::$response->errorMessage; ?></div><?php } ?>
        <div class="panel panel-default">
        <?php if(PageContext::$response->settingStyle=="tab") { ?>
        <ul class="nav nav-tabs" id="settingtab">
            <?php  $loop=0;
            foreach(PageContext::$response->settingsTabs as $tab) { ?>
                <li class="<?php  if($loop==0) { ?>active<?php } ?>"><a href="#<?php echo $tab->id ?>" data-toggle="tab" ><?php echo $tab->label ?></a></li>
                <?php  $loop++;
            } ?>
        </ul>
        <div style="border-bottom:1px solid #DDDDDD;border-left:1px solid #DDDDDD;border-right:1px solid #DDDDDD;margin-top: -20px;">
            <div class="control-group">&nbsp;</div>
            <form action="" name="settingsForm" id="settingsForm" method="post" class="form-horizontal" enctype="multipart/form-data">
                <div class="tab-content">
                        <?php $loop=0;
                        foreach(PageContext::$response->settingsTabs as $tab) {  ?>
                            <div class="tab-pane <?php if($loop==0) { ?>active<?php } ?>" id="<?php echo $tab->id ?>">
                                <?php
                                foreach($tab->tabContent as $tabContent) { //echopre($tabContent);
                                    if($tabContent->parent_settingfield=="") {

                                        $valueField = PageContext::$response->valueField;
                                        $labelField = PageContext::$response->labelField;

                                        $currentParent = $tabContent->$labelField;
                                        $currentParentStatus = $tabContent->$valueField;
                                    }
                                ?>

                                <?php if($tabContent->type=="checkbox"){ ?>
                                    <div class="control-group <?php echo "jq".$tabContent->parent_settingfield;?>"  <?php if($currentParentStatus!="1" && $currentParent==$tabContent->parent_settingfield) { ?> style="display:none;"<?php } ?>>
                                        <label class="control-label" for="<?php echo $tabContent->$labelField;?>"><?php echo $tabContent->settinglabel;?></label>
                                        <div class="controls">
                                        <input type="checkbox" class="jqSettingCheckbox"  id="<?php echo $tabContent->$labelField;?>" name="<?php echo $tabContent->$labelField;?>" <?php if($tabContent->$valueField=="1" || $tabContent->$valueField=="Y") { ?>checked <?php } ?>><span class="help-inline"><?php echo $tabContent->customColumn->hint; ?></span>
                                        <?php if($tabContent->hint) {  // if($tabContent->hint) { ?>
                                        <a href="#" class="tooltiplink" data-original-title="<?php echo $tabContent->hint; ?>"><span class="help-icon"><img src="<?php echo BASE_URL;?>modules/cms/app/img/help_icon.png"><span></a>
                                        <?php } ?>
                                        </div>
                                    </div>
                                <?php }else if($tabContent->type=="textarea"){ ?>
                                    <div class="control-group <?php  echo "jq".$tabContent->parent_settingfield;?>" <?php if($currentParentStatus!="1" && $currentParent==$tabContent->parent_settingfield) { ?> style="display:none;"<?php } ?>>
                                        <label class="control-label" for="<?php echo $tabContent->$labelField;?>"><?php echo $tabContent->settinglabel;?></label>
                                        <div class="controls">
                                        <textarea  name="<?php echo $tabContent->settingfield;?>" id="<?php echo $tabContent->$labelField;?>" ><?php echo $tabContent->$valueField;?></textarea>
                                        <?php if($tabContent->hint) {  // if($tabContent->hint) { ?>
                                        <a href="#" class="tooltiplink" data-original-title="<?php echo $tabContent->hint; ?>"><span class="help-icon"><img src="<?php echo BASE_URL;?>modules/cms/app/img/help_icon.png"><span></a>
                                        <?php } ?>
                                        </div>
                                    </div>
                                <?php }else if($tabContent->type=="link"){ ?>
                                    <div class="control-group <?php echo "jq".$tabContent->parent_settingfield;?>" <?php if($currentParentStatus!="1" && $currentParent==$tabContent->parent_settingfield) { ?> style="display:none;"<?php } ?>>
                                        <label class="control-label" for="<?php echo $tabContent->$labelField;?>"><?php echo $tabContent->settinglabel;?></label>
                                        <div class="controls">
                                        <?php echo $tabContent->$valueField;?>
                                        <?php if($tabContent->hint) {  // if($tabContent->hint) { ?>
                                        <a href="#" class="tooltiplink" data-original-title="<?php echo $tabContent->hint; ?>"><span class="help-icon"><img src="<?php echo BASE_URL;?>modules/cms/app/img/help_icon.png"><span></a>
                                        <?php } ?>
                                        <input type="hidden"   name="<?php echo $tabContent->$labelField;?>" value="<?php echo $tabContent->$valueField;?>"></div>
                                    </div>
                                <?php }else if($tabContent->type=="file"){ ?>
                                    <div class="control-group <?php echo "jq".$tabContent->parent_settingfield;?>"  <?php if($currentParentStatus!="1" && $currentParent==$tabContent->parent_settingfield) { ?> style="display:none;"<?php } ?>>
                                        <label class="control-label" for="<?php echo $tabContent->$labelField;?>"><?php echo $tabContent->settinglabel;?></label>
                                        <div class="controls">
                                        <input type="file" class="form-control m-b"  id="<?php echo $tabContent->$labelField;?>" name="<?php echo $tabContent->$labelField;?>" ><span class="help-inline"><?php echo $tabContent->customColumn->hint; ?></span>
                                        <?php if($tabContent->hint) {  // if($tabContent->hint) { ?>
                                        <a href="#" class="tooltiplink" data-original-title="<?php echo $tabContent->hint; ?>"><span class="help-icon"><img src="<?php echo BASE_URL;?>modules/cms/app/img/help_icon.png"><span></a>
                                        <?php } ?>
                                        </div>
                                    </div>
                                    <div class="control-group <?php echo "jq".$tabContent->parent_settingfield;?>"  <?php if($currentParentStatus!="1" && $currentParent==$tabContent->parent_settingfield) { ?> style="display:none;"<?php } ?>>
                                        <div class="controls">
                                        <img src="project/files/logo/<?php echo $tabContent->$valueField;?>">
                                        </div>
                                    </div>
                                <?php }else if($tabContent->type=="password"){ ?>
                                    <div class="control-group <?php echo "jq".$tabContent->parent_settingfield;?>" <?php if($currentParentStatus!="1" && $currentParent==$tabContent->parent_settingfield) { ?> style="display:none;"<?php } ?>>
                                        <label class="control-label" for="<?php echo $tabContent->$labelField;?>"><?php echo $tabContent->settinglabel;?></label>
                                        <div class="controls">
                                            <input type="password" class="form-control m-b"  id="<?php echo $tabContent->$labelField;?>" name="<?php echo $tabContent->$labelField;?>" value="<?php echo $tabContent->$valueField;?>" >
                                            <?php if($tabContent->hint) {  // if($tabContent->hint) { ?>
                                            <a href="#" class="tooltiplink" data-original-title="<?php echo $tabContent->hint; ?>"><span class="help-icon"><img src="<?php echo BASE_URL;?>modules/cms/app/img/help_icon.png"><span></a>
                                            <?php } ?>
                                        </div>
                                    </div>
                                <?php }else if(trim($tabContent->type=="")){  ?>
                                    <div class="control-group <?php echo "jq".$tabContent->parent_settingfield;?>" <?php if($currentParentStatus!="1" && $currentParent==$tabContent->parent_settingfield) { ?> style="display:none;"<?php } ?>>
                                        <label class="control-label" for="<?php echo $tabContent->$labelField;?>"><?php echo $tabContent->settinglabel;?></label>
                                        <div class="controls">
                                        <input type="text" class="form-control m-b"  id="<?php echo $tabContent->$labelField;?>" name="<?php echo $tabContent->$labelField;?>" value="<?php echo $tabContent->$valueField;?>" >
                                        <?php if($tabContent->hint) {  // if($tabContent->hint) { ?>
                                            <a href="#" class="tooltiplink" data-original-title="<?php echo $tabContent->hint; ?>"><span class="help-icon"><img src="<?php echo BASE_URL;?>modules/cms/app/img/help_icon.png"><span></a>
                                        <?php } ?>
                                    </div>  </div>
                                <?php } ?>
                                <?php } ?>
                                <div class="controls"><input class="cancelButton btn btn-primary cancelButtonSettings" type="button" value="Cancel" name="cancel">
                                <input class="submitButton btn btn-primary" type="submit" value="Save" name="submit"></div>
                            </div>

                                                                                                                                                        <?php $loop++;
                                                                                                                                                    } ?>

                                                                                                                                                </div>
                     </div>                                                                                                                           </form>
                                                                                                                                                    <?php  } ?>
                                                                                                                                                </div>
                                                                                                                                                </div>
                                                                                                                                                <br>
                                                                                                                                                <br>
                                                                                                                                                </div>
