<?php 

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
// +----------------------------------------------------------------------+
// | File name : cls_plans.php                                         		  |
// | PHP version >= 5.2                                                   |
// +----------------------------------------------------------------------+
// +----------------------------------------------------------------------+
// | Copyrights Armia Systems � 2010                                    |
// | All rights reserved                                                  |
// +----------------------------------------------------------------------+
// | This script may not be distributed, sold, given away for free to     |
// | third party, or used as a part of any internet services such as      |
// | webdesign etc.                                                       |
// +----------------------------------------------------------------------+

class Schools {

	/*
	 * function to return the list of Schools
	 */
	 
	public static function getSchoolList($userstate='',$limit='',$start=''){
            
            
            
            
		$db       = new Db();
                
     if($userstate!='' && $limit=='' && $start == '')           
     $contents= $db->selectResult('school',"*"," status='1' AND school_state='".$userstate."'");    
     elseif($userstate!='' && $limit!='' && $start == '')           
     $contents= $db->selectResult('school',"*"," status='1' AND school_state='".$userstate."' ORDER BY school_name ASC LIMIT 0,".$limit);    
     elseif($userstate!='' && $limit!='' && $start != '')           
     $contents= $db->selectResult('school',"*"," status='1' AND school_state='".$userstate."' ORDER BY school_name ASC LIMIT ".$start.",".$limit);        
     else
     $contents= $db->selectResult('school',"*"," status='1'");        
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('school_phoneno' => $value->school_phoneno,
         'school_description' => $value->school_description,
         'school_name' => $value->school_name,
         'school_website' => $value->school_website,
         'school_pincode' => $value->school_pincode,
         'school_street' => $value->school_street,
         'school_city' => $value->school_city,
         'school_state' => $value->school_state,      
         'school_id' => $value->school_id,
         'school_logo_id' => self::getImageContent(round($value->school_logo_id))
     );
    }
     }
    return $data;
	}



    public static function getSchoolsearchList($userstate='',$search='',$limit='',$start=''){
      
        $db       = new Db();
                
     if($userstate!='' && $search!='')           
     $contents= $db->selectResult('school',"*"," status='1' AND school_state='".$userstate."' AND school_name LIKE '%".$search."%' OR school_pincode LIKE '%".$search."%' OR school_city LIKE '%".$search."%'  OR school_state LIKE '%".$search."%'");        
     else
     $contents= $db->selectResult('school',"*"," status='1'");        
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('school_phoneno' => $value->school_phoneno,
         'school_description' => $value->school_description,
         'school_name' => $value->school_name,
         'school_website' => $value->school_website,
         'school_pincode' => $value->school_pincode,
         'school_street' => $value->school_street,
         'school_city' => $value->school_city,
         'school_state' => $value->school_state,      
         'school_id' => $value->school_id,
         'school_logo_id' => self::getImageContent(round($value->school_logo_id))
     );
    }
     }
    return $data;
    }



    public static function getSchoolListalls($userstate='',$limit){
               
        $db       = new Db();
                
     if($userstate)           
     $contents= $db->selectResult('school',"*"," status='1' AND school_state='".$userstate."' ORDER BY school_name ASC LIMIT 0,".$limit);    
     else
     $contents= $db->selectResult('school',"*"," status='1'");        
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('school_phoneno' => $value->school_phoneno,
         'school_description' => $value->school_description,
         'school_name' => $value->school_name,
         'school_website' => $value->school_website,
         'school_pincode' => $value->school_pincode,
         'school_attendence' => $value->school_attendence,
         'school_street' => $value->school_street,
         'school_city' => $value->school_city,
         'school_state' => $value->school_state,      
         'school_id' => $value->school_id,
         'school_logo_id' => self::getImageContent(round($value->school_logo_id))
     );
    }
     }
    return $data;
    }
        
public static function getSchoolListPage($userstate='',$start,$limit){
        
            
        $db       = new Db();
                
     if($userstate)           
     $contents= $db->selectResult('school',"*"," status='1' AND school_state='".$userstate."' ORDER BY school_name ASC LIMIT ".$start.",".$limit);    
     else
     $contents= $db->selectResult('school',"*"," status='1'");        
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('school_phoneno' => $value->school_phoneno,
         'school_description' => $value->school_description,
         'school_name' => $value->school_name,
         'school_website' => $value->school_website,
         'school_pincode' => $value->school_pincode,
         'school_street' => $value->school_street,
         'school_attendence' => $value->school_attendence,
         'school_city' => $value->school_city,
         'school_state' => $value->school_state,      
         'school_id' => $value->school_id,
         'school_logo_id' => self::getImageContent(round($value->school_logo_id))
     );
    }
     }
    return $data;
    }


    /*
     * function to return the slots
     */

     public static function getSchoolSlots(){
        $db       = new Db();
     $slots= $db->selectResult('slot',"*",'');       
     $data = array();
     if($slots){
     foreach ($slots as $key => $value) {   
         $data[] = array('slot_name' => $value->slot_name,
         'slot_desc' => $value->slot_desc
     );
    }
     }
    return $data;
    }
        


    /*
     * function to return the list of Order Campign List
     */
     
    public static function getOrderCampignList($school_id,$slot_id){
        $db       = new Db();
     $contents= $db->selectResult('order_details',"*"," odd_status!='2' AND school_id='".$school_id."' AND slot_id='".$slot_id."'");    
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('campaign_start_date' => $value->campaign_start_date,
         'campaign_end_date' => $value->campaign_end_date,
                'od_share_voice' => $value->od_share_voice,
             
         'campaign_name' => self::getCampaignName($value->order_id),
         'payment_status' => self::getOrderStatus($value->order_id)
     );
    }
     }
    return $data;
    }



    /*
     * function to return the list of Order Campign List
     */
     
    public static function getCampignList($school_id){
        $db       = new Db();
     $contents= $db->selectResult('order_details',"*"," odd_status!='2' AND school_id='".$school_id."' AND campaign_end_date>CURDATE()");    
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('campaign_start_date' => $value->campaign_start_date,
         'campaign_end_date' => $value->campaign_end_date,
         'campaign_name' => self::getCampaignName($value->order_id),
         'slot_name' => self::getSlotName($value->slot_id),
         'payment_status' => self::getOrderStatus($value->order_id)
     );
    }
     }
    return $data;
    }


         /*
     * function to get the user id from smb app id information
    */
    public static function getArtdetailsList($order_id,$orderdetail_id) {
        $db   =   new Db();
       $contents= $db->selectResult('artworks',"*"," order_id='".$order_id."' AND od_id='".$orderdetail_id."'");    
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('url' => $value->url,
         'description' => $value->description,
         'artworks_image1_id' => $value->artworks_image1_id,
         'artworks_image2_id' => $value->artworks_image2_id,
         'image1' => self::getImageContent(round($value->artworks_image1_id)),
         'image2' =>  self::getImageContent(round($value->artworks_image2_id))
     );
    }
     }
    return $data;
    }







     public static function getCampign($orderdetail_id,$order_id){
        $db       = new Db();
     $contents= $db->selectResult('order_details',"*"," odd_status!='2' AND order_id='".$order_id."'  AND od_id='".$orderdetail_id."'");    
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('campaign_start_date' => $value->campaign_start_date,
         'campaign_end_date' => $value->campaign_end_date,
         'school_name' => self::getSchoolName($value->school_id),
         'slot_name' => self::getSlotName($value->slot_id),
         'plan_name' => self::getPlanName($value->plan_id),
         'duration' => $value->plan_period,
         'order_status' => self::getOrderStatus($value->order_id)
     );
    }
     }
    return $data;
    }
        


        
        
    public static function addSlotsToSchool($school_id)
    {
        
        
        
      //$schools= $db->selectResult('school',"*"," $school_id='".$school_id."'");    
      
       $db       = new Db(); 
          $slots= $db->selectResult('slot',"*",'');    
          foreach ($slots as $kk=>$vv)
          {
               $tableName             =   Utils::setTablePrefix('school_slot');
                      $od_id            =   $db->insert($tableName,
                    array(  'school_id'     		=>  Utils::escapeString($school_id),
                    'slot_id'     		=>  Utils::escapeString($vv->slot_id)
                      
                        
                      ));
          }
      
    }

    
     public static function getPlans()
     {
          $db       = new Db(); 
         $contents= $db->selectResult('plans',"*"," plan_status='1'");   
       //  echopre($contents);
         return $contents;
     }


     

        
     public static function getCartInfo($cartobjects)
     {
         $db       = new Db();
         
         $data = array();
         
        if($cartobjects){ 
        foreach($cartobjects as $k=>$v){ 
        if(isset($v['school_id'])){    
             $data[$k]=$v;
        $query = "select * from tbl_school tbs inner join tbl_tier tt on tbs.school_tier_id = tt.tier_id where school_id = '".$v['school_id']."'";    
     //   echo $query;
        $contents= $db->selectQuery($query);
        
        $plans = $db->selectResult('plans',"*"," plan_id='".$v['plan_id']."'"); 
        
       
        
        
        
        $data[$k]['school_name'] = $contents[0]->school_name;
        $data[$k]['tier_name'] = $contents[0]->tier_name;
        $data[$k]['plan_name'] = $plans[0]->plan_name;
        $data[$k]['plan_period'] = $plans[0]->plan_period;
        
        
        }
        }
        }  
        return $data;
        //echopre($data);
        
     }
             






     /*
	 * function to get the SchoolListDetail
	 */
	public static function getSchoolListDetail($schoolId) {

		$db       = new Db();
     $contents= $db->selectResult('school',"*"," school_id=".$schoolId);    
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) {   
         $data[] = array('school_phoneno' => $value->school_phoneno,
         'school_description' => $value->school_description,
         'school_name' => $value->school_name,
         'school_website' => $value->school_website,
         'school_pincode' => $value->school_pincode,
         'school_attendence' => $value->school_attendence,
         'school_attendence' => $value->school_attendence,
         'school_street' => $value->school_street,
         'school_state' => $value->school_state,
         'school_city' => $value->school_city,
         'school_id' => $value->school_id,
         'conference_id' => self::getTagContent($value->conference_id),
         'school_tier_id' => $value->school_tier_id,
         'school_logo_id' => self::getImageContent(round($value->school_logo_id))
     );
    }
     }


		return $data;
		
	}




public static function getTagContent($c_id)
   {
   
      $myArray = explode(',', $c_id);   
     $db       = new Db();
       $contents = array();
     foreach ($myArray as $myid) {
         $contents[] = $db->selectResult('conference',"*"," conference_id='$myid'");    
     }
    
     $data = array();
     if($contents){
       
     foreach ($contents as $content) {   
         $data[] = array(
            'id' => $content[0]->conference_id,
            'name' => $content[0]->conference_name
         );
        }
     }
    return $data;
   }




   public static function getTagListContent()
   {

     $db       = new Db();
     $contents= $db->selectResult('school',"*"," status='1' ");    
     $data = array();
     if($contents){
     foreach ($contents as $key => $value) { 

        $tagArray = explode(',', $value->conference_id);
 
foreach ($tagArray as $k => $v) {

    $tagdet = $db->selectRecord('conference',"*","conference_id = {$v}");
   //print_r($tagdet); exit;

 $data[$tagdet->conference_name][] = array( 'school_name' => $value->school_name,
         'school_website' => $value->school_website,
         'school_pincode' => $value->school_pincode,
         'school_attendence' => $value->school_attendence,
         'school_attendence' => $value->school_attendence,
         'school_street' => $value->school_street,
         'school_state' => $value->school_state,
         'school_city' => $value->school_city,
         'school_id' => $value->school_id,
         'school_tier_id' => $value->school_tier_id,
         'school_logo_id' => self::getImageContent(round($value->school_logo_id))
         );

        }

    }
     }
//echopre($data); exit;
    return $data;
   }



		/*
	 * function to get the Schoollogo
	 */
	 public static function getImageContent($pId)
   {

     $db       = new Db();
     $contents= $db->selectRow('files',"file_path","file_id='$pId'"); 
      return $contents;
    }
	


        /*
     * function to get the Campaign Name
     */
     public static function getCampaignName($oId)
   {

     $db       = new Db();
     $contents= $db->selectRow('orders',"campaign_name","order_id='$oId'"); 
      return $contents;
    }


        /*
     * function to get the Campaign Name
     */
     public static function getPaymentStatus($oId)
   {

     $db       = new Db();
     $contents= $db->selectRow('orders',"payemnt_status","order_id='$oId'"); 

     if($contents==1){
            $content = 'Approved';
     }elseif($contents==2){
            $content = 'Rejected';
     }else{
        $content = 'Cancelled';
     }

      return $content;
    }



      public static function getOrderStatus($oId)
   {

     $db       = new Db();
     $contents= $db->selectRow('order_details',"odd_status","order_id='$oId'"); 

     if($contents==1){
            $content = 'Confirmed';
     }elseif($contents==2){
            $content = 'Cancelled';
     }else{
        $content = 'Pending';
     }

      return $content;
    }



      public static function getSlotName($sId)
   {

     $db       = new Db();
     $contents= $db->selectRow('slot',"slot_name","slot_id='$sId'"); 

      return $contents;
    }


       public static function getSchoolName($sId)
   {

     $db       = new Db();
     $contents= $db->selectRow('school',"school_name","school_id='$sId'"); 

      return $contents;
    }



       public static function getPlanName($sId)
   {

     $db       = new Db();
     $contents= $db->selectRow('plans',"plan_name","plan_id='$sId'"); 

      return $contents;
    }



    
	
}
 


?>