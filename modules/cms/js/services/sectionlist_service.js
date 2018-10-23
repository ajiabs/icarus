/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
icarusApp.service('sectionService',function(commonService){
    


    // For getting all details of list
    this.listdata = function(section,parent_section,parent_id){

                if(section=='settings'){
                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/settings',
                        type    : false,
                          data    : {  
                            section      : section                           
                        }
                    });
                }else if(section=='cms_settings'){
                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/settings',
                        type    : false,
                          data    : {  
                            section      : section                           
                        }
                    });
                }
                else if(parent_section=='-1' && parent_id=='-1'){

                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/listangularData',
                        type    : false,
                        data    : {  
                            section      : section                           
                        }
                    });
                }else{
                    
                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/listangularData',
                        type    : false,
                        data    : {
                            parent_section:parent_section,
                            parent_id     :parent_id,   
                            section      : section
                            
                        }
                    });
                }
          
        return promise;
    }

     this.fetchReportsFromRange = function(section,startDt,closeDt){
       // section=report&reportStartDate=11/01/2016&reportEndDate=11/08/2016&dateRange=custom
        var promise = commonService.callAjax({
            method  : 'GET',
            url     : MAIN_URL+'cms/cms/sectionconfig',
            type    : false,
            data    : {
                section      : section,
                dateRange    : 'custom',
                reportStartDate : startDt,
                reportEndDate : closeDt
            }
        });
        return promise;
    }

     this.getsectiondata = function(section){
        var promise = commonService.callAjax({
            method  : 'GET',
            url     : MAIN_URL+'cms/cms/sectionconfig',
            type    : false,
            data    : {
                section      : section
            }
        });
        return promise;
    }



    this.getprevilagedata = function(){
        var promise = commonService.callAjax({
            method  : 'GET',
            url     : MAIN_URL+'cms/cms/previlagedata',
            type    : false
        });
        return promise;
    }


    this.listdatafunction = function(source){
        var promise = commonService.callAjax({
            method  : 'GET',
            url     :  MAIN_URL+'cms/cms/externalconfig',
            type    : false,
             data    : {
                 source      : source
             }
        });
        return promise;
    }



    this.listcustomcmsdatafunction = function(controller,source,section){
        var promise = commonService.callAjax({
            method  : 'GET',
            url     :  MAIN_URL+'cms/'+controller+'/'+source,
            type    : false,
             data    : {
                 section      : section
             }
        });
        return promise;
    }


     this.listcustomdatafunction = function(controller,source,section){
        var promise = commonService.callAjax({
            method  : 'GET',
            url     :  MAIN_URL+controller+'/'+source,
            type    : false,
             data    : {
                 section      : section
             }
        });
        return promise;
    }

         // For logout when session time out
     this.logout = function(){
                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/logout',
                        type    : false
                    });
               
        return promise;
    }


     // For getting all details of menu
     this.menudata = function(){
                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/menuData',
                        type    : false
                    });
               
        return promise;
    }

     // For getting Title
     this.titledata = function(sectiontype){
                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/titleData',
                        type    : false,
                        data    :  {
                            sectiontype : sectiontype
                        }
                    });
               
        return promise;
    }


     // For getting Table
     this.tablename = function(sectiontype){
                    var promise = commonService.callAjax({
                        method  : 'GET',
                        url     :  MAIN_URL+'cms/cms/tablename',
                        type    : false,
                        data    :  {
                            sectiontype : sectiontype
                        }
                    });
               
        return promise;
    }


    //for writing bar diagram
    this.createBarDiaData = function(barUrl,color,label){

         var promise = commonService.callAjax({
                        method  : 'POST',
                        url     :  MAIN_URL+'cms/cms/createBarDiaData',
                        type    : false,
                        data    :  {
                            source : barUrl,
                            color  : color,
                            label  : label
                        }
                       
                    });
               
        return promise;
    }
    this.createLineDiaData = function(barUrl,color,label){ 

         var promise = commonService.callAjax({
                        method  : 'POST',
                        url     :  MAIN_URL+'cms/cms/createLineDiaData',
                        type    : false,
                        data    :  {
                            source : barUrl,
                            color  : color,
                            label  : label
                        }
                       
                    });
               
        return promise;
    }


     this.createPieDiaData = function(genre,key,dcount){ 
         var promise = commonService.callAjax({
                        method  : 'POST',
                        url     :  MAIN_URL+'cms/cms/createPieDiaData',
                        type    : false,
                        data    :  {
                            genre :genre,
                            key  :key,
                            dcount  :dcount
                        }
                       
                    });
               
        return promise;
    }




    


  
});