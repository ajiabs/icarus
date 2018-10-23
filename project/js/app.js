$(document).ready(function(){


	$(".jqCustom").live("click",function() {
		//$('#loading').html("loading....");
		$('#myProgress').show();
		 var elem = document.getElementById("myBar");
		  var width = 0.5;
		  var id = setInterval(frame,0.1);
		  function frame() {
		    if (width >= 100) {
		      clearInterval(id);
		      $('#myProgress').hide();
		    } else {
		      width++;
		      elem.style.width = width + '%';
		    }
		  }
	});

	$(".textfield_date").datepicker($.datepicker.regional[ "" ],{
	    dateFormat: "mm/dd/yy"

	});



	/* code to upgrade the smb plan */
	$("#btnsmbupgrade").live("click",function() {


		 if($("#txtuserplan").val()==''){
	            $("#jqError").html("Please choose a plan");
	            $(".alert-error").show();
	            $("#jqFocus").focus();
	            return false;
	        }
		 appid = $("#appid").val();
		 if(appid == ''){
			 $("#jqError").html("Application id missing. Please try again");
	         $(".alert-error").show();
	         $("#jqFocus").focus();
	         return false;
		 }
		 $(".alert-error").hide();

		 var url = MAIN_URL+"cmshelper/updatesmbupgrading/";
		 var data ="plan="+$('#txtuserplan').val()+'&appid='+appid;
		 $.ajax({
             url: url,
             type: "POST",
             async:false,
             data: data,
             cache: false,
             success: function(result) {
                    if(result == 1) {
                    	$("#successMessage").html("Successfully updated the data");
                    	$(".alert-success").show();
                    }
                    else{
                    	 $("#jqError").html("Some unexpected error occured.");
            	         $(".alert-error").show();
            	         $("#jqFocus").focus();
                    }
    	            return false;

             }

         });


	});
	/* smb upgrade ends */







	/* sms count check ends */

	/* APP credit adding section starts */
	$("#btnsmbaddcredit").live("click",function() {
		 if($("#txtnewcredit").val()==''){
	            $("#jqError").html("Please add credit");
	            $(".alert-error").show();
	            $("#jqFocus").focus();
	            return false;
	        }
		else {
			credit = $("#txtnewcredit").val();
			if (isNaN(credit)) {
				$("#jqError").html("Please enter numeric value");
		        $(".alert-error").show();
		        $("#jqFocus").focus();
		        return false;
	         }

		}
		 appid = $("#appid").val();
		 if(appid == ''){
			 $("#jqError").html("Application id missing. Please try again");
	         $(".alert-error").show();
	         $("#jqFocus").focus();
	         return false;
		 }
		 $(".alert-error").hide();

		 var url = MAIN_URL+"cmshelper/addsmbcredit/";
		 var data ="credit="+$('#txtnewcredit').val()+'&appid='+appid;
		 $.ajax({
          url: url,
          type: "POST",
          async:false,
          data: data,
          cache: false,
          success: function(result) {
                 if(result == 1) {
                 	$("#successMessage").html("Successfully added credit to the Application");
                 	$(".alert-success").show();
                 }
                 else{
                 	 $("#jqError").html("Some unexpected error occured.");
         	         $(".alert-error").show();
         	         $("#jqFocus").focus();
                 }
 	            return false;

          }

      });
	});
	/* APP credit adding section ends */


	//submenu
    $(".myaccount").click(function()   {
        var X=$(this).attr('id');
        if(X==1)        {
            $(".submenu").hide();
            $(this).attr('id', '0');
        }
        else      {
            $(".submenu").show();
            $(this).attr('id', '1');
        }
    });

    //Mouseup textarea false
    $(".submenu").mouseup(function()    {
        return false
    });
    $(".myaccount").mouseup(function()    {
        return false
    });

    //Textarea without editing.
    $(document).mouseup(function()    {
        $(".submenu").hide();
        $(".myaccount").attr('id', '');
    });


    $("#jqsendconfirmation").live("click",function() {
    	$("#jqError").html("");
    	if($("#confirmuseremail").val()==''){
    		$("#jqError").html("Please enter the email");
	        	return false;
	    }

    	 var url = MAIN_URL+"index/senduserconfirmmail/";
		 var data ="email="+$('#confirmuseremail').val()+"&plan="+$('#userplan').val();
		 alert(data);
		 $.ajax({
          url: url,
          type: "POST",
          async:false,
          data: data,
          cache: false,
          success: function(result) {
        	  var paymentData = result.split(":");
        	  $("#jqMessage").html(paymentData[1]);
                if(paymentData[0] == 4)
                	window.setTimeout(function() {$.colorbox.close();}, 5000);
 	            return false;

          }

      });


    });

});

function ajaxcall(url,data){

	 $.ajax({
         url: url,
         type: "POST",
         async:false,
         data: data,
         cache: false,
         success: function(result) {

        	 return result;

         }
     });
	//return false;

}

function loadDashboard(){
	document.frmdash.submit();
}
