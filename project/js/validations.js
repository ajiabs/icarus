$(document).ready(function() {
	$("#frmreg").validate({meta: "validate"}); 
	$("#frmlogin").validate({meta: "validate"}); 
	$("#updatepwdform").validate({meta: "validate"}); 
	$("#frmaddcredit").validate({meta: "validate"}); 
	$("#frmchangeplan").validate({meta: "validate"}); 
	
	/************ function to change the credit value ****************/
	$("#txtcreditvalue").keyup(function(){ 
	    amt = $('#txtcreditvalue').val();
	    if(amt != '' && !isNaN(amt)){
	    	var credVal 			= $('#jqcreditval').val();
	    	var purchaseCredit 		=  amt*credVal;
	    	$('#jqpurchasecredit').html(purchaseCredit);
	    	var curCredit 			= $('#jqcurrcredit').val();
	    	var totcredit 			= parseInt(purchaseCredit) + parseInt(curCredit);
	    	$('#jqtotalcredit').html(totcredit);
	    }
	});
	/************ credit value change function ends   ****************/
	

	
	$('#btnRegister').click(function(){
		 
	        if ($("#frmreg").valid({meta: "validate" })) {
				
				 
				if($("#gtbankpayment").prop('checked')) {
			 
					return true;
				}
	        	year = $('#txtcardyear').val();
	        	if(year =='') {
	        		$('#txtcardyear').addClass('error');
	        		$('#jqtxtcardmonth').show();
	        		$('#jqtxtcardmonth').html('Please enter the credit card expiry month and year');
	        		return false;
	        	}
	        }
	 });


	
	
	
	 $('#txtincomingphone').click(function(){
		 var curVal = $('#txtincomingphone').val();
		 var url 	= MAIN_URL+"index/phonenumberlisting?phoneno="+curVal;
		 $.colorbox({ href:url});
		  this.blur();
	 }) ;
	

	 /***** Function to assign the selected number to parent *******/
	 $('#btnUsePhoneNumber').live("click",function(){
	 	var selPhoneNo =$('[name=userphonenumber]:checked').val();
	 	$('#txtincomingphone').val(selPhoneNo);
	 	$.colorbox.close(); 
	 });
	 /****** Phone number assign section ends       ******/
	 

	//close the message compose box
	$('.btnCloseColorBox').live("click",function(){
		$.colorbox.close(); 
	});


	$('#btnBuyCredit').click(function(){
	        if ($("#frmaddcredit").valid({meta: "validate" })) {
	        	year = $('#txtcardyear').val();
	        	if(year =='') {
	        		$('#txtcardyear').addClass('error');
	        		$('#jqtxtcardmonth').show();
	        		$('#jqtxtcardmonth').html('Please enter the credit card expiry month and year');
	        		return false;
	        	}
	        }
	 });
	
	
	
   
});


	function changePlanAmt(){  
		var plan 			= $('#txtuserplan').val();
		var period 			= $('#txtplanperiod').val();
		 $.ajax({
	         url: MAIN_URL+"index/checkplanamount",
	         type: "POST",
	         dataType :"json",
	         data: 'plan='  + plan+'&period='  + period,
	         cache: false,
	         success: function (data) {
	         	if(data.payAmt<=0){
		        	$('#jqplanamt').hide();
		        	$('#jqauthorizeinfo').hide();
	         	}else{
	         		var html = 'Total Amount : '+data.default_currency+data.payAmt;
		        	$('#jqplanamt').html(html);
		        	$('#jqplanamt').show();
		        	$('#jqauthorizeinfo').show();
		        	$('.payment_div').removeClass('hide');
	         	}
	         }
	      });
	}
 