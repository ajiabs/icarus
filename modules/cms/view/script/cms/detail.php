<?php
session_start();
?>
<style>
.bg-primary,md-toolbar.md-default-theme:not(.md-menu-toolbar), md-toolbar:not(.md-menu-toolbar),.modal-header {
  background-color: {{myColor}};
  color: #dce0f3;
}
.md-confirm-button{
  color: #ffffff !important;
  background-color: {{myColor}}!important;
  border-color:{{myColor}}!important;
}
#bg-white .nav > li:hover > a, .bg-white .nav > li:hover > a, #bg-white .nav > li.active > a, .bg-white .nav > li.active > a{
  background-color : {{myColor}};
}

.modal-footer {
    border:none !important;
}
</style>

<?php
error_reporting(0);
$parent_section = ""; if($_REQUEST['parent_section']==''){$parent_section=-1;}else{$parent_section=$_REQUEST['parent_section'];}?>
<?php $parent_id = ""; if($_REQUEST['parent_id']==''){$parent_id=-1;}else{$parent_id=$_REQUEST['parent_id'];}?>

<div ng-controller="sectionlistController" ng-init="init('<?php echo $_REQUEST['section'];?>','<?php echo $parent_section;?>',<?php echo $parent_id;?>)">
<section class="ng-scope" ng-if="cmAction != true" >
<div class="app-view-header mb0 ng-scope">

      <div class="subdatadetails">
        <span class="capitalize pull-left">{{ sectionTitle }}</span>
        <div class="pull-right">
        <!--   href="cms#/<?php echo $_REQUEST['parent_section'];?>"   -->
          <?php if($_REQUEST['parent_section']!=''){?> <a href="#" onclick="javascript:window.history.back();" class="btn btn-sm btn-default tooltiplink"  uib-tooltip="Back" style="margin-left:10px"><i class="fa fa-arrow-left"></i></a> <?php }?>


            <button ng-click="modalOpen()" class="btn btn-sm btn-primary tooltiplink addpop"  uib-tooltip="Add New " ng-style="{'background-color':myColor,'border-color':myColor}"  ng-repeat="op in subData[0].opertations" ng-if="op == 'add'"><i class="fa fa-plus"></i> Add New <span class="capitalize"> </span></button>
        <!--     <button  ng-click="exportData()" class="btn btn-sm btn-primary tooltiplink"  uib-tooltip="Export"  ng-style="{'background-color':myColor,'border-color':myColor}"  ng-if="lists.length>0"><i class="fa fa-file-excel-o"></i> </button> -->
        </div>
        <div class="clearfix"></div>
       <div id="export" style="display:none">
          <button  class="pull-right btn btn-primary" ng-style="{'background-color':myColor,'border-color':myColor}">Export</button>
        </div>
      </div>
    </div>
  <div ng-class="icarusApp.views.animation" class="app">


    <div id="popup" class="modal"  style="display:none;background-color: rgba(0,0,0,0.5);">
    <div class="ng-isolate-scope in animated fadeInRight" >
      <div  class="modal-dialog">
        <div  class="modal-content">
          <div class="modal-header"  ng-style="{'background-color':myColor,'border-color':myColor}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-title"><h4></h4>
                <span  data-dismiss="modal" aria-hidden="true" class="close jqCloseButton"><i class="fa fa-times"></i></span>
              </div>
          </div>
          <div class="modal-body" id="popupBody">
          </div>
          <div class="modal-footer">
          </div>
        </div>
       </div>
     </div>
    </div>

    <div id="my-element"></div>

    <div class="subdatadetails">

      <div ng-if="subData[0].dateRange">
        <button ng-repeat="dr in subData[0].dateRange" ng-click="reportActions(dr)" class="btn btn-primary mr capitalize" ng-style="{'background-color':myColor,'border-color':myColor}">{{dr}}</button>
      </div>

      <div class="alert alert-danger text-center alert-failure-div" role="alert" style="display: none">
          <p></p>
      </div>

      <div class="alert alert-success text-center alert-success-div" role="alert" style="display: none">
          <p></p>
      </div>

      <div class="panel-group">
        <h3 class="text-center text-primary" ng-style="{'color':myColor}" ng-bind-html="loading"></h3>
        <form class="form-inline" ng-if="subData[0].listColumns">
          <div class="container static_content_top" style="width:100%">


              <div class="col-md-7 select-line">
                      <!--     <div class="input-group input-group-sm">
                        <select class="form-control" ng-model="selectedOption">
                           <option value="">Bulk action</option>
                           <option value="delete">Delete</option>
                           <option value="clone">Clone</option>
                           <option value="export">Export</option>
                        </select>
                        <span class="input-group-btn">
                           <button class="btn btn-sm btn-primary applybtn" ng-click="multifuction($event,selectedOption);">Apply</button>
                        </span>
                     </div>-->
                  </div>
                 <!--  <div class="col-md-1 select-line">
                     <p><label>Page </label> {{ currentPage }}</p>
                  </div> -->
                  <div class="col-md-2 select-line input-group-sm ">
                        <select class="form-control wid100per" name="searchField" id="searchField" ng-model="searchField" ng-init="setSearchBox();" ng-change="searchData(searchField,q);">
                            <option ng-repeat="y in subData[0].listColumns" ng-if="subData[0].columns[y].searchable" value="{{y}}">
                                {{subData[0].columns[y].name}}</option>
                        </select>
                  </div>
                  <div class="col-md-3 select-line input-group-sm no-padding-sides" id="searchFieldContents">
                        <select style="display:none;" name='q' ng-model='q' id='search1' class='form-control wid100per' ng-change='searchData(searchField,q);'>
                          <option value="">Choose value</option>
                          <option ng-repeat='x in statusvals'>{{x}}</option>
                        </select>
                        <input type="text" name="q" ng-model="q" id="search2" class="form-control wid100per" ng-change="searchData(searchField,q);" placeholder="{{placeholder}}">

                        <!-- <input type="date" class="form-control pull-right" placeholder="Date"  value="" id="enda_date" name="enda_date">  -->

                  </div>
                 <!-- <div class="col-md-2 text-right select-line input-group-sm">

                    <input type="number" step="10" min="10" max="100" class="form-control" ng-model="pageSize">
                  </div>-->
                  <div class="clearfix"></div>

                </div>
                <br/>

          <div id="myProgress" style="display:none">
            <div id="myBar"></div>
          </div>

          <div id="no-data" ng-if="lists.length<=0">
            <div id="no-datatxt" class="container container-lg animated fadeInDown">
              <div class="panel">
                <div class="panel-body">
                  <p class="text-center">No details found</p>
                  <style ng-if="lists.length<=0">.loading{display:none;}</style>
                </div>
              </div>
            </div>
          </div>
          <div class="panel panel-default">
           <div class="table-responsive" ng-if="lists.length>0">

                <table ng-table="table.tableParams4" export-csv="csv" id="MyInquires" class="row-border rtable hover  animated fadeInLeft2  table table-bordered table-hover table-striped bg-white">
                    <thead>
                    <tr>
                       <!--  <th ng-repeat="y in subData[0].listColumns" valign="middle">{{subData[0].columns[y].name}}</th> -->
                      <!--   <th check-all="check-all">
                           <div data-toggle="tooltip" data-title="Check All" class="checkbox c-checkbox tblrowcheck">
                              <label>
                                 <input type="checkbox" checked="true" />
                                 <span class="fa fa-check"></span>
                              </label>
                           </div>
                        </th>  -->
                      <th ng-repeat="y in subData[0].listColumns"  valign="middle" >
                         <a  ng-if="subData[0].columns[y].sortable" ng-click="sortFunc(y,reverseSort);">
                       <!--  <a class="tooltiplink"  uib-tooltip="Sort by {{subData[0].columns[y].name}}" ng-if="subData[0].columns[y].sortable" ng-click="sortFunc(y,reverseSort);"> -->
                       <span class="pull-left">{{subData[0].columns[y].name}} </span>
                       <!-- <span ng-hide="orderByField == '{{y}}'" class="fa fa-sort pull-right" style="width:10%"></span>  -->
                      <span ng-show="orderByField == '{{y}}' && !reverseSort" class="fa fa-caret-down pull-right"></span>
                      <span ng-show="orderByField == '{{y}}' && reverseSort" class="fa fa-caret-up pull-right"></span>
                        </a> <span  ng-if="!subData[0].columns[y].sortable">{{subData[0].columns[y].name}}</span> </th>

                         <th ng-if="subData[0].relations" valign="middle"  ng-repeat="(key,value) in subData[0].relations">
                               {{value.name}}
                        </th>
                        <th  ng-if="subData[0].opertations.length>0" valign="middle">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                      <!--  <tr ng-repeat="x in lists | orderBy: subData[0].listColumns[2]">-->
                       <!--  <tr ng-repeat="x in lists | orderBy:orderByField:reverseSort">-->
                     <tr on-finish-render="ngRepeatFinished" dir-paginate="x in lists | orderBy:orderByField:reverseSort | filter:searchObj | itemsPerPage: pageSize " current-page="currentPage">
                          <!--   <td>
                           <div class="checkbox c-checkbox">
                              <label>
                                 <input type="checkbox" checked="true" />
                                 <span class="fa fa-check"></span>
                              </label>
                           </div>
                        </td>      -->
                          <td class="hide">{{pIndex = $index}}</td>

                          <td ng-repeat="y in subData[0].listColumns" ng-bind-html="y.includes('status') ? (statusText(x[y],y)) :  x[y]">  </td>
                          <!-- <td ng-repeat="y in subData[0].listColumns" ng-bind-html="y.includes('status') ? ( x[y]== 1 ?'Active':'Inactive' ) :  x[y]">  </td> -->

                          <td ng-if="subData[0].relations" ng-repeat="(key,value) in subData[0].relations">
                          <span ng-if="!subData[0].relations.ad_slot_files" ng-bind-html="x[key]"></span>

                          <a href="cms#/{{ section }}/&parent_section={{ section }}&parent_id={{x[subData[0].keyColumn]}}&section={{value.section}}"> Manage <span ng-if="subData[0].relations.ad_slot_files">Images<span></a>

                          </td>
                         <td ng-if="subData[0].opertations.length>0">
                             <div class="wid12`0">
                            <button ng-repeat="op in subData[0].opertations" ng-if="op != 'add'" type="button" ng-click="actionClick($event,$index,op,x,subData[0].keyColumn,pIndex);" class="btn btn-sm btn-info ng-scope"  ng-class="{'button-view': op == 'view','button-edit': op == 'edit' , 'button-delete': op == 'delete',
                            'button-information': op == 'publish'} "><i  class="fa tooltiplink"  uib-tooltip="{{op}}" ng-class="{'fa-eye': op == 'view','fa-edit': op == 'edit' , 'fa-trash-o': op == 'delete',
                             'fa-check-circle': op == 'publish'} "></i></button>
                            </div>
                        </td>
                    </tr>
                    <tr ng-show="(lists | filter:searchObj).length == 0"><td colspan="{{subData[0].listColumns.length + subData[0].relations.length + 1}}" class="text-center">No results</td></tr>
                    </tbody>
                </table>
                </div>
              </div>
        </form>
    </div>
</div>


<script type="text/ng-template" id="/detail.html">
<md-dialog>
  <form ng-cloak>
    <md-toolbar  ng-style="{'background-color':myColor,'border-color':myColor}">
      <div class="md-toolbar-tools"  ng-style="{'background-color':myColor,'border-color':myColor}">
        <h2 ng-repeat="header in subData1[0].detailHeaderColumns"> {{subData1[0].detailHeaderColumnPrefix}} :: {{lists1[header]}}</h2>
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

                <tr ng-repeat="(key,value) in lists1"  ng-if="subData1[0].columns[key].editoptions.type!='hidden' && subData1[0].columns[key].editoptions.type!='password' && subData1[0].columns[key].editoptions.type && subData1[0].columns[key].editoptions.type!='false'">


                    <td>{{subData1[0].columns[key].name}}</td>

                    <td ng-bind-html="key.includes('status') ||  key.includes('enabled') || ( key.includes('conference') &&  key != 'conference_image_id') ? ( statusText2(value,key) ) :  value"></td>
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
 <div class="modal-header"  ng-style="{'background-color':myColor,'border-color':myColor}"><h4 id="myModalLabel" class="modal-title">{{actiontext}} {{ sectionTitle }} </h4><span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span></div>
 <div class="modal-body" ng-form="myForm">
  <form name="userForm" class="form-validate"  novalidate enctype="multipart/form-data">
 <div ng-repeat="datasub in subData">

    <div ng-repeat="op in subData[0].opertations" ng-if="op == 'edit'">
    <div class="form-group-pop popthumb" ng-class=" (value.editoptions.type == 'hidden' || value.editoptions.type == '' || value.editoptions.type == 'false' || value.editoptions.type == 'tags' || value.editoptions.type == 'file' || value.editoptions.type == 'textarea' || value.editoptions.type == 'htmlEditor' ? 'col-md-12' : 'col-md-6')" ng-repeat="(key, value) in datasub.columns | orderBy:key:true">
      <div ng-if="value.editoptions.type != 'hidden'  && value.editoptions.type && value.editoptions.type != 'false'">
        <label ng-if="value.editoptions.type != 'hidden' && value.editoptions.type  && value.editoptions.type!='false'">{{ value.name }} {{value.editoptions.type == 'file' ? '(allowed formats - gif, jpeg, jpg, png, bmp)' : '' }}</label>

            <span ng-if="value.editoptions.validations.includes(required) == false" class="text-danger">*<span>

         <a ng-if="value.editoptions.hint" href="javasript:void(0)" class="tooltiplink"  uib-tooltip="{{value.editoptions.hint}}">
            <span class="fa-exclamation-circle fa"><span>
            </a>
        </div>
         <div ng-if="value.editoptions.type == 'textarea'">
             <textarea placeholder="{{ value.name }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" id="{{ key }}" name="{{ key }}" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')"> </textarea>
              <p class="height-class">
               <span class="help-block text-danger" data-ng-show="userForm.$invalid && userForm.$dirty">
               <!-- {{getError(userForm.$error, 'key')}}-->
              <!-- <span ng-show="userForm.{{ key }}.$error.required && !userForm.{{ key }}.$pristine">{{ value.name }} is required.</span>-->
                </span>
              </p>
         </div>
          <div ng-if="value.editoptions.type == 'htmlEditor'">
             <!-- Wysiswyg editor-->

             <summernote  id="{{ key }}" name="{{ key }}" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')" height="280" ></summernote>
            <!--  <summernote airmode="" ng-model="tempDetails[key]" class="well reader-block"></summernote> -->

         </div>

       <div ng-if="value.editoptions.type == 'datepicker'">

        <div class="input-group">

          <input  type="text" uib-datepicker-popup="{{format}}" ng-model="tempDetails[key]" is-open="dateOpened" min-date="false" max-date="false" uib-datepicker-options="dateOptions" date-disabled="disabled(date, mode)" close-text="Close"
          class="form-control" required ="">
          <span class="input-group-btn">
            <button type="button" ng-click="dateOpened=true;$event.stopPropagation();" class="btn btn-default">
            <em class="fa fa-calendar"></em>
            </button>
          </span>
        </div>
        <p class="height-class">
             <span class="help-block text-danger" data-ng-show="userForm.$invalid && userForm.$dirty">
             <!-- <span ng-show="userForm.{{ key }}.$error.required">{{ value.name }} is required.</span>
               <span ng-show="userForm.{{ key }}.$invalid && !userForm.{{ key }}.$pristine">Enter a valid format.</span>-->
            </span>
        </p>
       </div>


        <div ng-if="value.editoptions.type != 'textarea' && value.editoptions.type != 'select'">
              <input type="textbox" ng-if="value.editoptions.validations[1]!='email' && value.editoptions.validations[1]!='url' && value.editoptions.validations[1]!='number' && value.editoptions.validations[1]!='digits' && value.editoptions.type == 'textbox'" autocomplete="off" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
              <input type="email" ng-if="value.editoptions.validations[1]=='email' && value.editoptions.type == 'textbox'" autocomplete="off" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
              <input type="url" ng-if="value.editoptions.validations[1]=='url' && value.editoptions.type == 'textbox'" autocomplete="off" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
              <input type="number" min="1" string-to-number ng-if="value.editoptions.validations[1]=='number' && value.editoptions.type == 'textbox'" autocomplete="off" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
              <input type="number" min="1" string-to-number ng-if="value.editoptions.validations[1]=='digits' && value.editoptions.type == 'textbox'" autocomplete="off" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
              <input type="password" ng-if="value.editoptions.type == 'password'" autocomplete="off" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
              <input type="text" ng-if="value.editoptions.type == 'disabled'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]" disabled>
              <input type="hidden" ng-if="value.editoptions.type == 'hidden'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]">

              <!--<input type="text" ng-if="value.editoptions.type == 'false'" placeholder="{{ value.name }}" id="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control' : 'form-control')" ng-model="tempDetails[key]">-->
              <input type="hidden" ng-if="value.editoptions.type == 'false'" placeholder="{{ value.name }}" id="{{ key }}" >

              <input type="file" id="userUpload" valid-file ng-if="value.editoptions.type == 'file'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control form-controlfilee' : 'form-control form-controlfilee')" ng-model="tempDetails[key]" file-model="tempDetails[key]" data-number="{{statusNo(key)}}"  accept="image/gif, image/jpeg, image/jpg,  image/png,  image/bmp" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
              <!--<p>Input is valid: {{myForm.userUpload.$valid}}
              <br>Selected file: {{tempDetails[key]}}</p>-->

              <!--<input type="file" ng-if="value.editoptions.type == 'file'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-class=" (value.editoptions.class != '' ? '{{value.editoptions.class}} form-control form-controlfilee' : 'form-control form-controlfilee')" file-model="tempDetails[key]" ng-model="tempDetails[key]"  ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')"  accept="image/gif, image/jpeg, image/jpg, image/png, image/bmp, application/pdf, video/wmv">-->

              <!--<input type="text" ng-model="tempDetails[key]" ng-if="value.editoptions.type == 'file'" ng-show="tempDetails.{{subData[0].keyColumn}}" value="{{tempDetails.external_artworks_image1_id}}">-->

              <input type="checkbox" ng-if="value.editoptions.type == 'checkbox'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-model="tempDetails[key]" ng-true-value="1" ng-false-value="0" ng-checked="{{ tempDetails[key] }}">
              <input type="radio" ng-if="value.editoptions.type == 'radio'" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" ng-model="tempDetails[key]" ng-checked="{{ tempDetails[key] }}">
              <div ng-if="value.editoptions.type == 'file'" ng-bind-html="tempDetails[key]"></div>
              <div ng-if="value.editoptions.type != 'hidden'  && value.editoptions.type">
                  <p class="height-class">
                  <span class="help-block text-danger" ng-show="userForm.$dirty && userForm.$invalid">
                  <!--<span ng-show="userForm.{{ key }}.$error.required && !userForm.{{ key }}.$pristine">{{ value.name }} is required.</span>
                  <span ng-show="userForm.{{ key }}.$invalid && !userForm.{{ key }}.$pristine">Enter a valid format.</span>-->
                  </span>
                  </p>
               </div>
                <div ng-if="value.editoptions.type == 'file'">
                <!--<input type="text" id="dvPreviewVal{{$index}}" placeholder="{{ value.name }}" id="{{ key }}" name="{{ key }}" class="form-controlfileeval" ng-model="tempDetails[key]"  ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')" value="">
                <input type="text" class="form-controlfileevaltext" value="">-->
                <div class="dvPreview" id="dvPreview{{$index}}"></div>
                <!--<i class='fa fa-trash-o removedv' style='display:none' ng-click='removedv($index);' title='Remove' data-placement='left'></i>-->
                <p class="height-class">
                  <span class="help-block text-danger" id="fileerror"></span>
                </p>
                </div>
               <ui-select ng-if="value.editoptions.type == 'tags'" multiple="" ng-model="tempDetails[key]" theme="bootstrap">
                         <ui-select-match placeholder="{{value.editoptions.tagDetails.placeholder}}">{{$item.name}}</ui-select-match>
                         <ui-select-choices repeat="tags in availableTags | filter:$select.search">{{tags.name}}</ui-select-choices>
                </ui-select>
          </div>
         <div ng-if="value.editoptions.type == 'select' && value.editoptions.source!=''">
              <select class="required form-control m-b"  id="{{ key }}" name="{{ key }}" ng-options="k as v for (k, v) in value.editoptions.source"  ng-model="tempDetails[key]" ng-required="(value.editoptions.validations.includes(required) == false ? 'required' : '')">
                  /*<option ng-repeat="(key2, value2) in value.editoptions.source" value="{{key2}}">{{value2}}</option>*/
                <span ng-hide="!tempDetails.{{subData[0].keyColumn}}">
                <option style="display:none" value="" ng-hide="!tempDetails.{{subData[0].keyColumn}}">Select option</option>
                </span>
              </select>
              <p class="height-class">
              <span class="help-block text-danger" data-ng-show="userForm.$invalid && userForm.$dirty">
              <!--<span ng-show="userForm.{{ key }}.$error.required  && !userForm.{{ key }}.$pristine">{{ value.name }} is required.</span>-->
              </span>
              </p>

         </div>
      </div>
      <div class="clearfix"></div>
    </div>

    <div class="clearfix"></div>
    <div class="modal-footer">

        <button ng-click="modalCancel()" class="btn btn-secondary">Cancel</button>
      <button data-loading-text="Saving..."  ng-disabled="userForm.$invalid" ng-hide="tempDetails.{{subData[0].keyColumn}}" type="submit" class="btn btn-primary submitButton jqSubmitForm" ng-style="{'background-color':myColor,'border-color':myColor}" ng-click="addGen(subData[0].keyColumn);modalCancel();">Save</button>
      <button ng-disabled="userForm.$invalid" data-loading-text="Updating..." ng-hide="!tempDetails.{{subData[0].keyColumn}}" type="submit" class="btn btn-primary" ng-style="{'background-color':myColor,'border-color':myColor}" ng-click="updateGen(subData[0].keyColumn);modalCancel();">Update</button>
    </div>
 </form>
<div>
</script>


<div class="subdatadetails">
<div ng-if="settings[0].label" class="panel panel-default">
        <uib-tabset>
            <uib-tab ng-repeat="la in settings" heading="{{la.label}}">
                <form name="settingsForm" id="settingsForm" novalidate>
                  <div ng-repeat="tc in la.tabContent">
                    <label class="control-label" for="{{tc.settinglabel}}">{{tc.settinglabel}} &nbsp;
                    <a ng-if="tc.hint" href="#" class="tooltiplink"  uib-tooltip="{{tc.hint}}">
                    <span class="fa-exclamation-circle fa"><span>
                    </a>
                    </label>

                   <!-- <input ng-if="tc.type == 'checkbox' && tc.value == 1" ng-model="0" type="text" name="{{tc.vLookUp_Name}}{{tc.settingfield}}" value="0" />-->

                    <input type="checkbox" ng-if="tc.type == 'checkbox'"  ng-init="tc.value=tc.value=='true'?true:false"  ng-change="updateActive(tc.value)"  class="jqSettingCheckbox"  id="{{tc.vLookUp_Name}}{{tc.settingfield}}" ng-model="tc.value" name="{{tc.vLookUp_Name}}{{tc.settingfield}}" >

                    <textarea class="form-control"  ng-if="tc.type == 'textarea'" name="{{tc.settingfield}}" id="{{tc.settingfield}}" ng-model="tc.value"></textarea>
                    <input type="hidden" ng-if="tc.type == 'link'"  name="{{tc.settingfield}}" ng-model="tc.value">
                    <input ng-if="tc.type == 'file'" type="file" class="form-control m-b"  id="{{tc.settingfield}}" name="{{tc.vLookUp_Name}}" ng-model="tc.value" fileread="tc.vLookUp_Value">
                    <input ng-if="tc.type == 'password'" type="password" class="form-control m-b"  id="{{tc.settingfield}}" name="{{tc.settingfield}}{{tc.vLookUp_Name}}" ng-model="tc.value" >
                    <input ng-if="tc.type == ''" type="text" class="form-control m-b"  id="{{tc.settingfield}}" name="{{tc.settingfield}}" ng-model="tc.value" required="">
                    <input ng-if="tc.type == 'email'" type="email" class="form-control m-b"  id="{{tc.settingfield}}" name="{{tc.settingfield}}" ng-model="tc.value" >
                    <input ng-if="tc.type == 'color'" type="color" id="html5colorpicker" ng-change="clickColor(tc.value)" ng-model="tc.value" ng-value="tc.value" style="display:block">
                    <div ng-if="tc.type == 'file'" class="control-group jq{{tc.parent_settingfield}}" >
                      <img ng-if="tc.value" id="blah" style="background:#ccc;padding:5px" class="img-thumbnail" src="project/files/{{tc.value}}">
                    </div>
                      <span class="help-block text-danger" data-ng-show="settingsForm.$invalid && settingsForm.$dirty">
                      <span ng-show="settingsForm.{{tc.settingfield}}.$error.required">{{tc.settinglabel}} is required.</span>
                      <span ng-show="settingsForm.{{tc.settingfield}}.$invalid && !settingsForm.{{tc.settingfield}}.$pristine">Enter a valid format.</span>
                    </span>
                  </div>
                  <br/>
                 <!--  <button class="cancelButton btn btn-secondary cancelButtonSettings" type="reset"  name="cancel"> Cancel </button> -->
                  <button class="submitButton btn btn-primary" type="submit"  ng-click="updatecmssettings();" ng-style="myCol"   name="submit"> Save </button>
            </form>
        </uib-tab>
    </uib-tabset>
</div>


<div ng-if="xsettings[0].label" class="panel panel-default">
        <uib-tabset>
            <uib-tab ng-repeat="la in xsettings" heading="{{la.label}}">
                <form name="settingsForm" id="settingsForm2" novalidate>
                  <div ng-repeat="tc in la.tabContent">
                    <label class="control-label" for="{{tc.settinglabel}}">{{tc.settinglabel}} &nbsp;
                    <a ng-if="tc.hint" href="#" class="tooltiplink"  uib-tooltip="{{tc.hint}}">
                    <span class="fa-exclamation-circle fa"><span>
                    </a>
                    </label>

                    <!--<input type="checkbox" ng-if="tc.type == 'checkbox'" ng-click="change(tc.vLookUp_Value)" ng-true-value="1" ng-false-value="0" class="jqSettingCheckbox"  id="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value" name="{{tc.vLookUp_Name}}" ng-checked="{{tc.vLookUp_Value  || tc.value}} == 1 || {{tc.vLookUp_Value  || tc.value}} == 'Y'"> -->

                    <input type="checkbox" ng-if="tc.type == 'checkbox'"  ng-init="tc.vLookUp_Value=tc.vLookUp_Value=='true'?true:false"  ng-change="updateActive(tc.vLookUp_Value)"  class="jqSettingCheckbox"  id="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value" name="{{tc.vLookUp_Name}}" >

                    <textarea class="form-control"  ng-if="tc.type == 'textarea'" name="{{tc.vLookUp_Name}}" id="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value"></textarea>
                    <input type="hidden" ng-if="tc.type == 'link'"  name="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value">
                    <input ng-if="tc.type == 'file'" type="file" class="form-control m-b"  id="{{tc.vLookUp_Name}}" name="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value" fileread="tc.vLookUp_Value">
                    <input ng-if="tc.type == 'password'" type="password" class="form-control m-b"  id="{{tc.vLookUp_Name}}" name="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value" >
                    <input ng-if="tc.type == ''" type="text" class="form-control m-b"  id="{{tc.vLookUp_Name}}" name="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value" required="">
                    <input ng-if="tc.type == 'email'" type="email" class="form-control m-b"  id="{{tc.vLookUp_Name}}" name="{{tc.vLookUp_Name}}" ng-model="tc.vLookUp_Value" >
                    <input ng-if="tc.type == 'color'" type="color" id="html5colorpicker" ng-change="clickColor(tc.vLookUp_Value)" ng-model="tc.vLookUp_Value" ng-value="tc.vLookUp_Value" style="display:block">
                    <div ng-if="tc.type == 'file'" class="control-group jq{{tc.parent_settingfield}}" >
                        <img ng-if="tc.vLookUp_Value" id="blah" style="background:#ccc;padding:5px" class="img-thumbnail" src="project/files/{{tc.vLookUp_Value}}">
                    </div>
                     <span class="help-block text-danger" data-ng-show="settingsForm.$invalid && settingsForm.$dirty">
                      <span ng-show="settingsForm.{{tc.vLookUp_Name}}.$error.required">{{ tc.settinglabel }} is required.</span>
                      <span ng-show="settingsForm.{{tc.vLookUp_Name}}.$invalid && !settingsForm.{{tc.vLookUp_Name}}.$pristine">Enter a valid format.</span>
                    </span>
                  </div>
                  <br/>
                  <!-- <button class="cancelButton btn btn-secondary cancelButtonSettings" type="reset"  name="cancel"> Cancel </button> -->
                  <button class="submitButton btn btn-primary" type="submit"  ng-click="updatesettings();" ng-style="{'background-color':myColor,'border-color':myColor}"   name="submit"> Save </button>
            </form>
        </uib-tab>
    </uib-tabset>
  </div>

  <div ng-if="manageroles.records">
    <div class="pull-right">
          <button ng-click="modalRoleOpen()"  style="margin-top:-40px" class="btn btn-sm btn-primary tooltiplink"  uib-tooltip="Add Roles" ng-style="{'background-color':myColor,'border-color':myColor}"><i class="fa fa-plus"></i>&nbsp;Add New</button>
          <!--<button  ng-click="exportRoleData()" class="btn btn-sm btn-primary tooltiplink"  uib-tooltip="Export" style="margin-top:-40px" ng-style="{'background-color':myColor,'border-color':myColor}"><i class="fa fa-file-excel-o"></i> </button>-->
        </div>
     <div class="clearfix"></div>
     <form class="form-inline">
        <div class="container" style="width:100%">
        <div class="row">
          <div class="col-md-12 select-line text-right">
              <input type="text" name="q" ng-model="q" id="search" class="form-control" placeholder="Search">
              <input type="hidden" min="1" max="100" class="form-control" ng-model="pageSize" value="25">
          </div>

          <?php /* <div class="col-md-4 select-line">
         <!--  <p><label>Page</label> {{ currentPage }}</p> -->
          </div>
          <div class="col-md-5 select-line input-group-sm">
          <input type="text" name="q" ng-model="q" id="search" class="form-control" placeholder="Search">
          </div>
          <div class="col-md-3 text-right select-line input-group-sm">
          <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
          </div> */ ?>

          <div class="clearfix"></div>
          </div>
        <br/>
      </div>
    </form>
     <div  class="panel panel-default">
           <table  class="row-border hover  animated fadeInLeft2 table table-bordered table-hover table-striped bg-white">
              <thead>
              <tr>
              <!-- RENDER LIST HEADER -->
              <th valign="middle" >Role ID</th>
              <th valign="middle" >Role Name</th>
              <th valign="middle" >Parent Role</th>
              <th valign="middle">Actions</th>
              </tr>
               </thead>
              <tbody>
               <tr on-finish-render="ngRepeatFinished" dir-paginate="r in manageroles.records | filter:q | itemsPerPage: pageSize" current-page="currentPage">
            <!--    <tr ng-repeat="r in manageroles.records"> -->
                  <td>{{r.role_id}}</td>
                  <td>{{r.role_name}}</td>
                  <td>{{r.parent_role_name}}</td>
                  <td>
                    <div class="wid145">
                    <button type="button" ng-click="actionClick($event,$index,'viewrole',r,r.role_id,pIndex);" class="btn btn-sm btn-info ng-scope button-view tooltiplink"  uib-tooltip="view">
                    <i class="fa fa-eye"></i></button>
                    <button type="button" ng-click="actionClick($event,$index,'editrole',r,r.role_id,pIndex);" class="btn btn-sm btn-info ng-scope button-edit tooltiplink"  uib-tooltip="edit">
                    <i class="fa fa-edit"></i></button>
                    <button type="button" ng-click="actionClick($event,$index,'deleterole',r,r.role_id,pIndex);" class="btn btn-sm btn-info ng-scope button-delete tooltiplink"  uib-tooltip="delete">
                    <i class="fa fa-trash-o"></i></button>
                    </div>
                </td>
              </tr>
              <tr ng-show="(manageroles.records | filter:q).length == 0"><td colspan="4" class="text-center">No results</td></tr>
              </tbody>
          </table>
  </div>


  <script type="text/ng-template" id="/addrole.html">
        <div class="modal-header"  ng-style="{'background-color':myColor,'border-color':myColor}">
                <h4 id="myModalLabel" class="modal-title">{{actiontext}} Role</h4>
                <span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span>
        </div>
        <div class="modal-body" ng-controller="sectionlistController">
          <form name="newrole" id="newrole" class="form-validate form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-blacklist ng-valid-pattern ng-valid-url ng-valid-minlength ng-valid-maxlength ng-invalid-validator">
                  <input type="hidden" name="role_id" id="role_id" ng-model="formData.role_id">
                  <div class="control-group">
                      <label for="vFirstName" class="control-label">Role Name <span class="text-danger ng-scope">*<span></label>
                      <div class="controls">
                          <input type="text" name="role_name"  class="form-control m-b"  id="role_name" ng-model="formData.role_name" required>
                      </div>
                  </div>
                  <div class="control-group">
                      <label for="vFirstName" class="control-label">Parent Role</label>
                      <div class="controls">
                          <select name="parent_role_id" id="parent_role_id" class="required form-control m-b" ng-model="formData.parent_role_id">
                              <option value="0" ng-selected ="r.role_id ==  formData.parent_role_id">Superadmin</option>
                              <option value="{{r.role_id}}"  ng-repeat="r in manageroles.records">{{r.role_name}}</option>
                          </select><br/>
                     </div>
                  </div>
                  <div class="modal-footer">
                      <button ng-click="modalCancel()" class="btn btn-secondary" tabindex="0">Cancel</button>
                      <button  ng-if="savetext" data-loading-text="Saving..."  ng-disabled="newrole.$invalid" type="submit" name="submit" ng-click="addRole();modalCancel();" class="submitButton btn btn-primary" ng-style="{'background-color':myColor,'border-color':myColor}">{{savetext}}</button>
                      <button  ng-if="updatetext" ng-disabled="newrole.$invalid" data-loading-text="Updating..." type="submit" class="btn btn-primary" ng-click="updateRole();modalCancel();" ng-style="{'background-color':myColor,'border-color':myColor}">{{updatetext}}</button>
                    </div>
                  </form>
          </div>
        </div>
  </script>


  <script type="text/ng-template" id="/detailrole.html">
        <md-dialog>
          <form ng-cloak>
            <md-toolbar  ng-style="{'background-color':myColor,'border-color':myColor}">
              <div class="md-toolbar-tools" ng-style="{'background-color':myColor,'border-color':myColor}">
                <h2>Details :: {{lists1.role_name}}</h2>
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
                        <tr>
                            <td>Role</td>
                            <td>{{lists1.role_name}}</td>
                        </tr>
                        <tr>
                            <td>Parent Role</td>
                            <td>{{lists1.parent_role_name}}</td>
                      </tr>
                  </table>
                </div>
              </div>
            </md-dialog-content>
          </form>
        </md-dialog>
  </script>


</div>

   <div ng-if="manageprivileges.records">
       <div class="pull-right">
          <button ng-click="modalPrivilageOpen()"  style="margin-top:-40px" class="btn btn-sm btn-primary tooltiplink"  uib-tooltip="Add Privilege" ng-style="{'background-color':myColor,'border-color':myColor}"><i class="fa fa-plus"></i>&nbsp;Add New</button>
          <!--<button  ng-click="exportPrivilageData()" class="btn btn-sm btn-primary tooltiplink"  uib-tooltip="Export" style="margin-top:-40px" ng-style="{'background-color':myColor,'border-color':myColor}"><i class="fa fa-file-excel-o"></i> </button>-->
        </div>
        <div class="clearfix"></div>
            <form class="form-inline">
          <div class="container" style="width:100%">
            <div class="row">
              <div class="col-md-12 select-line input-group-sm text-right">
              <input type="text" name="q" ng-model="q" id="search" class="form-control" placeholder="Search">
              </div>

              <?php /*<!--<div class="col-md-4 select-line">
                <p><label>Page</label> {{ currentPage }}</p>
              </div>-->
              <div class="col-md-8 select-line">&nbsp;</div>

              <div class="col-md-4 select-line input-group-sm pull-right">
              <input type="text" name="q" ng-model="q" id="search" class="form-control" placeholder="Search">
              </div>
              <!-- <div class="col-md-3 text-right select-line input-group-sm">
              <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
            </div> -->
              <div class="clearfix"></div>
              */ ?>

              </div>
            <br/>
          </div>
        </form>
        <div  class="panel panel-default">
          <table class="row-border hover  animated fadeInLeft2 table table-bordered table-hover table-striped bg-white">
            <thead>
               <tr>
                <!-- RENDER LIST HEADER -->
                <th>Type</th>
                <th>Section Name</th>
                <th>View</th>
                <th>Add </th>
                <th>Edit </th>
                <th>Delete </th>
                <th>Publish </th>
                <th class="span2 listingTableHeadTh">Actions</th>
            </tr>
            </thead>
            <tbody>
              <tr on-finish-render="ngRepeatFinished" dir-paginate="p in manageprivileges.records | filter:q | itemsPerPage: pageSize" current-page="currentPage">
                    <td>{{p.entity_type}}</td>
                    <td>{{p.enity_name}}</td>
                    <td>{{p.view_role_id}}</td>
                    <td>{{p.add_role_id}}</td>
                    <td>{{p.edit_role_id}}</td>
                    <td>{{p.delete_role_id}}</td>
                    <td>{{p.publish_role_id}}</td>
                    <td>
                      <div class="wid145">
                      <button type="button" ng-click="actionClick($event,$index,'viewprivilage',p,p.privilege_id,pIndex);" class="btn btn-sm btn-info ng-scope button-view tooltiplink"  uib-tooltip="view">
                      <i class="fa fa-eye"></i></button>
                      <button type="button" ng-click="actionClick($event,$index,'editprivilege',p,p.privilege_id,pIndex);" class="btn btn-sm btn-info ng-scope button-edit tooltiplink"  uib-tooltip="edit">
                      <i class="fa fa-edit"></i></button>
                      <button type="button" ng-click="actionClick($event,$index,'deleteprivilege',p,p.privilege_id,pIndex);" class="btn btn-sm btn-info ng-scope button-delete tooltiplink"  uib-tooltip="delete">
                      <i class="fa fa-trash-o"></i></button>
                      </div>
                    </td>
               </tr>
               <tr ng-show="(manageprivileges.records | filter:q).length == 0"><td colspan="8" class="text-center">No results</td></tr>
           </tbody>
          </table>
        </div>
        <!--<form class="form-inline">
      <div class="container" style="width:100%">
        <div class="row">
          <div class="col-md-4 select-line">
              <p><label>Page</label> {{ currentPage }}</p>
          </div>
          <div class="col-md-8 text-right select-line input-group-sm">
              <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
          </div>
          <div class="clearfix"></div>
          </div>
        <br/>
      </div>
    </form>-->
        <script type="text/ng-template" id="/addprivilage.html">
          <div class="modal-header"  ng-style="{'background-color':myColor,'border-color':myColor}">
                  <h4 id="myModalLabel" class="modal-title">{{actiontext}} Privilege</h4>
                  <span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span>
         </div>
         <div class="modal-body" ng-controller="sectionlistController">
            <form name="newprivilage" id="newprivilage" class="form-validate form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-blacklist ng-valid-pattern ng-valid-url ng-valid-minlength ng-valid-maxlength ng-invalid-validator">
                   <input type="hidden" name="privilege_id" id="privilege_id" ng-model="formData.privilege_id" value="{{formData.privilege_id}}">
                    <input type="hidden" name="publish_role_id" id="publish_role_id" ng-model="formData.publish_role_id" value="{{formData.publish_role_id}}">
                        <div class="control-group">
                            <label for="ventity_type" class="control-label">Select Group or Section <span class="text-danger ng-scope">*<span></label>
                            <div class="controls">
                                <select required name="entity_type" id="entity_type" class="required form-control m-b" ng-model="formData.entity_type" ng-change="getgroup_section()" ng-disabled="updatetext">
                                    <option value="">Select</option>
                                    <option value="group">Group</option>
                                    <option value="section">Section</option>
                                </select>
                                </div>
                        </div>

                        <div class="control-group jqSectionDiv" ng-if="sectionset">
                            <label for="vFirstName" class="control-label">Section <span class="text-danger ng-scope">*<span></label>
                            <div class="controls">
                             <input type="text"  class="required form-control m-b" name="section_entity_id" id="section_entity_id" ng-model="formData.section_entity_id" value="{{enity_name}}" ng-if="updatetext" readonly>
                                <select name="section_entity_id" id="section_entity_id" class="required form-control m-b" ng-model="formData.section_entity_id" ng-disabled="updatetext" ng-if="!updatetext">
                                    <option value="" ng-if="!updatetext">Select</option>
                                    <option value="{{s.section_name}}" ng-selected ="s.section_name ==  formData.section_entity_id " ng-repeat="s in managesections">{{s.section_name}}</option>
                                </select>
                                </div>
                        </div>
                        <div class="control-group jqGroupDiv" ng-if="groupset">
                            <label for="vFirstName" class="control-label">Group <span class="text-danger ng-scope">*<span></label>
                            <div class="controls">
                             <input type="text"  class="required form-control m-b" name="group_entity_id" id="group_entity_id" ng-model="formData.group_entity_id" value="{{enity_name}}" ng-if="updatetext" readonly>
                                <select name="group_entity_id" id="group_entity_id" class="required form-control m-b"  ng-model="formData.group_entity_id" ng-disabled="updatetext" ng-if="!updatetext">
                                    <option value=""  ng-if="!updatetext">Select</option>
                                     <option value="{{g.id}}"  ng-repeat="g in managegroups">{{g.group_name}}</option>
                                </select>
                                </div>
                        </div>
                        <div class="control-group">
                            <label for="vFirstName" class="control-label">View Privilege</label>
                            <div class="controls">
                            <select name="view_role_id" id="view_role_id" class="required form-control m-b"  ng-model="formData.view_role_id">
                                    <!--<option>{{formData.view_role_id}}</option>-->
                                    <option value="sadmin" ng-selected ="r.text ==  formData.view_role_id">sadmin</option>
                                    <option ng-repeat="r in manageroles" value="{{r.text}}"  ng-selected ="r.text ==  formData.view_role_id ">{{r.text}}</option>
                             </select>

                                </div>
                        </div>
                        <div class="control-group">
                            <label for="vFirstName" class="control-label">Add Privilege</label>
                            <div class="controls">
                                <select name="add_role_id" id="add_role_id" class="required form-control m-b"  ng-model="formData.add_role_id">
                                    <option value="sadmin" ng-selected ="r.text ==  formData.add_role_id">sadmin</option>
                                    <option value="{{r.text}}"  ng-repeat="r in manageroles" ng-selected ="r.text ==  formData.add_role_id ">{{r.text}}</option>
                                </select>
                               </div>
                        </div>
                        <div class="control-group">
                            <label for="vFirstName" class="control-label">Edit Privilege</label>
                            <div class="controls">
                                <select name="edit_role_id" id="edit_role_id" class="required form-control m-b"  ng-model="formData.edit_role_id">
                                    <option value="sadmin" ng-selected ="r.text ==  formData.edit_role_id">sadmin</option>
                                    <option value="{{r.text}}"  ng-repeat="r in manageroles" ng-selected ="r.text ==  formData.edit_role_id ">{{r.text}}</option>
                                </select>
                                </div>
                        </div>
                        <div class="control-group">
                            <label for="vFirstName" class="control-label">Delete Privilege</label>
                            <div class="controls">
                                <select name="delete_role_id" id="delete_role_id" class="required form-control m-b"  ng-model="formData.delete_role_id">
                                    <option value="sadmin" ng-selected ="r.text ==  formData.delete_role_id">sadmin</option>
                                    <option value="{{r.text}}"  ng-repeat="r in manageroles" ng-selected ="r.text ==  formData.delete_role_id ">{{r.text}}</option>
                                </select>
                                </div><br/>
                        </div>
                    <div class="modal-footer">
                        <button ng-click="modalCancel()" class="btn btn-secondary" tabindex="0">Cancel</button>
                        <button  ng-if="savetext" data-loading-text="Saving..."  ng-disabled="newprivilage.$invalid" type="submit" name="submit" ng-click="addPrevilage();modalCancel();" class="submitButton btn btn-primary" ng-style="{'background-color':myColor,'border-color':myColor}">{{savetext}}</button>
                        <button  ng-if="updatetext" ng-disabled="newprivilage.$invalid" data-loading-text="Updating..." type="submit" class="btn btn-primary" ng-click="updatePrevilage();modalCancel();" ng-style="{'background-color':myColor,'border-color':myColor}">{{updatetext}}</button>
                      </div>
                    </form>
            </div>
        </div>
        </script>



         <script type="text/ng-template" id="/detailprivilage.html">
      <md-dialog>
        <form ng-cloak>
          <md-toolbar  ng-style="{'background-color':myColor,'border-color':myColor}">
            <div class="md-toolbar-tools" ng-style="{'background-color':myColor,'border-color':myColor}">
              <h2>Privilege Details :: {{lists1.enity_name}}</h2>
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
                      <tr>
                          <td>Entity Name</td>
                          <td>{{lists1.enity_name}}</td>
                      </tr>
                      <tr>
                          <td>Entity Type</td>
                          <td>{{lists1.entity_type}}</td>
                    </tr>
                    <tr>
                          <td>View privilege </td>
                          <td>{{lists1.view_role_id}}</td>
                    </tr>
                    <tr>
                          <td>Add privilege </td>
                          <td>{{lists1.add_role_id}}</td>
                    </tr>
                    <tr>
                          <td>Edit privilege </td>
                          <td>{{lists1.edit_role_id}}</td>
                    </tr>
                     <tr>
                          <td>Delete privilege </td>
                          <td>{{lists1.delete_role_id}}</td>
                    </tr>
                     <tr>
                          <td>Publish </td>
                          <td>{{lists1.publish_role_id}}</td>
                    </tr>
                </table>
              </div>
            </div>
          </md-dialog-content>
        </form>
      </md-dialog>
      </script>

         <script type="text/ng-template" id="/customDate.html">
                      <div class="modal-header"  ng-style="{'background-color':myColor,'border-color':myColor}">
                              <h4 id="myModalLabel" class="modal-title">{{actiontext}}</h4>
                              <span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span>
                     </div>
                     <div class="modal-body" ng-controller="sectionlistController">
                        <form name="newprivilage" id="newprivilage" class="form-validate form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-blacklist ng-valid-pattern ng-valid-url ng-valid-minlength ng-valid-maxlength ng-invalid-validator">
                                       <div class="row">
                                        <div class="col-md-6">
                                        <label>From</label>
                                        <div class="input-group">

                                            <input  type="text" uib-datepicker-popup="{{format}}" ng-model="startDt" is-open="dateStart" min-date="false" max-date="false" uib-datepicker-options="dateOptions" date-disabled="disabled(date, mode)" close-text="Close"
                                            class="form-control" />
                                                <span class="input-group-btn">
                                                    <button type="button" ng-click="openStart($event)" class="btn btn-default">
                                                        <em class="fa fa-calendar"></em>
                                                    </button>
                                                </span>
                                        </div>
                                        </div>
                                         <div class="col-md-6">
                                        <label>To</label>
                                        <div class="input-group">

                                            <input  type="text" uib-datepicker-popup="{{format}}" ng-model="closeDt" is-open="dateClose" min-date="false" max-date="false" uib-datepicker-options="dateOptions" date-disabled="disabled(date, mode)" close-text="Close"
                                            class="form-control" />
                                            <span class="input-group-btn">
                                                <button type="button" ng-click="openClose($event)" class="btn btn-default">
                                                <em class="fa fa-calendar"></em>
                                                </button>
                                            </span>
                                        </div>
                                         </div>
                                         </div><br/>
                                        <div class="modal-footer">
                                    <button ng-click="modalCancel()" class="btn btn-secondary" tabindex="0">Cancel</button>
                                    <button  data-loading-text="Saving..."  ng-disabled="newprivilage.$invalid" type="submit" name="submit" ng-click="fetchReportsFromRange(startDt,closeDt);modalCancel();" class="submitButton btn btn-primary" ng-style="{'background-color':myColor,'border-color':myColor}">Update</button>
                                  </div>
                                </form>
                        </div>
                    </div>
                    </script>

    </div>


    <div ng-if="manageusers.records">
        <div class="pull-right">
          <button ng-click="modalUsersOpen()"  style="margin-top:-40px" class="btn btn-sm btn-primary tooltiplink"  uib-tooltip="Add Users" ng-style="{'background-color':myColor,'border-color':myColor}"><i class="fa fa-plus"></i>&nbsp;Add New</button>
          <!--<button  ng-click="exportUsersData()" class="btn btn-sm btn-primary tooltiplink"  uib-tooltip="Export" style="margin-top:-40px" ng-style="{'background-color':myColor,'border-color':myColor}"><i class="fa fa-file-excel-o"></i> </button>-->
        </div>
          <div class="clearfix"></div>
            <form class="form-inline">
          <div class="container" style="width:100%">
            <div class="row">
              <div class="col-md-12 select-line text-right">
              <input type="text" name="q" ng-model="q" id="search" class="form-control" placeholder="Search">
              <!--  <select class="form-control" name="searchField" id="searchField" ng-model="searchField"><option ng-repeat="u in subData[0].listColumns" ng-if="subData[0].columns[u].searchable" value="{{subData[0].columns[u].name}}">{{subData[0].columns[u].name}}</option></select> -->
              </div>
              <div class="clearfix"></div>
              </div>

            <?php /* <div class="row">
              <div class="col-md-4 select-line">
              <!-- <p><label>Page </label>{{ currentPage }}</p> -->
              </div>
              <div class="col-md-5 select-line input-group-sm">
              <input type="text" name="q" ng-model="q" id="search" class="form-control" placeholder="Search">
              <!--  <select class="form-control" name="searchField" id="searchField" ng-model="searchField"><option ng-repeat="u in subData[0].listColumns" ng-if="subData[0].columns[u].searchable" value="{{subData[0].columns[u].name}}">{{subData[0].columns[u].name}}</option></select> -->
              </div>
              <div class="col-md-3 text-right select-line input-group-sm">
              <input type="number" min="1" max="100" class="form-control" ng-model="pageSize">
              </div>
              <div class="clearfix"></div>
              </div> */ ?>
            <br/>
          </div>
        </form>
            <div  class="panel panel-default">
              <table class="row-border hover  animated fadeInLeft2 table table-bordered table-hover table-striped bg-white">
                  <thead>
                    <tr>
                      <!-- RENDER LIST HEADER -->
                      <th>User ID</th>
                      <th>User Name</th>
                      <th>Email</th>
                      <th>Role </th>
                      <th class="span2 listingTableHeadTh">Actions</th>
                    </tr>
                     </thead>
                     <tbody>
                    <tr on-finish-render="ngRepeatFinished" dir-paginate="u in manageusers.records | filter:q | itemsPerPage: pageSize" current-page="currentPage">
                          <td>{{u.id}}</td>
                          <td>{{u.username}}</td>
                          <td>{{u.email}}</td>
                          <td>{{u.role_name}}</td>
                          <td>
                              <div class="wid145">
                              <button type="button" ng-click="actionClick($event,$index,'viewuser',u,u.id,pIndex);" class="btn btn-sm btn-info ng-scope button-view tooltiplink"  uib-tooltip="view">
                              <i class="fa fa-eye"></i></button>
                              <button type="button" ng-click="actionClick($event,$index,'edituser',u,u.id,pIndex);" class="btn btn-sm btn-info ng-scope button-edit tooltiplink"  uib-tooltip="edit">
                              <i class="fa fa-edit"></i></button>
                              <button type="button" ng-click="actionClick($event,$index,'deleteuser',u,u.id,pIndex);" class="btn btn-sm btn-info ng-scope button-delete tooltiplink"  uib-tooltip="delete">
                              <i class="fa fa-trash-o"></i></button>
                              <button type="button" ng-click="actionClick($event,$index,'changepwd',u,u.id,pIndex);" class="btn btn-sm btn-info ng-scope button-delete tooltiplink"  uib-tooltip="Change password">
                              <i class="fa fa-key"></i></button>
                              </div>
                          </td>
                      </tr>
                      <tr ng-show="(manageusers.records | filter:q).length == 0"><td colspan="5" class="text-center">No results</td></tr>
                    </tbody>
               </table>
          </div>


          <script type="text/ng-template" id="/adduser.html">
            <div class="modal-header"  ng-style="{'background-color':myColor,'border-color':myColor}">
            <h4 id="myModalLabel" class="modal-title">{{actiontext}} User</h4>
            <span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span>
            </div>
           <div class="modal-body" ng-controller="sectionlistController">
              <form name="newuser" id="newuser" class="form-validate form-horizontal ng-email ng-pristine ng-invalid ng-invalid-required ng-valid-blacklist ng-valid-pattern ng-valid-url ng-valid-minlength ng-valid-maxlength ng-invalid-validator">
                     <input type="hidden" name="user_id" id="user_id" ng-model="formData.id">

                     <!--<div class="control-group">
                         <label for="user_fname" class="control-label">First Name</label>
                         <div class="controls">
                             <input type="text" class="form-control m-b" name="user_fname" id="user_fname" ng-model="formData.user_fname">
                         </div>
                     </div>
                     <div class="control-group">
                         <label for="user_lname" class="control-label">Last Name</label>
                         <div class="controls">
                             <input type="text" class="form-control m-b" name="user_lname" id="user_lname" ng-model="formData.user_lname">
                         </div>
                     </div>
                     <div class="control-group">
                         <label for="vFirstName" class="control-label">Address</label>
                         <div class="controls">
                             <input type="text" class="form-control m-b" name="user_address1" id="user_address1" ng-model="formData.user_address1">
                         </div>
                     </div>
                     <div class="control-group">
                         <label for="user_city" class="control-label">City</label>
                         <div class="controls">
                             <input type="text" class="form-control m-b" name="user_city" id="user_city" ng-model="formData.user_city">
                         </div>
                     </div>
                     <div class="control-group">
                         <label for="user_zipcode" class="control-label">Zip code</label>
                         <div class="controls">
                             <input type="text" class="form-control m-b" name="user_zipcode" id="user_zipcode" ng-model="formData.user_zipcode">
                         </div>
                     </div>-->
                      <div class="control-group">
                          <label for="vFirstName" class="control-label">User Name <span class="text-danger ng-scope">*<span></label>
                          <div class="controls">
                              <input type="text" class="form-control m-b" name="username" id="username" ng-model="formData.username" required>
                          </div>
                      </div>
                    <div class="control-group"  ng-if="savetext">
                          <label for="vFirstName" class="control-label">Password <span class="text-danger ng-scope">*<span></label>
                          <div class="controls">
                              <input type="password" class="form-control m-b" name="password" id="password" ng-model="formData.password" required>
                          </div>
                      </div>
                       <div class="control-group">
                          <label for="vFirstName" class="control-label">Email <span class="text-danger ng-scope">*<span></label>
                          <div class="controls">
                              <input type="text" ng-pattern="/^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/" class="form-control m-b" name="email" id="email"  ng-model="formData.email" required>
                          </div>
                      </div>
                      <!--<div class="control-group">
                         <label for="user_phone" class="control-label">Phone</label>
                         <div class="controls">
                             <input type="text"  class="form-control m-b" name="user_phone" id="user_phone"  ng-model="formData.user_phone">
                         </div>
                     </div>-->
                      <div class="control-group">
                          <label for="vFirstName" class="control-label">Role <span class="text-danger ng-scope">*<span></label>
                          <div class="controls">
                              <select name="role_id" id="role_id" class="required form-control m-b" ng-model="formData.role_id" required>
                                 <option value="{{r.value}}"  ng-repeat="r in manageroles" ng-selected="r.value == formData.role_id ">{{r.text}}</option>
                              </select>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button ng-click="modalCancel()" class="btn btn-secondary" tabindex="0">Cancel</button>
                          <button  ng-if="savetext" data-loading-text="Saving..."  ng-disabled="newuser.$invalid" type="submit" name="submit" ng-click="addUser();modalCancel();" class="submitButton btn btn-primary" ng-style="{'background-color':myColor,'border-color':myColor}">{{savetext}}</button>
                          <button  ng-if="updatetext" ng-disabled="newuser.$invalid" data-loading-text="Updating..." type="submit" class="btn btn-primary" ng-click="updateUser();modalCancel();" ng-style="{'background-color':myColor,'border-color':myColor}">{{updatetext}}</button>
                        </div>
                  </form>
              </div>
          </div>
          </script>


          <script type="text/ng-template" id="/detailuser.html">

          <md-dialog>
            <form ng-cloak>
              <md-toolbar  ng-style="{'background-color':myColor,'border-color':myColor}">
                <div class="md-toolbar-tools" ng-style="{'background-color':myColor,'border-color':myColor}">
                  <h2>User Details :: {{lists1.username}}</h2>
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
                          <tr>
                              <td>User Id</td>
                              <td>{{lists1.id}}</td>
                          </tr>
                          <tr>
                              <td>User</td>
                              <td>{{lists1.username}}</td>
                        </tr>
                        <tr>
                              <td>Email</td>
                              <td>{{lists1.email}}</td>
                        </tr>
                        <tr>
                              <td>Role</td>
                              <td>{{lists1.role_name}}</td>
                        </tr>

                    </table>
                  </div>
                </div>
              </md-dialog-content>
            </form>
          </md-dialog>
          </script>


          <script type="text/ng-template" id="/changepwd.html">
           <div class="modal-header"  ng-style="{'background-color':myColor,'border-color':myColor}">
            <h4 id="myModalLabel" class="modal-title">Change Password</h4>
            <span ng-click="modalCancel()" class="close"><i class="fa fa-times"></i></span>
            </div>
           <div class="modal-body" ng-controller="sectionlistController">
            <form name="cpform" id="cpform" class="form-validate form-horizontal ng-pristine ng-invalid ng-invalid-required ng-valid-blacklist ng-valid-pattern ng-valid-url ng-valid-minlength ng-valid-maxlength ng-invalid-validator">
            <input type="hidden" name="id" id="id" ng-model="formData.id">
                  <div class="control-group">
                      <label for="vFirstName" class="control-label">Current Password</label>
                      <div class="controls">
                          <input type="password" name="cpassword" class="form-control m-b"  id="cpassword" required ng-model="formData.cpassword">

                      </div>
                  </div>
                    <div class="control-group">
                      <label for="vFirstName" class="control-label">New Password</label>
                      <div class="controls">
                          <input type="password" name="newpassword"  class="form-control m-b" id="newpassword"  required ng-model="formData.newpassword">
                      </div>
                  </div>
                    <div class="control-group">
                      <label for="vFirstName" class="control-label">Confirm Password</label>
                      <div class="controls">
                          <input type="password" name="cnewpassword"  class="form-control m-b" id="cnewpassword" required ng-model="formData.cnewpassword">
                      </div>
                  </div>
                <div class="modal-footer">
                      <button ng-click="modalCancel()" class="btn btn-secondary" tabindex="0">Cancel</button>
                      <button  ng-if="updatetext" ng-disabled="cpform.$invalid" data-loading-text="Updating..." type="submit" class="btn btn-primary" ng-click="changepwd();" ng-style="{'background-color':myColor,'border-color':myColor}">{{updatetext}}</button>
                    </div>
            </form>
              </div>
          </div>
          </script>

    </div>

</div>
 <div class="pull-right">
    <dir-pagination-controls boundary-links="true" on-page-change="pageChangeHandler(newPageNumber)">
    <ul class="pagination" ng-if="1 < pages.length || !autoHide">
        <li ng-if="boundaryLinks" ng-class="{ disabled : pagination.current == 1 }">
            <a href="" ng-click="setCurrent(1)">&laquo;</a>
        </li>
        <li ng-if="directionLinks" ng-class="{ disabled : pagination.current == 1 }">
            <a href="" ng-click="setCurrent(pagination.current - 1)">&lsaquo;</a>
        </li>
        <li ng-repeat="pageNumber in pages track by tracker(pageNumber, $index)" ng-class="{ active : pagination.current == pageNumber, disabled : pageNumber == '...' }">
            <a href="" ng-click="setCurrent(pageNumber)">{{ pageNumber }}</a>
        </li>

        <li ng-if="directionLinks" ng-class="{ disabled : pagination.current == pagination.last }">
            <a href="" ng-click="setCurrent(pagination.current + 1)">&rsaquo;</a>
        </li>
        <li ng-if="boundaryLinks"  ng-class="{ disabled : pagination.current == pagination.last }">
            <a href="" ng-click="setCurrent(pagination.last)">&raquo;</a>
        </li>
    </ul>
    </dir-pagination-controls>
</div>
<div class="clearfix"></div>
 </section>
 <!-- custom actions -->
<!-- <section class="ng-scope" ng-if="cmAction == true" >
<div>{{sectionName}}</div>
</section> -->
</div>
 <!-- custom actions end -->


<script type="text/javascript">


</script>
