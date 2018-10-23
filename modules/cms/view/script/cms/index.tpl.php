<?php

if(PRODUCT_INSTALLER) {
    if(PageContext::$response->invalidLicense) {
        PageContext::renderPostAction("invalidlicense","cms","cms",1);
    }
}

if(PageContext::$response->illegal) {

PageContext::renderPostAction('permission',"cms","cms",1);
}
else {
    if(PageContext::$response->settingsTab) {
        PageContext::renderPostAction('settings',"cms","cms",1);
    }
    if(PageContext::$response->reportPanel) {
        PageContext::renderPostAction('reportlising',"cms","cms",1);
    }
    if(PageContext::$response->dashboardPanel) {
        PageContext::renderPostAction('dashboard',"cms","cms",1);
    }
    if(PageContext::$response->dashboardPanel2) {
        PageContext::renderPostAction('dashboard',"cms","cms",1);
    }
    if(PageContext::$response->customCmsAction) {
        PageContext::renderPostAction(PageContext::$response->customActionMethod,PageContext::$response->customActionController,PageContext::$response->customActionModule,1);
    }
    if(PageContext::$request['section'] && PageContext::$response->logged_in && PageContext::$response->isCustomAction==0 && !PageContext::$response->settingsTab && !PageContext::$response->dashboardPanel && PageContext::$response->customCmsAction==0) {
        ?>
<input type="hidden" value="<?php echo PageContext::$response->displayFormMethod;?>" id="jqDisplayFormMethod" >
        <?php PageContext::renderPostAction(PageContext::$response->postAction,"cms","cms",1); ?>
        <?php if(PageContext::$response->displayFormMethod=="popup") { ?>
<div id="addForm" class="modal hide fade in listForm popup_add_form" style="<?php if(!PageContext::$response->showForm) { ?> display: none; <?php } ?>width: 800px;min-height: 500px; height: auto;" >
   
        <script>

            $(document).ready(function() {

                $("form#jqCmsForm").submit(function(event){
                   var displayFormMethod = $("#jqDisplayFormMethod").val();
                    $("#jqSectionName").val(sectionName);
                    $("#jqFormMethodType").val(action);
          var primaryKeyValue   =   $("#jqPrimaryId").val();
                    if(displayFormMethod=="popup"){
                        var formData = new FormData($(this)[0]);


                        $.ajax({
                            url: MAIN_URL+"cms/cms/save_ajax_form",
                            type: 'POST',
                            data: formData,
                            async: false,
                            success: function (data) { 
                                var dataArray   =   data.split("formerror_");
                                if(dataArray.length>1)
                              {
                                 alert(dataArray[1]);
                                    return false;
                                }
                                else{
                                $('#addForm').modal('hide');
                               
                                if(action=="edit")
                                    $("#jqRecord_"+primaryKeyValue).html(data);
                                else
                                    $("#tbl_activities tr:first").after(data);
                                }

                            },
                            cache: false,
                            contentType: false,
                            processData: false
                        });

                        event.preventDefault();
                        return false;
                    }

                });
            });
        </script>

                    <?php PageContext::$response->addform->renderForm();?>
    </div>
            <?php } else if(PageContext::$response->displayFormMethod=="currentpage") { ?>
<div <?php if(!PageContext::$response->showForm) { ?> style="display: none;" <?php } ?>class="listForm" id="addForm">
                <?php PageContext::$response->addform->renderForm();?>
</div>
            <?php } ?>
        <?php } if
    (PageContext::$response->isCustomAction==1) {
        PageContext::renderPostAction(PageContext::$response->customActionMethod,PageContext::$response->customActionController,PageContext::$response->customActionModule);

    }

    if(PageContext::$request['section'] && PageContext::$response->logged_in && PageContext::$response->isCustomAction==2) {


        PageContext::renderPostAction(PageContext::$response->postAction,"cms","cms",1);
    }

    ?>


    <?php
}
if(!PageContext::$response->logged_in) {
    PageContext::renderPostAction('login',"cms","cms",1);
}


?>

