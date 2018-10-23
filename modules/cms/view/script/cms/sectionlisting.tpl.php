
<div ng-class="icarusApp.views.animation" class="app">
<div class="app-view-header ng-scope">     <span class="capitalize">{{ sectionName }}</span>

<button ng-click="modalOpen()" class="pull-right btn btn-primary"  ng-repeat="op in subData[0].opertations" ng-if="op == 'add'">Add <span class="capitalize">{{ sectionName }}</span></button>


 </div>

 <div class="alert alert-danger text-center alert-failure-div" role="alert" style="display: none">
    <p></p>
</div>
<div class="alert alert-success text-center alert-success-div" role="alert" style="display: none">
    <p></p>
</div>
<div class="panel-group">
  <h3 class="text-center text-info">{{loading}}</h3>
 <form class="form-inline">
   <div class="table-responsive">
        <table datatable="ng" id="dTable" class="row-border hover  animated fadeInLeft2  table table-bordered table-hover bg-white">
            <thead>
            <tr>
                <th ng-repeat="y in subData[0].listColumns" valign="middle">{{subData[0].columns[y].name}}</th>

                 <th ng-if="subData[0].relations" valign="middle"  ng-repeat="(key,value) in subData[0].relations">
                       {{key}}
                </th>
                <th  ng-if="subData[0].opertations.length>0" valign="middle">Operations</th>
            </tr>
            </thead>
            <tbody>


            <tr ng-repeat="x in lists | orderBy: subData[0].listColumns[2]">
                <td ng-repeat="y in subData[0].listColumns" ng-bind-html="x[y]"></td>

                <!--  <td ng-repeat="y in subData[0].listColumns">{{x[y]==1 && y=='plan_status'?'Active':x[y]}}</td> -->


                <td ng-if="subData[0].relations" ng-repeat="(key,value) in subData[0].relations">
                    <span  ng-bind-html="x[key]"></span>
                   <a href="cms?parent_section={{ section }}&parent_id={{x[subData[0].keyColumn]}}&section={{value.section}}"> Manage </a>

                </td>

                 <td ng-if="subData[0].opertations.length>0">
                     <div class="wid145">
                    <button ng-repeat="op in subData[0].opertations" ng-if="op != 'add'" type="button" ng-click="actionClick($event,$index,op,x,subData[0].keyColumn);" class="btn btn-sm btn-info ng-scope"  ng-class="{'button-edit': op == 'edit' , 'button-delete': op == 'delete',
                    'button-view': op == 'view','button-information': op == 'publish'} "><i  class="fa" ng-class="{'fa-edit': op == 'edit' , 'fa-trash-o': op == 'delete',
                    'fa-eye': op == 'view', 'fa-check-circle': op == 'publish'} "></i></button>
                    </div>
                </td>

            </tr>
            </tbody>
        </table>
        </div>
    </form>
  </div>




<script type="text/ng-template" id="/detail.html">
<md-dialog>
  <form ng-cloak>
    <md-toolbar>
      <div class="md-toolbar-tools">
        <h2>Details</h2>
        <span flex></span>
        <md-button class="md-icon-button" ng-click="cancel()">
          <md-icon aria-label="Close dialog"><i class="fa fa-times"></i></md-icon>
        </md-button>
      </div>
    </md-toolbar>
    <md-dialog-content>
      <div class="md-dialog-content">
         <form class="form-inline">

           <table class="table pop_table table-bordered table-hover table-condensed">


              <tr ng-repeat="(key,value) in lists1">

                <td>{{subData1[0].columns[key].name}}</td>


                  <td ng-bind-html="value"></td>

            </tr>

        </table>



    </div>

      </div>
    </md-dialog-content>

  </form>
</md-dialog>

</script>





<!-- <div  class="modal" id="popup" ng-show="showDetails"> -->
<script type="text/ng-template" id="/myModalContent.html">

 <div class="modal-header" ><h4 id="myModalLabel" class="modal-title">{{actiontext}} {{ section }} </h4><span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span></div>
 <div class="modal-body">
  <form name="userForm" novalidate>
 <div ng-repeat="datasub in subData">
    <div ng-repeat="op in subData[0].opertations" ng-if="op == 'edit'">

                    <div class="form-group" ng-repeat="(key, value) in datasub.columns | orderBy:key:true">

                        <div ng-if="value.editoptions.type != 'hidden'  && value.editoptions.type && value.editoptions.type!='false'">
                        <label ng-if="value.editoptions.type != 'hidden'  && value.editoptions.type  && value.editoptions.type!='false'">{{ value.name }}</label>
                        </div>
                         <div ng-if="value.editoptions.type == 'textarea'">
                             <textarea class="form-control" id="{{ key }}" name="{{ key }}" ng-model="tempDetails[key]" required> </textarea>
                               <span class="help-block text-danger" data-ng-show="userForm.$invalid && userForm.$dirty">
                               <!-- {{getError(userForm.$error, 'key')}}-->
                               <span ng-show="userForm.{{ key }}.$error.required && !userForm.{{ key }}.$pristine">{{ value.name }} is required.</span>
                                </span>
                         </div>


                          <div ng-if="value.editoptions.type == 'htmlEditor'">

                             <!-- Wysiswyg editor-->
                             <summernote  id="{{ key }}" name="{{ key }}" ng-model="tempDetails[key]" required height="280"></summernote>
                            <!--  <summernote airmode="" ng-model="tempDetails[key]" class="well reader-block"></summernote> -->
                               <span class="help-block text-danger" data-ng-show="userForm.$invalid && userForm.$dirty">
                                <span ng-show="userForm.{{ key }}.$error.required && !userForm.{{ key }}.$pristine">{{ value.name }} is required.</span>
                              </span>
                         </div>



                         <div ng-if="value.editoptions.type == 'datepicker'">

                          <div class="input-group">
                          <input  type="text" uib-datepicker-popup="{{format}}" ng-model="dt" is-open="dateOpened" min-date="false" max-date="false" uib-datepicker-options="dateOptions" date-disabled="disabled(date, mode)" close-text="Close"
                          class="form-control" />
                          <span class="input-group-btn">
                          <button type="button" ng-click="open($event)" class="btn btn-default">
                          <em class="fa fa-calendar"></em>
                          </button>
                          </span>

                          </div>

                               <span class="help-block text-danger" data-ng-show="userForm.$invalid && userForm.$dirty">
                                <span ng-show="userForm.{{ key }}.$error.required">{{ value.name }} is required.</span>
                              </span>
                         </div>


                          <div ng-if="value.editoptions.type != 'textarea' && value.editoptions.type != 'select'">

                        <input type="textbox" ng-if="value.editoptions.type == 'textbox'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" class="form-control" ng-model="tempDetails[key]" required="">
                        <input type="password" ng-if="value.editoptions.type == 'password'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" class="form-control" ng-model="tempDetails[key]" required="">
                        <input type="hidden" ng-if="value.editoptions.type == 'hidden'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" class="form-control" ng-model="tempDetails[key]">
                        <input type="file" ng-if="value.editoptions.type == 'file'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" class="form-control" ng-model="tempDetails[key]">

                        <div ng-if="value.editoptions.type == 'file'" ng-bind-html="tempDetails[key]"></div>

                        <div ng-if="value.editoptions.type != 'hidden'  && value.editoptions.type">
                            <span class="help-block text-danger" ng-show="userForm.$dirty && userForm.$invalid">
                            <span ng-show="userForm.{{ key }}.$error.required && !userForm.{{ key }}.$pristine">{{ value.name }} is required.</span>
                            </span>
                         </div>
                        </div>


                         <div ng-if="value.editoptions.type == 'select' && value.editoptions.source!=''">
                            <select class="required form-control m-b"  id="{{ key }}" name="{{ key }}" ng-model="tempDetails[key]">
                                <option ng-repeat="(key2, value2) in value.editoptions.source" value="{{key2}}">{{value2}}</option>

                            </select>
                            <span class="help-block text-danger" data-ng-show="userForm.$invalid && userForm.$dirty">
                            <span ng-show="userForm.{{ key }}.$error.required  && !userForm.{{ key }}.$pristine">{{ value.name }} is required.</span>
                            </span>
                        </div>



  </div>





        </div>

    <div class="modal-footer">
<button ng-click="modalCancel()" class="btn btn-secondary">Cancel</button>
<button data-loading-text="Saving..."  ng-disabled="userForm.$invalid" ng-hide="tempDetails.{{subData[0].keyColumn}}" type="submit" class="btn btn-primary submitButton jqSubmitForm" ng-click="addUser(subData[0].keyColumn);modalCancel();">Save</button>
<button ng-disabled="userForm.$invalid" data-loading-text="Updating..." ng-hide="!tempDetails.{{subData[0].keyColumn}}" type="submit" class="btn btn-primary" ng-click="updateUser(subData[0].keyColumn);modalCancel();">Update</button>


</div>
 </form>

</div>
</script>
<script type="text/javascript"> $('#dTable').DataTable();</script>
