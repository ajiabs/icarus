
<section class="ng-scope" ng-controller="sectionlistController" ng-init="init('dashboard',-1,-1)">

<div class="app-view-header" style="padding:15px">Dashboard</div>

<!-- aggregate-->




<div  class="full-width">

<?php //echopre1($_SESSION);
$active_user=$_SESSION;
if($active_user['cms_role_id']==11){ ?>

  <a ng-if="subData[0].aggregatePanel5.columns > 0" href="{{aggregatedashlink5}}" >

    <div class="col-md-3 animated fadeInLeft2">
      <div class="home-box {{subData[0].aggregatePanel5.column1.boxcolor}}-clr home-box-top2">
        <div class="col-xs-5 home-box-top">
        <i class="fa fa-{{subData[0].aggregatePanel5.column1.titleicon}} icon-sep" aria-hidden="true"></i>
        </div>
        <div class="col-xs-7">
          <div class="full-width count-size">
          {{aggregatedash5}}
          </div>
        {{subData[0].aggregatePanel5.column1.title}}
        <uib-progressbar value="aggregatedash5" type="purple" class="active progress-xs"></uib-progressbar>
        </div>
      </div>
    </div>
  </a>


<?php } else {?>
  <a ng-if="subData[0].aggregatePanel1.columns > 0" href="{{aggregatedashlink1}}" >

    <div class="col-md-3 animated fadeInLeft2">
      <div class="home-box {{subData[0].aggregatePanel1.column1.boxcolor}}-clr home-box-top2">
        <div class="col-xs-5 home-box-top">
        <i class="fa fa-{{subData[0].aggregatePanel1.column1.titleicon}} icon-sep" aria-hidden="true"></i>
        </div>
        <div class="col-xs-7">
          <div class="full-width count-size">
          {{aggregatedash1}}
          </div>
        {{subData[0].aggregatePanel1.column1.title}}
        <uib-progressbar value="aggregatedash1" type="purple" class="active progress-xs"></uib-progressbar>
        </div>
      </div>
    </div>
  </a>


<?php } ?>






  <a ng-if="subData[0].aggregatePanel2.columns > 0" href="{{aggregatedashlink2}}" >

    <div class="col-md-3 animated fadeInLeft2">
      <div class="home-box {{subData[0].aggregatePanel2.column1.boxcolor}}-clr home-box-top2">
        <div class="col-xs-5 home-box-top">
        <i class="fa fa-{{subData[0].aggregatePanel2.column1.titleicon}} icon-sep" aria-hidden="true"></i>
        </div>
        <div class="col-xs-7">
          <div class="full-width count-size">
          {{aggregatedash2}}
          </div>
        {{subData[0].aggregatePanel2.column1.title}}
        <uib-progressbar value="aggregatedash2" type="warning" class="active progress-xs"></uib-progressbar>
        </div>
      </div>
    </div>
  </a>

 <a ng-if="subData[0].aggregatePanel3.columns > 0" href="{{aggregatedashlink3}}" >

    <div class="col-md-3 animated fadeInLeft2">
      <div class="home-box {{subData[0].aggregatePanel3.column1.boxcolor}}-clr home-box-top2">
        <div class="col-xs-5 home-box-top">
        <i class="fa fa-{{subData[0].aggregatePanel3.column1.titleicon}} icon-sep" aria-hidden="true"></i>
        </div>
        <div class="col-xs-7">
          <div class="full-width count-size">
          {{aggregatedash3}}
          </div>
        {{subData[0].aggregatePanel3.column1.title}}
        <uib-progressbar value="aggregatedash3" type="danger" class="active progress-xs"></uib-progressbar>
        </div>
      </div>

    </div>
  </a>

  <a ng-if="subData[0].aggregatePanel4.columns > 0"  href="{{aggregatedashlink4}}" >

    <div class="col-md-3 animated fadeInLeft2">
      <div class="home-box {{subData[0].aggregatePanel4.column1.boxcolor}}-clr home-box-top2">
        <div class="col-xs-5 home-box-top">
        <i class="fa fa-{{subData[0].aggregatePanel4.column1.titleicon}} icon-sep" aria-hidden="true"></i>
        </div>
        <div class="col-xs-7">
          <div class="full-width count-size">
          {{aggregatedash4}}
          </div>
        {{subData[0].aggregatePanel4.column1.title}}
        <uib-progressbar value="aggregatedash4" type="info" class="active progress-xs"></uib-progressbar>
        </div>
      </div>
    </div>
  </a>

</div>

<!-- aggregate-->


    <div  ng-controller="FlotChartController as flot">
    <div class="full-width">

        <div ng-if="subData[0].graphPanel1.columns > 0 && $index > 0" ng-repeat="obj in subData[0].graphPanel1" class="col-md-6 fw-boxed animated fadeInLeft2">

            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="panel-title">
                      {{ obj.caption}}
                      <em ng-if="obj.type == 'MSColumn3D'" class="pull-right fa fa-bar-chart"></em>
                      <em ng-if="obj.type == 'MSLine'" class="pull-right fa fa-line-chart"></em>
                      <em ng-if="obj.type == 'MSCombiDY2D'" class="pull-right fa fa-area-chart"></em>
                      <em ng-if="obj.type == 'MSPie'" class="pull-right fa fa-pie-chart"></em>
                    </div>
                </div>
                  <div class="panel-body">
                    <span ng-bind-html="loading"></span>
                    <flot ng-if="obj.type == 'MSColumn3D'" src="obj.sourceSrc" options="flot.MSColumn3D"></flot>
                    <flot ng-if="obj.type == 'MSLine'" src="obj.sourceSrc" options="flot.MSLine" series="{lines: flot.lineSeriesLines, points: flot.lineSeriesPoints}"></flot>
                    <flot ng-if="obj.type == 'MSCombiDY2D'" src="obj.sourceSrc" options="flot.MSCombiDY2D"></flot>
                    <flot ng-if="obj.type == 'MSPie'" src="obj.sourceSrc" options="flot.MSPie"></flot>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="clearfix"></div>




<div class="app animated fadeInLeft2">


  <div class="row-fluid general_content_boxes ">
<?php //for($colLoop=1;$colLoop<=PageContext::$response->listingPanels[$rowLoop]->columnCount;$colLoop++) { ?>
<div class="panel panel-default">
  <div class="panel-heading">
    <div class="panel-title">

      <a ng-if="subData[0].listingPanel1.column1.titlelink" href="{{listdashlink1}}" >
        {{subData[0].listingPanel1.column1.title}}
      </a>
      <span ng-if="listdash.length>0">
      <a ng-if="subData[0].listingPanel1.column1.titlelink" class="pull-right btn btn-primary" href="{{listdashlink1}}" >
      {{subData[0].listingPanel1.column1.titlelink}}
      </a>
      </span>
    </div>
  </div>
  <div class="panel-body">
         <div id="no-data" ng-if="listdash.length<=0">
                <div id="no-datatxt" class="container container-lg animated fadeInDown">
                      <p class="text-center">No details found</p>

                </div>
              </div>

            <div class="table-responsive  table-bordered" ng-if="listdash.length>0">
        <table  class="table table-bordered table-striped" >
          <thead>
            <tr>
              <th ng-repeat="n in subData[0].listingPanel1.column1.listcolumns">{{n.name}}</th>
              <!--<th>Action</th>-->
            </tr>
          </thead>
          <tbody>

            <tr ng-repeat="x in listdash">

              <td ng-repeat="(key,value) in subData[0].listingPanel1.column1.listcolumns" ng-bind-html="x[key]"></td>
              <!--<td>
               <button type="button"  ng-click="viewdashModal(listdash[$index].feedback_id);" class="btn btn-sm btn-info ng-scope button-view">
                <i class="fa tooltiplink fa-eye">
                </i>
               </button>
                <button type="button"  ng-click="viewdashPage(listdash[$index].feedback_id);" class="btn btn-sm btn-info ng-scope button-view">
                <i class="fa tooltiplink fa-eye">
                </i>
              </button>
             </td>-->
            </tr>
          </tbody>
        </table>
    </div>
  </div>
</div>



   <div class="row-fluid general_content_boxes ">
                    <?php //for($colLoop=1;$colLoop<=PageContext::$response->listingPanels[$rowLoop]->columnCount;$colLoop++) { ?>
             <div class="panel panel-default">
              <div class="panel-heading">
                    <div class="panel-title">
                      <a ng-if="subData[0].listingPanel2.column1.titlelink" href="{{listdashlink2}}" >
                      {{subData[0].listingPanel2.column1.title}}
                       </a>
                     <span ng-if="listdash2.length>0">
                      <a ng-if="subData[0].listingPanel2.column1.titlelink" class="pull-right btn btn-primary" href="{{listdashlink2}}" >
                       {{subData[0].listingPanel2.column1.titlelink}}
                      </a>
                    </span>
                    </div>
              </div>
               <div class="panel-body">

              <div id="no-data" ng-if="listdash2.length<=0">
                <div id="no-datatxt" class="container container-lg animated fadeInDown">
                      <p class="text-center">No details found</p>

                </div>
              </div>

            <div class="table-responsive  table-bordered" ng-if="listdash2.length>0">
                 <table class="table table-bordered table-striped" >

                    <thead>

                        <tr>
                           <th ng-repeat="n in subData[0].listingPanel2.column1.listcolumns">{{n.name}}</th>
                            <!--<th>Action</th>-->
                        </tr> </thead>
                    <tbody>
                        <tr ng-repeat="x in listdash2">
                      <td ng-repeat="(key,value) in subData[0].listingPanel2.column1.listcolumns" ng-bind-html="x[key]"></td>
                      <!-- <td>
                        <button type="button" ng-click="viewdashModal(listdash2[$index].od_id);" class="btn btn-sm btn-info ng-scope button-view">
                          <i class="fa tooltiplink fa-eye">
                          </i>
                         </button>
                          <button type="button"  ng-click="viewdashPage(listdash2[$index].od_id);" class="btn btn-sm btn-info ng-scope button-view">
                        <i class="fa tooltiplink fa-eye">
                        </i>
                       </button> -->
                    </td>
                    </tr>


                    </tbody>
                </table>
            </div>
             </div>
              </div>
 </div>


 </div>

    </div>

</section>

    <div id="viewdashModal" class="modal">
      <div class="md-scroll-mask" aria-hidden="true">  <div class="md-scroll-mask-bar"></div></div>
             <div class="md-dialog-container ng-scope" tabindex="-1">
              <div class="md-dialog-focus-trap" tabindex="0"></div>
          <md-dialog md-theme="default" aria-label="Lucky day" ng-class="dialog.css" class="_md md-default-theme md-transition-in" role="dialog" tabindex="-1" aria-describedby="dialogContent_0" style="">
       <md-toolbar>
      <div class="md-toolbar-tools" ng-style="{'background-color':myColor,'border-color':myColor}">
        <h2>Details</h2>
        <span flex="" class="flex"></span>
        <button class="md-icon-button md-button md-ink-ripple" type="button"  data-dismiss="modal" tabindex="0">
          <md-icon aria-label="Close dialog" class="ng-scope material-icons" aria-hidden="true"><i class="fa fa-times"></i></md-icon>
        </button>
      </div>
       </md-toolbar>
          <md-dialog-content class="md-dialog-content" role="document" tabindex="-1" id="dialogContent_0">
              <table class="table pop_table table-bordered table-hover table-condensed" id="viewdash">

              </table>
            </md-dialog-content>
            <md-dialog-actions>

          </md-dialog-actions>
        </md-dialog><div class="md-dialog-focus-trap" tabindex="0">
         </div>
      </div>
    </div>

<style>
.modal-backdrop{z-index: initial;}
.animated{
      -webkit-animation-fill-mode: initial;
      animation-fill-mode: initial;
}
</style>
