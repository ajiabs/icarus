$(document).ready(function() {
	//functions to handle the colorbox events
 
	$(".inline").colorbox({inline:true, width:"50%"});
	//$(".inline").colorbox({inline:true, width:"50%"});
	$(".jqsendemail").colorbox();
	$(".jqshowvoicemailpopup").colorbox({ width:"40%",iframe:false});
	$(".jqopencallpopup").colorbox({ width:"550px",height:"500px"});
	$(".jqopensmspopup").colorbox({ width:"550px"});
	 $(".jqopenpopup").colorbox();
	
	 
	$(".exportdata").colorbox({inline:true, width:"40%"});
	

	
	
	
 
});
 
$(document).bind('cbox_open', function(){ $('#cboxClose').addClass('hidden'); }).bind('cbox_complete', function(){ $('#cboxClose').removeClass('hidden'); });

/* ajax popup code starts */
$(function(){
	var ajaxtooltip = {};
	$('.jqajaxtooltip').poshytip({
		className: 'tip-darkgray',
		bgImageFrameSize: 11,
		alignY: 'bottom',
		content: function(updateCallback) {
			var action = $(this).attr('rel');
			var param = $(this).attr('data-param');
			var rel = $(this).attr('data-key');
			
			//rel = action+param;
			 
			if (ajaxtooltip[rel] && ajaxtooltip[rel].container)
				return ajaxtooltip[rel].container;
			if (!ajaxtooltip[rel]) {
				ajaxtooltip[rel] = { container: null };
				
				var params = "?action="+action+'&value='+param;
				var url = MAIN_URL+"smb/index/tooltiploader"+params;
				$.get(url,
					function(data) {
						var container = $('<div/>').html(data);
						 
						// call the updateCallback function to update the content in the main tooltip
						// and also store the content in the cache
						updateCallback(ajaxtooltip[rel].container = container);
					}
				);
			}
			return 'Loading...';
		}
	});
});



$(function(){
	var ajaxtooltip = {};
	$('.jqajaxtooltipadmin').poshytip({
		className: 'tip-darkgray',
		bgImageFrameSize: 11,
		alignY: 'bottom',
		content: function(updateCallback) {
			var action = $(this).attr('rel');
			var param = $(this).attr('data-param');
			var rel = $(this).attr('data-key');
			
			//rel = action+param;
			 
			if (ajaxtooltip[rel] && ajaxtooltip[rel].container)
				return ajaxtooltip[rel].container;
			if (!ajaxtooltip[rel]) {
				ajaxtooltip[rel] = { container: null };
				
				var params = "?action="+action+'&value='+param;
				var url = MAIN_URL+"cmshelper/tooltiploader"+params;
				$.get(url,
					function(data) {
						var container = $('<div/>').html(data);
						 
						// call the updateCallback function to update the content in the main tooltip
						// and also store the content in the cache
						updateCallback(ajaxtooltip[rel].container = container);
					}
				);
			}
			return 'Loading...';
		}
	});
});
 



/* ajax popup code ends */


/* load the mail sending box from the popup box */
$(".jqopenemailpopup").live("click",function() {
	 $.colorbox({href:$(this).attr('href'), open:true});
	 return false;
});
 

//close the message compose box
$('.btnCloseColorBox').live("click",function(){
	 
	$.colorbox.close(); 
});





/* code to generate the reports starts */
$(".generateReport").live("click",function() {
 
	  var reportStartDate     =   $("#reportStartDate").val();
	    var reportEndDate       =   $("#reportEndDate").val();
	    var exportfunction       =   $("#exportfunction").val();
	    
	     
	    window.location=MAIN_URL+exportfunction+"?reportStartDate="+reportStartDate+"&reportEndDate="+reportEndDate+"&export=true&"+QUERY_STRING;
	    return false;
});
/* report generation ends */