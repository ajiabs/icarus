/*
SEARCH Function
 # used for submitting url in search
 */

function getSearchResults(currentURL)
{
    var searchField=document.getElementById("searchField").options[document.getElementById("searchField").selectedIndex].value;
    var searchText=document.getElementById("searchText").value;

    var url=currentURL+"&searchField="+searchField+"&searchText="+searchText;
    window.location.href=encodeURI(url);

}

$(document).ready(function() {



    $('.tooltiplink').tooltip({
        placement: "right"
    });


    //jQuery time
var parent, ink, d, x, y;
$("ul.nav-side li a span").click(function(e){

  parent = $(this).parent();
  //create .ink element if it doesn't exist
  if(parent.find(".ink").length == 0)
    parent.prepend("<span class='ink'></span>");

  ink = parent.find(".ink");
  //incase of quick double clicks stop the previous animation
  ink.removeClass("animateddd");

  //set size of .ink
  if(!ink.height() && !ink.width())
  {
    //use parent's width or height whichever is larger for the diameter to make a circle which can cover the entire element.
    d = Math.max(parent.outerWidth(), parent.outerHeight());
    ink.css({height: d, width: d});
  }

  //get click coordinates
  //logic = click coordinates relative to page - parent's position relative to page - half of self height/width to make it controllable from the center;
  x = e.pageX - parent.offset().left - ink.width()/2;
  y = e.pageY - parent.offset().top - ink.height()/2;

  //set the position and add class .animate
  ink.css({top: y+'px', left: x+'px'}).addClass("animateddd");
})


    $(".jqEditRecord").live("click",function(){

        var editurl = $(this).attr("href");
       if(window.location.href==editurl)
        window.location.reload();

    });

    $(".jqShowDetails").live("click",function(){
        var urlString = $(this).attr("href");
        var currentAction = getParameterByName("action",urlString);

        if(currentAction=="showDetails"){
            var arr = urlString.split('#');

            var hashString = arr[1];



            showDetailsDivContent(hashString,urlString);

        }
        return false;
    });

    //if any form eroor exist, add # to focus form error
    if( formError==1)
        window.location.hash   =   "addForm";
    // For search button click
    $("#section_search_button").live("click",function(){

        getSearchResults(currentURL);
    });

    $("#search_form").submit(function(){
        getSearchResults(currentURL);
        return false;
    });
    // For displaying Form
    $(".addrecord").click(function () {
        //$(".listForm").show();
        //return false;
    });

    // for back button
    $(".jhistoryBack").click(function () {
        //window.history.back();

    });


    // For conformation for deleting an entry
    $(".action_delete").click(function () {
        var r=confirm("Are you sure you want to delete this record!")
        if (r	==	false) return false;
    });
    // For validation message displayed in the form
    $('span.field-validation-valid, span.field-validation-error').each(function () {
        $(this).addClass('help-inline');
    });
    // For from validation
    //    $('form').validate({
    //        errorClass:'error',
    //        validClass:'success',
    //        errorElement:'span',
    //        highlight: function (element, errorClass, validClass) {
    //            $(element).parents("div[class='clearfix']").addClass(errorClass).removeClass(validClass);
    //        },
    //        unhighlight: function (element, errorClass, validClass) {
    //            $(element).parents(".error").removeClass(errorClass).addClass(validClass);
    //        }
    //    });
    // Configure form validation messages here
    //    $.extend($.validator.messages, {
    //        required: "This field is required",
    //        remote: 'needs to get fixed',
    //        email: 'is an invalid email address',
    //        url: 'is not a valid URL',
    //        date: 'is not a valid date',
    //        dateISO: 'is not a valid date (ISO)',
    //        number: 'is not a valid number',
    //        digits: 'needs to be digits',
    //        creditcard: 'is not a valid credit card number',
    //        equalTo: 'is not the same value again',
    //        accept: 'is not a value with a valid extension',
    //        maxlength: jQuery.validator.format('needs to be more than {0} characters'),
    //        minlength: jQuery.validator.format('needs to be at least {0} characters'),
    //        rangelength: jQuery.validator.format('needs to be a value between {0} and {1} characters long'),
    //        range: jQuery.validator.format('needs to be a value between {0} and {1}'),
    //        max: jQuery.validator.format('needs to be a value less than or equal to {0}'),
    //        min: jQuery.validator.format('needs to be a value greater than or equal to {0}')
    //    });
    // for goto in pagination

    $('.goto').live('keyup', function(e) {

        if ( e.keyCode === 13 ) { // 13 is enter key

            var page = parseInt($('.goto').val());
            var no_of_pages = totalResulPages;
            if(page >0 && page <= no_of_pages){
                var url=currentURL+"&page="+page;
                window.location.href=encodeURI(url);
            }else{
                alert('Enter a Page between 1 and '+no_of_pages);
                $('.goto').val("").focus();
                return false;
            }

        }

    });
    // for autocomplete
    $( ".ui-autocomplete-input" ).click(function (){

        var id=$(this).attr('id');
        var sourceUrl=$('#source_'+id).val();
        $( ".ui-autocomplete-input" ).autocomplete({

            source: MAIN_URL+sourceUrl,
            //minLength:2,
            select: function( event, ui ) {
                $("#selected_"+id).attr("value",ui.item.id+":"+ui.item.label);
            }
        });

    });
    $('#myModal').modal('hide');
    $('#settingtab a:first').tab('show');
    $(".generateReport").click(function(){
        var reportStartDate     =   $("#reportStartDate").val();
        var reportEndDate       =   $("#reportEndDate").val();
        window.location=MAIN_URL+"cms/cms/getreport?reportStartDate="+reportStartDate+"&reportEndDate="+reportEndDate+"&requestHeader="+requestHeader;
        $('#myModal').modal('hide');
        return false;
        var data = 'reportStartDate='+reportStartDate+"&reportEndDate="+reportEndDate+"&requestHeader="+requestHeader;
        $.ajax({

            url: MAIN_URL+"cms/cms/getreport",
            type: "POST",
            data: data,
            cache: false,
            success: function(res) {
                //alert(res);
                $('#myModal').modal('hide');

            }
        });
    });

    //for setting page
    $(".jqSettingCheckbox").live("click",function(){
        var currentFieldId = $(this).attr("id");
        var value = $(this).val();

        if($(this).is(":checked"))
            $(".jq"+currentFieldId).show();
        else
            $(".jq"+currentFieldId).hide();

    });
    var displayFormMethod = $("#jqDisplayFormMethod").val();
    if(displayFormMethod=="popup" && ( action=="add" || action=="edit")){
        $('#addForm').modal('show');
        return false;
    }

    //select all for multiselect action
    $(".jqactionAll").live("click",function(){
        if($(this).is(":checked"))
        	$(".jqactionRow").prop( "checked", true );
        else
          $(".jqactionRow").prop( "checked", false );
    });

    //select for multiselect action
    $(".jqactionRow").live("click",function(){
    	if($(".jqactionAll").is(":checked")){
    		flag = 1;
    	}
    	else{
    		flag = 0;
    	}
        $(".jqactionRow").each(function(){
        	if($(this).is(":checked")){
        		flag = 1;
        	}
        	else{
        		flag = 0;
        		//break;
        		return false;
        	}

        });
        if($(".jqactionAll").is(":checked"))
        	{
        	 if(flag == 0)
             	$(".jqactionAll").prop( "checked", false );
        	}
        else{
        	if(flag == 1)
             	$(".jqactionAll").prop( "checked", true );
        }
    });

  //action for multiselect action
    $(".jqactionOperation").live("click",function(){
        var currentFieldId = $(this).attr("id");
        var value = $(this).attr("data-name");
        var checkCount = 0;
        var selectedString = '';
        $(".jqactionRow").each(function(){
        	if($(this).is(":checked")){
        		selectedValId = $(this).attr("id");
        		selectedVal = $(this).val();
        		checkCount = checkCount +1;
        		selectedString = selectedString+selectedVal+",";
        	}

        });
        if(selectedString == ''){
        	alert("Please select atleast one record.");
        	return false;
        }
        else{
        	selectedString =  selectedString.substring(0, selectedString.length - 1);

        var r=confirm("Are you sure you want to "+value+" this record!");
        if (r	==	false) return false;

        var url=currentURL+"&multiselectaction="+currentFieldId+"&actionColumnList="+selectedString;
        window.location.href=encodeURI(url);

        }

    });


});
// for intializing date picker object
$(function () {

    //for hiding sections and groups in privilages
    //
    //$(".jqSectionDiv").hide();
    // For hiding Form by Cancel Button click
    $("#entity_type").live("change",function(){
        if($("#entity_type").val()=="section"){
            $(".jqGroupDiv").hide();
            $(".jqSectionDiv").show();
        }
        else{
            $(".jqGroupDiv").show();
            $(".jqSectionDiv").hide();
        }

    });
    $(".jqPrivilegeForm").live("click",function(){
        if($("#entity_type").val()=="section"){
            if($("#section_entity_id").val()==""){
                alert("Please select section");
                return false;
            }
        }
        else if($("#entity_type").val()=="group"){

            if($("#group_entity_id").val()==""){
                alert("Please select group");
                return false;
            }
        }
        else{
            alert("Please select entity type");
            return false;
        }
    });


    $(".jqRoleForm").live("click",function(){

        if($("#role_name").val()==""){
            alert("Please enter role");
            return false;
        }

        $('#newrole').submit();

    });
    $(".jqUserForm").live("click",function(){

        if($("#username").val()==""){
            alert("Please enter username");
            return false;
        }
        if($("#password").val()==""){
            alert("Please enter password");
            return false;
        }
        if($("#email").val()==""){
            alert("Please enter email");
            return false;
        }
        else
        {
            if(!validateEmailInline($("#email").val()))
            {
                alert("Please enter valid email");
                return false;
            }

        }
        $('#newuser').submit();

    });
    $(".jqCPForm").live("click",function(){

        if($("#cpassword").val()==""){
            alert("Please enter old password");
            return false;
        }
        if($("#newpassword").val()==""){
            alert("Please enter new password");
            return false;
        }
        if($("#cnewpassword").val()==""){
            alert("Please confirm new password");
            return false;
        }
        if($("#cnewpassword").val()!=$("#newpassword").val()){


            alert("Password mismatch ");
            return false;

        }
        $('#cpform').submit();

    });
    $(".cancelButtonSettings").click(function () {
        window.location.reload();

    });
    $("#cpform").submit(function(e){
        // e.preventDefault();
        });
    $(".cancelButton").click(function () {
        $(".listForm").hide();

    });
    $(".cpCancelButton").click(function () {
    	$(".cpForm").hide();
    });
    $(".textfield_date").datepicker({
        dateFormat: date_separator
    });


    $('.tooltiplink').live("click",function(){
        return false;
    });
    $( ".ui-autocomplete-input" ).ready(function (){


        var id=$( ".ui-autocomplete-input" ).attr('id');
        var sourceUrl=$('#source_'+id).val();
        $( ".ui-autocomplete-input" ).autocomplete({

            source: MAIN_URL+sourceUrl,
            //minLength:2,
            create: function(event, ui) {
                var selectedValue   =   $( "#"+id ).attr('value');


            },
            select: function( event, ui ) {

                $("#selected_"+id).attr("value",ui.item.id+":"+ui.item.label);
            }
        });

    });
    /*$(".jqCustom").live("click",function(){
        var url = $(this).attr('href');
        var id=$(this).attr('rel');
        if(id){
            var idsplitvar    =   id.split("button_");
            var selectedId  =    idsplitvar[1];
            var  selectedValueArray    =   selectedId.split(":");
            var primarykey   =   selectedValueArray[2];

            $.ajax({
                url:url,
                type:'get',
                dataType:'html',

                success:function(data) {
                    $('.alert-success-div > p').html("Record updated successfully");
                    $('.alert-success-div').show();
                    $('.alert-success-div').delay(5000).slideUp(function(){
                        $('.alert-success-div > p').html('');
                    });
                    window.location.href = url ;
                },
                beforeSend:function() {


                },
                complete:function(){



                }
            });

        }

        return false;
    });
*/


     $(".jqCustom").live("click",function(){
        var murl = $(this).attr('href');
        var id=$(this).attr('rel');
        if(id){
            var idsplitvar    =   id.split("button_");
            var selectedId  =    idsplitvar[1];
            var selectedValueArray    =   selectedId.split(":");
            var section_col = selectedValueArray[0];
            var primarykey   =   selectedValueArray[2];
            var section_tbl = selectedValueArray[3];
            var params = 'selectedId='+selectedValueArray[1]+"&id="+primarykey+"&section_tbl="+section_tbl+"&section_col="+section_col+"&primary_col="+selectedValueArray[4];
            $.ajax({
                url:MAIN_URL+"cms/cms/listOptionUpdate",
                type:'POST',
                data : params,
                cache: false,
                success:function(data) {
                    $('.alert-success-div > p').html("Record updated successfully");
                    $('.alert-success-div').show();
                    $('.alert-success-div').delay(5000).slideUp(function(){
                        $('.alert-success-div > p').html('');
                    });
                    window.location = murl;
                },
                beforeSend:function() {


                },
                complete:function(){



                }
            });

        }

        return false;
    });


    $(".jqCloseButton").live("click",function(){
        $("#popup").hide();
    });
    $(".jqPopupLink").live("click",function(){

        var id=$(this).attr('rel');
         var  url=$(this).attr('href');

        if(id){
            var idsplitvar    =   id.split("link_");
            var selectedId  =    idsplitvar[1];



            $.ajax({
                url:url,
                type:'get',
                dataType:'html',

                success:function(data) {
                    $("#popup").show();
                    $(".modal-title h4").html("&nbsp;");
                    $("#popupBody").html(data);
                },
                beforeSend:function() {


                },
                complete:function(){



                }
            });

        }

        return false;
    });
      $(".jqPopupOrderLink").live("click",function(){

        var id=$(this).attr('rel');
         var  url=$(this).attr('href');

        if(id){
            var idsplitvar    =   id.split("link_");
            var selectedId  =    idsplitvar[1];



            $.ajax({
                url:url,
                type:'get',
                dataType:'html',

                success:function(data) {
                    $("#popup").show();
                    $(".modal-title h4").html("Change Order Status");
                    $("#popupBody").html(data);
                },
                beforeSend:function() {


                },
                complete:function(){



                }
            });

        }

        return false;
    });
    $(".jqHeaderPopupLink").live("click",function(){
        var  url=$(this).attr('href');

        $.ajax({
            url:url,
            type:'get',
            dataType:'html',

            success:function(data) {

                $("#popup").show();
                $("#popupBody").html(data);
            },
            beforeSend:function() {


            },
            complete:function(){



            }
        });
        return false;
    });
    // for  WYSIWYG Text and HTML Editor
    $('.jqModalViewDiv').css({
        width: 'auto',
        'margin-left': function () {
            return -($(this).width() / 2);
        }
    });

    $(".jqreportListingCustomDate").click(function(){
    	var reportStartDate = $("#reportStartDate").val();
    	var reportEndDate = $("#reportEndDate").val();
    	var data = '&reportStartDate='+reportStartDate+"&reportEndDate="+reportEndDate+"&dateRange=custom";
   	 	var url=sectionPath+data;
   	    window.location.href=encodeURI(url);
//    	window.location=MAIN_URL+"cms/cms/getreport?reportStartDate="+reportStartDate+"&reportEndDate="+reportEndDate+"&requestHeader="+requestHeader;
    	$('#myModal').modal('hide');
    	return false;

    	});

    $(".jqReportExport").click(function(){
    	var url=currentURL;
   	 	data = url.replace(sectionPath+'&',"");
   	 	url1 = MAIN_URL+"cms/cms/getreportExport?"+data+"&requestHeader="+requestHeader;
//   	 	alert(url1);
   	 	window.location=url1;
    	return false;

    	});

	 $(".jqChangePwdBtn").live("click",function(){
		 if($("#currentpwd").val()==""){
		 alert("Please enter old password");
		 return false;
		 }
		 if($("#newpwd").val()==""){
		 alert("Please enter new password");
		 return false;
		 }
		 if($("#confirmnewpwd").val()==""){
		 alert("Please confirm new password");
		 return false;
		 }
		 if($("#confirmnewpwd").val()!=$("#newpwd").val()){
		 alert("Password mismatch ");
		 return false;
		 }
		 $('#changePwdform').submit();
		 });

	 $("#changePwdform").submit(function(e){
		// e.preventDefault();
		});

});

function validateEmailOld($email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( $email ) ) {
        return false;
    } else {
        return true;
    }
}

function validateEmailInline(email){
    var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var result = re.test(email);
    if(!result){
        return false;
    }else{
        return true;
    }
}

function getParameterByName( name,href )
{
    name = name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]");
    var regexS = "[\\?&]"+name+"=([^&#]*)";
    var regex = new RegExp( regexS );
    var results = regex.exec( href );
    if( results == null )
        return "";
    else
        return decodeURIComponent(results[1].replace(/\+/g, " "));
}
function  showDetailsDivContent(hashString,urlString){
    $('#jqDetailModal').remove();
    var section = getParameterByName("section",urlString);
    $.ajax({
        url: MAIN_URL+"cms/cms/detailpage?section="+section+"&key="+hashString,
        type:'get',
        dataType:'html',

        success:function(data) {


            $('.container-fluid').append(data);

            $("#jqDetailModal").modal('show');


        },
        beforeSend:function() {


        },
        complete:function(){



        }
    });
    return false;
}

function markRead(id){

    //Some code
      $.ajax({
            url: MAIN_URL+"cmshelper/mailStatusChange?id="+id,
            type:'get',
            dataType:'html',

            success:function(data) {


                //$('.container-fluid').append(data);

                $("#"+id).show();


            },

        });


}
