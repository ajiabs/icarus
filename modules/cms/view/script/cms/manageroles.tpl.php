
<script src="<?php echo BASE_URL;?>modules/cms/vendor/datatables/media/js/jquery.dataTables.min.js"></script>
<script src="<?php echo BASE_URL;?>modules/cms/vendor/angular-datatables/dist/angular-datatables.min.js"></script>


<?php if(PageContext::$response->addAction) { ?>
            <button ng-click="modalOpen()"  class="pull-right btn btn-primary">Add Roles</button>
        <?php }?>

          
        <?php if(PageContext::$response->message!="") { ?><div class="alert alert-success text-center alert-success-div"> <button type="button" class="close" data-dismiss="alert">×</button>  <?php echo PageContext::$response->message ?></div> <?php } ?>

      <?php if(PageContext::$response->errorMessage!="") { ?><div class="alert alert-danger text-center alert-failure-div"> <button type="button" class="close" data-dismiss="alert">×</button>  <?php echo PageContext::$response->errorMessage ?></div> <?php } ?>

     <table datatable="ng" id="dTable" class="row-border hover  animated fadeInLeft2 table table-bordered table-hover bg-white">
           <tbody>
            <tr>
                <!-- RENDER LIST HEADER -->

                <th class="table-header"><a class="cms_list_operation" href="" >Role ID</a></th>
                <th class="table-header"><a class="cms_list_operation" href="" >Role Name</a></th>
                <th class="table-header"><a class="cms_list_operation" href="" >Parent Role</a> </th>

                <th class="span2 listingTableHeadTh">Operations</th>

            </tr>
        </tbody>
        <?php foreach(pageContext::$response->roles as $role) {
            ?>
        <tr>
            <td><?php echo $role->role_id?></td>
            <td><?php echo $role->role_name?></td>
            <td><?php echo $role->parent_role_name?></td>

            <td style="width:15%"> 
              <?php if(PageContext::$response->viewAction) { ?>
            <a data-toggle="modal" class="btn btn-sm button-view" href="#<?php echo $role->role_id?>"><i class="fa fa-eye"></i><!-- View --></a>
            <?php }?>
                      <?php if(PageContext::$response->editAction) { ?>
                <a class="cms_list_operation action_unpublish btn btn-sm button-edit" href="<?php echo pageContext::$response->currentURL."&action=edit&role_id=".$role->role_id;?>" ><i class="fa fa-pencil"></i><!-- Edit --></a>
                            <?php }?>
   <?php if(PageContext::$response->deleteAction) { ?>
                <a class="cms_list_operation action_delete btn btn-sm button-delete" href="<?php echo pageContext::$response->currentURL."&action=delete&role_id=".$role->role_id;?>" ><i class="fa fa-trash"></i><!-- Delete --></a>
                            <?php }?>
                </td>
        </tr><?php } if(PageContext::$response->totalResultsNum==0) {    ?>
            <tr>  <td colspan="8">
                    No Data Found !!

                </td></tr>
                    <?php
                } ?>
    </table>
    <div class="">

        <div class="pagination pagination-right ull-right">
            <?php echo  PageContext::$response->pagination ;?>

        </div>
    </div>


 <div class="modal-header" ><h4 id="myModalLabel" class="modal-title"><?php echo PageContext::$response->form_title;?> </h4><span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span></div>
 <div class="modal-body">

   <!--  <div class="panel-group" <?php if(!PageContext::$response->showForm) { ?> style="display: none;" <?php } ?>class="listForm" id="addForm">

  <form class="form-inline" action="<?php echo pageContext::$response->currentURL; ?>" method="POST" id="newrole" name="form_">
 -->
    <form name="newrole" id="newrole" class="form-validate form-horizontal ng-pristine ng-valid-email ng-invalid ng-invalid-required ng-valid-blacklist ng-valid-pattern ng-valid-url ng-valid-minlength ng-valid-maxlength ng-invalid-validator">         

            <input type="hidden" name="role_id" id="role_id" ng-model="formData.role_id">

            <div class="control-group">
                <label for="vFirstName" class="control-label">Role Name</label>
                <div class="controls">
                    <input type="text" name="role_name"  class="form-control m-b"  id="role_name" ng-model="formData.role_name">                    
                </div>
            </div>

            <div class="control-group">
                <label for="vFirstName" class="control-label">Parent Role</label>
                <div class="controls">
                    <select name="parent_role_id" id="parent_role_id" class="required form-control m-b" ng-model="formData.parent_role_id">
                        <option value="">Superadmin</option>
                        <?php foreach( pageContext::$response->roles as $role) {
                            if(pageContext::$response->rolesDetails->role_id!=$role->role_id) { ?>
                        <option value="<?php echo $role->role_id;?>" <?php if( pageContext::$response->rolesDetails->parent_role_id==$role->role_id) { ?> selected <?php  }?>><?php echo $role->role_name;?></option>
                            <?php } } ?>
                    </select>
                </div>
            </div>




            <div class="controls">
             <input type="button" name="cancel" value="Cancel" class="cancelButton btn">
                <button type="submit" name="submit" ng-click="changepassword();" class="submitButton btn btn-primary">Save</button>
        
               </div>
            </form>

    </div>
</div>

    <?php foreach(pageContext::$response->roles as $role) {
        ?>
    <div id="<?php echo $role->role_id?>" class="modal hide fade in" style="display: none; ">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3> <?php echo $role->role_name; ?> </h3>
        </div>
        <div class="modal-body">
            <table class="table pop_table table-bordered table-hover table-condensed">


                <tbody>


                    <tr><td class="span3 leftcol">Role&nbsp;</td>
                        <td class="span6">

                            <small class=""><?php echo $role->role_name ?></small>                    </td>
                    </tr>


                    <tr>
                        <td class="span3 leftcol">Parent Role&nbsp;</td>
                        <td class="span6">

                            <small class=""><?php echo $role->parent_role_name; ?></small>                    </td>
                    </tr>


                </tbody></table>
        </div>
                 <div class="modal-footer">

            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
        
    </div>
        <?php } ?>

<script type="text/javascript"> $('#dTable').DataTable();</script>
