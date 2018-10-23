/* Framework Related JS Goes Here */

/*var Global = {
	ajaxLoad:function($url,$params = {},$onSuccessFunction,$onFailureFunction){
		//alert("sdfsd");
	}

};*/

//Global.ajaxLoad();

// Debugger Starts
$(document).ready(function(){
$('#debugger div').hide();
$('#debugger div:first').show();
$('#debugger ul li:first').addClass('active');

$('#debugger ul li a').click(function(){
 $('#debugger ul li').removeClass('active');
$(this).parent().addClass('active');
var currentTab = $(this).attr('href');
$('#debugger div').hide();


 $("div#"+currentTab).css("display", "block");
return false;
});
});


/* Fix for Placeholder issue with IE */
(function($) {
	  $.fn.placeholder = function() {
	    if(typeof document.createElement("input").placeholder == 'undefined') {
	      $('[placeholder]').focus(function() {
	        var input = $(this);
	        if (input.val() == input.attr('placeholder')) {
	          input.val('');
	          input.removeClass('placeholder');
	        }
	      }).blur(function() {
	        var input = $(this);
	        if (input.val() == '' || input.val() == input.attr('placeholder')) {
	          input.addClass('placeholder');
	          input.val(input.attr('placeholder'));
	        }
	      }).blur().parents('form').submit(function() {
	        $(this).find('[placeholder]').each(function() {
	          var input = $(this);
	          if (input.val() == input.attr('placeholder')) {
	            input.val('');
	          }
	      })
	    });
	  }
	}
	})(jQuery);
$(function() { $.fn.placeholder(); });