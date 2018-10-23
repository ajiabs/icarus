   <?php    foreach(PageContext::$response->listDataResults  as $record) { 
    ?>
    <div id="jqDetailModal" class="modal hide fade in" style="display: none; ">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3>
                    <?php
                    if(PageContext::$response->detail_section_config->detailHeaderColumnPrefix)
                        echo PageContext::$response->detail_section_config->detailHeaderColumnPrefix." ";
                    if(PageContext::$response->detail_section_config->detailHeaderContent) { ?><?php echo PageContext::$response->detail_section_config->detailHeaderContent; ?><?php } else {
                        foreach(PageContext::$response->detail_section_config->detailHeaderColumns as $col) {
                            if(trim($record->$col)!="-") {
                                echo strip_tags($record->$col)." ";
                            }
                        }
                    }
                    if( PageContext::$response->detail_section_config->detailHeaderColumnPostfix)
                        echo "  ".PageContext::$response->detail_section_config->detailHeaderColumnPostfix;
    ?></h3>
        </div>
        <div class="modal-body">
            <table class="table  table-bordered table-hover table-condensed">

                    <?php

                    foreach(PageContext::$response->detail_section_config->detailColumns as $col) {

                        if(PageContext::$response->columns->$col->editoptions->type=="password" || PageContext::$response->columns->$col->editoptions->type=="hidden" ) {

                        }
                        else{
            ?>

                <tr><td class="span3"><?php echo PageContext::$response->columns->$col->name?>&nbsp;</td>
                    <td class="span6">
                                    <?php

                                    if( PageContext::$response->columns->$col->listoptions) {
                                        foreach(PageContext::$response->columns->$col->listoptions->enumvalues as $enumKey  => $enumValue) {
                                            $enumArray  =    explode("{cms_separator}",$record->$col);
                                            if($enumKey==strip_tags($enumArray[0])) {
                                                echo $enumValue;
                                            }
                                        }
                                    }
                                    else if(PageContext::$response->columns->$col->editoptions->enumvalues) {
                                        foreach(PageContext::$response->columns->$col->editoptions->enumvalues as $enumKey  => $enumValue) {

                                            if($enumKey==strip_tags($record->$col)) {
                                                echo $enumValue;
                                            }
                                        }
                                    }
            else { ?>

                                        <?php  if(PageContext::$response->columns->$col->editoptions->type=="file" || PageContext::$response->columns->$col->editoptions->type=="htmlEditor") {
                                            echo stripslashes($record->$col);
                                        }
                                        else if(PageContext::$response->columns->$col->customColumn) {
                                            echo $record->$col;
                                        }
                                        else {
                                            echo strip_tags($record->$col);
                                        }
            }?>
                    </td>
                </tr>

            <?php   }
    }
    ?>
            </table>

        </div>
        <div class="modal-footer">

            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
    </div>
<?php } ?>