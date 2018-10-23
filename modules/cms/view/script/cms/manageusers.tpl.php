<div class="app ng-scope">

           <!--  <form name="search_form" id="search_form" action="" method="post">
                <select name="searchField" id="searchField"  class="input-medium have-margin10 ">
				   <option value="username"  <?php if(PageContext::$response->request['searchField']=='username') { ?>selected="selected" <?php } ?>>User Name</option>
                   <option value="email"  <?php if(PageContext::$response->request['searchField']=='email') { ?>selected="selected" <?php } ?>>Email</option>
                </select>
                <input type="text" class="input-medium have-margin10 " placeholder="search" maxlength="50" name="searchText" id="searchText" value="<?php echo PageContext::$response->request['searchText'];?>">
                <input type="button"  class="btn btn-info searchBtn " id="section_search_button" value="" >
            </form>
 -->

         <div class='app-view-header'> Manage Users

        <?php if(PageContext::$response->addAction) { ?>
            <a href="<?php echo  PageContext::$response->currentURL;?>&action=add#addForm" class="pull-right btn btn-primary">Add <!-- Record -->User</a>
           <?php }?>


         </div>

        <?php if(PageContext::$response->message!="") { ?><div class="alert alert-success text-center alert-success-div"> <button type="button" class="close" data-dismiss="alert">×</button>  <?php echo PageContext::$response->message ?></div> <?php } ?>
     <?php if(PageContext::$response->errorMessage!="") { ?><div class="alert alert-danger text-center alert-failure-div"> <button type="button" class="close" data-dismiss="alert">×</button>  <?php echo PageContext::$response->errorMessage ?></div> <?php } ?>

    <table  id="tbl_activities" class="row-border hover animated fadeInLeft2 table table-bordered table-hover bg-white">
        <tbody>
            <tr>
                <!-- RENDER LIST HEADER -->

                <th class="table-header">
                <?php $orderType="ASC";
                        $sortClass="";
                            if(PageContext::$response->request['orderField'] == 'id') {
                                if(strtolower(PageContext::$response->request['orderType'])=="asc") {
                                    $orderType="DESC";
                                    $sortClass  =   "icon-chevron-up";
                                }
                                else {
                                    $orderType="ASC";
                                    $sortClass  =   "icon-chevron-down ";
                                }                             
 							}     
    				$sortUrl=PageContext::$response->currentURL."&orderField=id&orderType=".$orderType;
   				 ?>
               <a class="cms_list_operation" href="<?php echo $sortUrl;?>" >User ID</a>&nbsp;<i class="<?php echo $sortClass;?>"></i>&nbsp;
                </th>
                <th class="table-header">
               <?php $orderType="ASC";
                        $sortClass="";
                            if(PageContext::$response->request['orderField'] == 'username') {
                                if(strtolower(PageContext::$response->request['orderType'])=="asc") {
                                    $orderType="DESC";
                                    $sortClass  =   "icon-chevron-up";
                                }
                                else {
                                    $orderType="ASC";
                                    $sortClass  =   "icon-chevron-down ";
                                }                             
 							}     
    				$sortUrl=PageContext::$response->currentURL."&orderField=username&orderType=".$orderType;
   				 ?>
   				 <a class="cms_list_operation" href="<?php echo $sortUrl;?>" >User Name</a>&nbsp;<i class="<?php echo $sortClass;?>"></i>&nbsp;
   				
                </th>
                  <th class="table-header">
                  <?php $orderType="ASC";
                        $sortClass="";
                            if(PageContext::$response->request['orderField'] == 'email') {
                                if(strtolower(PageContext::$response->request['orderType'])=="asc") {
                                    $orderType="DESC";
                                    $sortClass  =   "icon-chevron-up";
                                }
                                else {
                                    $orderType="ASC";
                                    $sortClass  =   "icon-chevron-down ";
                                }                             
 							}     
    				$sortUrl=PageContext::$response->currentURL."&orderField=email&orderType=".$orderType;
   				 ?>
                  <a class="cms_list_operation" href="<?php echo $sortUrl;?>" >Email</a> &nbsp;<i class="<?php echo $sortClass;?>"></i>&nbsp;
                  
                   </th>
                <th class="table-header">Role</th>
                <th class=" listingTableHeadTh">Operations</th>

            </tr>
        </tbody>
        <?php foreach(pageContext::$response->users as $user) {
            ?>
        <tr>
            <td><?php echo $user->id;?></td>
            <td><?php echo $user->username;?></td>
              <td><?php echo $user->email;?></td>
            <td><?php echo $user->role_name;?></td>

            <td>
             <?php if(PageContext::$response->viewAction) { ?>
            <a data-toggle="modal" class="btn btn-sm button-view" href="#<?php echo $user->id?>"><i class="fa fa-eye"></i><!-- View --></a>
            <?php }?>
                <?php if($user->username!="sadmin") { ?>
                <?php if(PageContext::$response->editAction) { ?>
                <a class="cms_list_operation action_unpublish  btn btn-sm button-edit" href="<?php echo pageContext::$response->currentURL."&action=edit&id=".$user->id;?>" ><i class="fa fa-pencil"></i><!-- Edit --></a>
                 <?php }?>
                    <?php if(PageContext::$response->deleteAction) { ?>
                <a class="cms_list_operation action_delete btn btn-sm button-delete" href="<?php echo pageContext::$response->currentURL."&action=delete&id=".$user->id;?>" ><i class="fa fa-trash"></i><!-- Delete --></a>
                 <?php }?>
                 <?php if(PageContext::$response->editAction) { ?>
    <a class="cms_list_operation action_unpublish" href="<?php echo pageContext::$response->currentURL."&action=changepw&id=".$user->id;?>" >Change Password</a></td>
     <?php }?>
        <?php } ?></tr><?php } ?>
         <?php if(PageContext::$response->totalResultsNum==0) {    ?>
            <tr>  <td colspan="6">
                    No Data Found !!

                </td>
                    <?php
                }
?>
    </table>


        <div class="pagination pagination-right ull-right">
            <?php echo  PageContext::$response->pagination ;?>

        </div>
    </div>
    <div  <?php if(!PageContext::$response->showForm) { ?> style="display: none;" <?php } ?>class="listForm" id="addForm">
        <form class="form-horizontal" action="<?php echo pageContext::$response->currentURL; ?>" method="POST" id="newuser" name="form" >
 <span class="app-view-header"><?php echo PageContext::$response->form_title;?></span>
            <input type="hidden" name="id" id="id" value="<?php echo pageContext::$response->userDetails->id;?>">

            <div class="control-group">
                <label for="vFirstName" class="control-label">User Name</label>
                <div class="controls">
                    <input type="text" class="form-control m-b" name="username" id="username" value="<?php echo pageContext::$response->userDetails->username;?>">
                    
                </div>
            </div>
            <?php if(!pageContext::$response->userDetails->id) { ?>
 <div class="control-group">
                <label for="vFirstName" class="control-label">Password</label>
                <div class="controls">
                    <input type="password" class="form-control m-b" name="password" id="password" value="">
                   
                </div>
            </div>
            <?php } ?>
             <div class="control-group">
                <label for="vFirstName" class="control-label">Email</label>
                <div class="controls">
                    <input type="text"  class="form-control m-b" name="email" id="email" value="<?php echo pageContext::$response->userDetails->email;?>">
                    
                </div>
            </div>
            <div class="control-group">
                <label for="vFirstName" class="control-label">Role</label>
                <div class="controls">
                    <select name="role_id" id="role_id" class="required form-control m-b">
                        
                        <?php foreach( PageContext::$response->roles as $role) {
                          ?>
                        <option value="<?php echo $role->value;?>" <?php if( pageContext::$response->userDetails->role_id==$role->value) { ?> selected <?php  }?>><?php echo $role->text;?></option>
                           <?php } ?>
                    </select>
                                        
                </div>
            </div>




            <div class="controls">
             <input type="button" name="cancel" value="Cancel" class="cancelButton btn btn-primary">
                <input type="submit" name="submit" value="Save" class="submitButton btn btn-primary jqUserForm">
               </div></form>

    </div>
        <div  <?php if(!PageContext::$response->showPasswordForm) { ?> style="display: none;" <?php } ?>class="cpForm" id="cpForm">
        <form class="form-horizontal" action="<?php echo pageContext::$response->currentURL; ?>" method="POST"  name="cpform" id="cpform" >
  <span class="legend formhd_popup">Change Password</span>      
            <input type="hidden" name="id" id="id" value="<?php echo pageContext::$response->userDetails->id;?>">

            <div class="control-group">
                <label for="vFirstName" class="control-label">Current Password</label>
                <div class="controls">
                    <input type="password" name="cpassword" id="cpassword" >

                </div>
            </div>
              <div class="control-group">
                <label for="vFirstName" class="control-label">New Password</label>
                <div class="controls">
                    <input type="password" name="newpassword" id="newpassword" >

                </div>
            </div>
              <div class="control-group">
                <label for="vFirstName" class="control-label">Confirm Password</label>
                <div class="controls">
                    <input type="password" name="cnewpassword" id="cnewpassword" >

                </div>
            </div>
          
         




            <div class="controls">
            <input type="button" name="cancel" value="Cancel" class="cancelButton btn">
                <input type="submit" name="submit" value="Update" class="submitButton btn jqCPForm">
                </div></form>

    </div>
    <?php foreach(pageContext::$response->users as $user) {
        ?>
    <div id="<?php echo $user->id?>" class="modal hide fade in" style="display: none; ">
        <div class="modal-header">
            <a class="close" data-dismiss="modal">×</a>
            <h3> <?php echo $user->username; ?> </h3>
        </div>
        <div class="modal-body">
            <table class="table pop_table table-bordered table-hover table-condensed">


                <tbody>

 <tr><td class="span3 leftcol">User Id&nbsp;</td>
                        <td class="span6">

                            <small class=""><?php echo $user->id ?></small>                    </td>
                    </tr>
                    <tr>
                    <td class="span3 leftcol">User&nbsp;</td>
                        <td class="span6">

                            <small class=""><?php echo $user->username ?></small>                    </td>
                    </tr>
  <tr><td class="span3 leftcol">Email&nbsp;</td>
                        <td class="span6">

                            <small class=""><?php echo $user->email; ?></small>                    </td>
                    </tr>

                    <tr>
                        <td class="span3 leftcol">Role&nbsp;</td>
                        <td class="span6">

                            <small class=""><?php echo $user->role_name; ?></small>                    </td>
                    </tr>


                </tbody></table>
        </div>
        <div class="modal-footer">

            <a href="#" class="btn" data-dismiss="modal">Close</a>
        </div>
        
    </div>
        <?php } ?>
</div>
