<div class="section_list_view ">

    <div class="row have-margin">
		<div class="tophding_blk">
	    <?php if(count(PageContext::$response->searchableCoumnsList)) { ?>


        <div  class="input-append pull-right srch_pad">
            <form name="search_form" id="search_form" action="" method="post">
                <select name="searchField" id="searchField"  class="input-medium have-margin10 ">
                        <?php
                        if(PageContext::$response->section_config->wildsearch) {
                            ?>
                     <option value="ALL"  <?php if(PageContext::$response->request['searchField']=="ALL") { ?>selected="selected" <?php } ?>>All</option>
                            <?php
                        }
                        foreach(PageContext::$response->searchableCoumnsList as $key => $val ) {
                            ?>
                    <option value="<?php echo $key;?>"  <?php if(PageContext::$response->request['searchField']==$key) { ?>selected="selected" <?php } ?>><?php echo $val ?></option>
                            <?php } ?>
                </select>
                <input type="text" class="input-medium have-margin10 " placeholder="search" maxlength="50" name="searchText" id="searchText" value="<?php echo PageContext::$response->request['searchText'];?>">
                <input type="button"  class="btn btn-info searchBtn " id="section_search_button" value="" >
            </form>
        </div>
            <?php } ?>
        <span class="legend hdname hdblk_inr">
			<?php
                echo "<div class='hdblk_inr'>Section : ".PageContext::$response->sectionData->section_name."</div>";
             ?> </span>

        <?php if(PageContext::$response->message!="") { ?><div class="alert alert-success"> <button type="button" class="close" data-dismiss="alert">x</button>  <?php echo PageContext::$response->message ?></div> <?php } ?>
        <?php if( pageContext::$response->errorMessage!="") { ?> <div class="alert alert-error"> <button type="button" class="close" data-dismiss="alert">x</button>   <?php echo  pageContext::$response->errorMessage; ?></div><?php } ?>

    	</div>
    	<?php if(PageContext::$response->section_config->dateRange) {
    		$activeDateTypeClass = " btn-primary active disabled";
    		$dateTypeClass = " btn-primary ";
    		$rangeUrl=PageContext::$response->sectionPath."&dateRange=";
    		?>


        <div  class="is-padded have-margin">

            <!--  <a data-toggle="modal" href="#report" class="btn btn-info">Export</a>&nbsp; -->
            <div class="btn-toolbar">
             <?php if(in_array("all", PageContext::$response->section_config->dateRange)){?>
<div class="btn-group">
 <a href="<?php echo $rangeUrl."all";?>" id="all" class="jqdateRange btn <?php if(PageContext::$response->request['dateRange']=='all' || !PageContext::$response->request['dateRange']) {echo $activeDateTypeClass;}else{echo $dateTypeClass;}?>" role="botton">All</a>
 </div>
    <?php }?>
     <?php if(in_array("weekly", PageContext::$response->section_config->dateRange)){?>
 <div class="btn-group">
 <a href="<?php echo $rangeUrl."weekly";?>" id="weekly" class="jqdateRange btn <?php if(PageContext::$response->request['dateRange']=='weekly') {echo $activeDateTypeClass;}else{echo $dateTypeClass;}?>" role="botton">Weekly</a>
   </div>
     <?php }?>
        <?php if(in_array("monthly", PageContext::$response->section_config->dateRange)){?>
 <div class="btn-group">
 <a href="<?php echo $rangeUrl."monthly";?>" id="monthly" class="jqdateRange btn <?php if(PageContext::$response->request['dateRange']=='monthly') {echo $activeDateTypeClass;}else{echo $dateTypeClass;}?>" role="botton">Monthly</a>
    </div>
       <?php }?>
          <?php if(in_array("custom",  PageContext::$response->section_config->dateRange)){?>
 <div class="btn-group">
  <a href="#report" id="custom"  data-toggle="modal" class="jqdateRange btn <?php if(PageContext::$response->request['dateRange']=='custom') {echo $activeDateTypeClass;}else{echo $dateTypeClass;}?>" role="botton">Custom Date</a>
</div>
   <?php }?>
</div>

        </div>
            <?php } ?>
    </div>
    <table  id="tbl_activities" class="cms_listtable table  table-striped table-bordered table-hover " >
        <tbody>
            <tr id="">
                <!-- RENDER LIST HEADER -->
                <?php foreach(PageContext::$response->listColumns as $col) { ?>
                <th class="table-header">
                        <?php
                        $colName=PageContext::$response->columns->$col->name;
                        $orderType="ASC";
                        $sortClass="";
                        if(PageContext::$response->columns->$col->sortable) {
                            if(PageContext::$response->request['orderField'] == $col) {
                                if(strtolower(PageContext::$response->request['orderType'])=="asc") {
                                    $orderType="DESC";
                                    $sortClass  =   "icon-chevron-up";
                                }
                                else {
                                    $orderType="ASC";
                                    $sortClass  =   "icon-chevron-down ";
                                }
                            }
                            $sortUrl=PageContext::$response->currentURL."&orderField=".$col."&orderType=".$orderType;
                            ?>
                    <a class="cms_list_operation" href="<?php echo $sortUrl;?>"> <?php echo PageContext::$response->columns->$col->listHeaderPrefix." ".$colName." ".PageContext::$response->columns->$col->listHeaderPostfix; ?></a>&nbsp;<i class="<?php echo $sortClass;?>"></i>&nbsp;

                            <?php }else echo  PageContext::$response->columns->$col->listHeaderPrefix." ".$colName." ".PageContext::$response->columns->$col->listHeaderPostfix; ?>
                </th>
                    <?php  }

              ?>
                 <th class="span2 listingTableHeadTh">Operations</th>
                </tr>

                 <!--  RENDER RECORDS  -->
            <?php
            $loop=0;
            foreach(PageContext::$response->listData  as $record) {
                $parentKey = PageContext::$response->section_config->keyColumn;?>


            <tr id="jqRecord_<?php echo $record->$parentKey;?>">
                    <?php
                    foreach(PageContext::$response->section_config->listColumns as $col) {
                        $colType=PageContext::$response->columns->$col->editoptions->type;
                        ?>

                <td><?php
                                    echo substr(strip_tags($record->$col),0,30);
                              ?></td>
                        <?php  }

               ?>
                <td>
                        <?php //if(PageContext::$response->viewAction) { ?>
                    <!-- <a data-toggle="modal" href="#<?php echo $record->$parentKey?>"><img class="table_iconset_2 li_iconset  " src="<?php  echo CMS_BASE_PATH?>images/details_icon.png"></a> -->
                    <a data-toggle="modal" href="#<?php echo $record->$parentKey?>" title="<?php echo PageContext::$response->viewActionTitle?>"><img class="table_iconset_2 li_iconset  " src="<?php  echo BASE_URL?>modules/cms/app/img/details_icon.png"></a>
                            <?php //} ?>

                        <?php if(PageContext::$response->editAction) { ?>
                    <a class="cms_list_operation action_edit jqEditRecord" id="jqEditRecord_<?php echo $record->$parentKey?>" href="<?php echo  pageContext::$response->editURL;?>&action=edit&<?php echo $parentKey;?>=<?php echo $record->$parentKey?>#addForm" title="<?php echo PageContext::$response->editActionTitle?>"><img class="<?php if(PageContext::$response->viewAction) { ?>table_iconset <?php } else { ?> table_iconset_2<?php } ?>li_iconset" src="<?php  echo BASE_URL?>modules/cms/app/img/edit_icon.png"></a>
                            <?php } ?>
                        <?php if(PageContext::$response->deleteAction) { ?>
                    <a class="cms_list_operation action_delete" href="<?php echo  PageContext::$response->currentURL;?>&action=delete&<?php echo $parentKey;?>=<?php echo $record->$parentKey?>" title="<?php echo PageContext::$response->deleteActionTitle?>"><img class="<?php if(PageContext::$response->viewAction || PageContext::$response->editAction ) { ?>table_iconset <?php } else { ?> table_iconset_2<?php } ?> li_iconset" src="<?php  echo BASE_URL?>modules/cms/app/img/delete_icon.png"></a>
                            <?php } ?>
                </td>

            </tr>

                <?php  $loop++;
            }

if(PageContext::$response->totalResultsNum==0) {    ?>
            <tr>  <td colspan="<?php echo PageContext::$response->columnNum; ?>">
                    No Data Found !!

                </td>
                    <?php
                }
?>


        </tbody>
    </table>

        <div class="">
        <div class="section_list_operations ull-left span3 pagination">
<?php if(PageContext::$response->addAction) { ?>

            <a <?php if(PageContext::$response->displayFormMethod=="popup") { ?>  data-toggle="modal"  href="#addForm" <?php } else { ?> href="<?php echo  PageContext::$response->currentURL;?>&action=add#addForm" <?php } ?> class="addrecord btn btn-info">Add <?php if(PageContext::$response->sectionData->section_name){echo PageContext::$response->sectionData->section_name;}else{?>Record<?php }?></a>
                <?php } ?>
<?php if( PageContext::$response->section_config->export) { ?>
            &nbsp;<a class="btn btn-info export jqReportExport">Export</a>&nbsp;
    <?php } ?>
        </div>
        <?php   // outputting the pages

        if (PageContext::$response->resultPageCount > 1) {

    ?>
        <div class="pagination pagination-right ull-right">

                <?php
                echo PageContext::$response->pagination;
    ?>
        </div>  <?php
        }
?>

        <div style="clear:both"></div>
    </div>



      <?php    foreach(PageContext::$response->listData  as $record) {
    ?>
    <div id="<?php echo $record->$parentKey?>" class="modal hide fade in" style="display: none; ">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">x</a>
            <h3>
                    <?php
                    if(PageContext::$response->section_config->detailHeaderColumnPrefix)
                        echo PageContext::$response->section_config->detailHeaderColumnPrefix." ";
                    if(PageContext::$response->section_config->detailHeaderContent) { ?>
					<?php echo PageContext::$response->section_config->detailHeaderContent; ?>
					<?php }
					if(PageContext::$response->section_config->reportTitle) { ?>
					<?php echo PageContext::$response->section_config->reportTitle; ?>
					<?php } else {
                        foreach(PageContext::$response->section_config->detailHeaderColumns as $col) {
                            if(trim($record->$col)!="-") {
                                echo strip_tags($record->$col)." ";
                            }
                        }
                    }
                    if( PageContext::$response->section_config->detailHeaderColumnPostfix)
                        echo "  ".PageContext::$response->section_config->detailHeaderColumnPostfix;
    ?></h3>
        </div>
        <div class="modal-body">
            <table class="table pop_table table-bordered table-hover table-condensed">

                    <?php

                    foreach(PageContext::$response->section_config->detailColumns as $col) {

                        if(PageContext::$response->columns->$col->editoptions->type=="password" || PageContext::$response->columns->$col->editoptions->type=="hidden" ) {

                        }
                        else{
            ?>

                <tr><td class="span3 leftcol"><?php echo PageContext::$response->columns->$col->name?>&nbsp;</td>
                    <td class="span6">
                                    <?php

//                                     if( PageContext::$response->columns->$col->listoptions) {
//                                         foreach(PageContext::$response->columns->$col->listoptions->enumvalues as $enumKey  => $enumValue) {
//                                             $enumArray  =    explode("{cms_separator}",$record->$col);
//                                             if($enumKey==strip_tags($enumArray[0])) {
//                                                 echo $enumValue;
//                                             }
//                                         }
//                                     }
//                                     else if(PageContext::$response->columns->$col->editoptions->enumvalues) {
//                                         foreach(PageContext::$response->columns->$col->editoptions->enumvalues as $enumKey  => $enumValue) {

//                                             if($enumKey==strip_tags($record->$col)) {
//                                                 echo $enumValue;
//                                             }
//                                         }
//                                     }
           // else { ?>

                                        <?php  //if(PageContext::$response->columns->$col->editoptions->type=="file" || PageContext::$response->columns->$col->editoptions->type=="htmlEditor") {
//                                             echo stripslashes($record->$col);
//                                         }
//                                         else if(PageContext::$response->columns->$col->customColumn) {
//                                             echo $record->$col;
//                                         }
//                                         else {
                                            echo strip_tags($record->$col);
                                      //  }
           // }?>
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
    <?php }

?>

    <div class="modal" id="report" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
            <h4 id="myModalLabel">Select Date Range</h4>
        </div>
        <div class="modal-body">
            <p>Choose date range </p>
            From <input type="text"  placeholder="Date" class="textfield_date datefrom" id="reportStartDate" value="<?php echo PageContext::$response->monthStartDate;?>">
            To <input type="text"  placeholder="Date" class="textfield_date" id="reportEndDate" value="<?php echo PageContext::$response->currentDate;?>">
        </div>
        <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <button class="btn btn-primary  <?php // generateReport?> jqreportListingCustomDate" >Submit</button>
        </div>

    </div>
    <div class="modal" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none; ">
        <div class="is-padded">
            <button type="button" class="close jqCloseButton" data-dismiss="modal" aria-hidden="true">×</button>

        </div>
        <div class="modal-body" id="popupBody">
        </div>
        <div class="modal-footer">
            <button class="btn jqCloseButton" data-dismiss="modal" aria-hidden="true">Close</button>

        </div>

    </div>








    </div>
