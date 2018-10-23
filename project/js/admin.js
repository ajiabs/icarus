$(document).ready(function() {
      
      
        //Confirm before delete
        $('.jdelete').click(function(){
          if(confirm("Are you sure you want to delete?")) {
              return true;
          }
          else{
              return false;
          }
        });
        
        $('.jqToggle').change(function(){showHideDiv(this);});
		hideDivOnLoad();

});
 
 
 
 
function showHideDiv(elem) {
    var divCls
    if($(elem).attr('checked')){
        divCls = $(elem).attr('id');
        $('.'+divCls).fadeIn('slow');
    }
    else{
        divCls = $(elem).attr('id');
        $('.'+divCls).fadeOut('slow');
    }
}

function hideDivOnLoad() {
    var divCls
    $('.jqToggle').each(function(i, j){
       if(!$(j).attr('checked')){
            divCls = $(j).attr('id');
            $('.'+divCls).fadeOut('fast');
       } 
    });
}