
<?php //print_r($_SESSION["products"]);?>

<script type="text/javascript">
    
function removecart(key)
{
if(confirm('Are you sure that you want to remove the item') ) {

$("#block_"+key).remove();

var total = 0;  
$.ajax({url: siteUrl+"index/removecartsession/"+key, success: function(result){
 var cn = $("#cart-info2").text();
 cn = cn-1;
 $("#cart-info2").html(cn);
 if(cn==0){
   $("#advt-cartbox").html("Your Cart is empty");
}
}});
$(".block-sec" ).each(function( index ) { 
  var amount = $( this ).find('.amount').text();
  total = parseInt(total) + parseInt(amount);
});
$("#total_amount").html(total.toFixed(2));
 }
}

</script>    



<section id="services" class="inner-top-mrgin">
        
        <div class="container">
            <div class="row">







              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo BASE_URL;?>schools">Schools</a></li>
                 <li class="breadcrumb-item active">Orders</li>
              </ol>




<div class="col-md-6 advt-box">
<!-- <div class="full-width"><img src="<?php  echo BASE_URL;?>project/img/steps.png" class="img-responsive"></div> -->
<h2 class="map-head no-mrg">Campaign Information</h2>
<form class="form-horizontal form-top" name="form1" method="post">
      <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" name="campaign_name" class="form-control" id="inputEmail3" placeholder="Campaign Name *" required="">
    </div>
      
  </div>
  <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" name="lead_fname" class="form-control" id="inputEmail3" placeholder="First Name *" required="">
    </div>
      
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text"  name="lead_lname" class="form-control" id="inputEmail3" placeholder="Last Name *" required="">
    </div>
      
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="email" class="form-control" id="inputEmail3" placeholder="Email to Send Invoice *" name="lead_email" required="">
    </div>
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Business Name *" name="lead_company" required="">
    </div>
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Address *" name="lead_address" required="">
    </div>
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
      <select class="form-control" id="inputEmail3" placeholder="Select State *" required name="lead_state"> 
    
     <?php foreach(PageContext::$response->states as $k=>$result){ ?>
       <option value="<?php echo $result->value ?>"><?php echo $result->text ?></option>
<?php } ?>
        </select>
    </div>
  </div> 
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Phone number *" name="lead_phoneno" required="">
    </div>
  </div>
    <div class="form-group">
   
    <div class="col-sm-12">
        <input type="text" class="form-control" id="inputEmail3" placeholder="Zip Code *" pattern="[0-9]{4,6}" title="Digit zip code" name="lead_pincode" required="">
    </div>
  </div>



  <div class="form-group">
   
    <div class="col-sm-12">
      <select class="form-control" id="inputEmail3" placeholder="Contract Type *" required name="contract_type"> 
    

       <option value="Prepaid Agreement - One time Invoice">Prepaid Agreement - One time Invoice</option>
       <option value="Recurring Invoice ">Recurring Invoice </option>
       <option value="Other (specify below)">Other (specify below)</option>

        </select>
    </div>
  </div> 

     <div class="form-group">
   
    <div class="col-sm-12">
        <textarea placeholder="Campaign Additional Info.." class="form-control" name="order_decription"></textarea>  </div>
  </div>
   
   



  <div class="form-group">
    <div class="col-sm-12">
        <button type="submit" class="cart-btn pull-right" value="submit" name="submit">Confirm</button>
    </div>
  </div>
</form>
</div>
<div class="col-md-offset-1 col-md-5  advt-box" id="advt-cartbox">
<?php
if(isset($_SESSION["products"]) && count($_SESSION["products"])>0){?>

<h2 class="under-line map-head no-mrg btm-pd">Order Summary</h2>
<div class="section-box scroll-new">
<?php
 foreach(PageContext::$response->carInfo as $k=>$product){ //Print each item, quantity and price.
    $product_name = $product["ad_name"];
    $plan_id = $product["plan_id"]; 
    $planname = $product['plan_name'];
    $product_qty = $product["share_of_voice"];
    $product_price = $product["ad_amount"];
    $plantime = $product["plan_period"];
    $product_code = $product["school_slot_id"];
    $item_price   = sprintf("%01.2f",($product_price * $product_qty * $plantime));  
$time = strtotime($product['campaign_start_date']);
$final = date("m/d/Y", strtotime("+$plantime month", $time));

// price x qty = total item price
    ?>
<div class="full-width block-sec" id="block_<?php echo $k?>">
<h3 class="no-mrg"><?php echo $product_name;?></h3>
<h6><span class="glyphicon glyphicon-blackboard cart-icn" aria-hidden="true"></span>School Name : <?php echo $product['school_name'];?> (<?php echo $product['tier_name'];?>)</h6>
<h6><span class="glyphicon glyphicon-th-list cart-icn" aria-hidden="true"></span></span>Plan name: <?php echo $planname;?></h6>
<h6><span class="glyphicon glyphicon-hourglass cart-icn" aria-hidden="true"></span>Duration : <?php echo $plantime;?> Months</h6>
<h6><span class="glyphicon glyphicon-calendar cart-icn" aria-hidden="true"></span>Campaign Start-End Date : <?php echo $product['campaign_start_date'];?> -  <?php echo $final; ?></h6>
<h6><span class="glyphicon glyphicon-duplicate cart-icn" aria-hidden="true"></span>Share of voice : <?php echo $product_qty;?></h6>
<h6><span class="glyphicon glyphicon-usd cart-icn" aria-hidden="true"></span>1 Month/1 Share Price : $<?php echo $product_price;?></h6>


<span class="text-amount">Price </span> : <b>$<span class="amount"> <?php echo $item_price;?></span></b>
<b><a href="javascript:void(0);" id="remove" class="pull-right" onclick="removecart('<?php echo $k?>')"><span class="glyphicon glyphicon-remove icons"></a></b>
</div>


    <?php
     
    $subtotal     = ($product_price * $product_qty * $plantime); //Multiply item quantity * price
    $total      = ($total + $subtotal); //Add up to total price
  }
  

  ?>
   
</div>


   <div class="full-width">
    <h4 class="new-top-margin t-amount"><b>Total Cost  : $ </b><span class="t-amount" id="total_amount"><?php  echo sprintf("%01.2f", $total);?></span>
        </h4>
    </div>



</div>
<?php
 
}else{
  echo "Your Cart is empty";
}
?>
    </section>


<style>
#mainNav{
    background:#0074bd;
    border-color: rgba(34, 34, 34, 0.05);
    height:79px;
}
</style>
