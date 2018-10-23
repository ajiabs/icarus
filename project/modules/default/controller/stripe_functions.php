<?php
//error_reporting(E_ALL);
//ini_set('display_errors',1); 
require_once('stripe-php-6.4.1/init.php');

//  \Stripe\Stripe::setApiKey('sk_live_XSmamAYHGCoryi7xgxr6SmQx');
// \Stripe\Stripe::setApiKey('sk_test_tiKsd05FVjXSNK1uAiGgny7n');

\Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);

// header('Access-Control-Allow-Origin: *');
// header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
// header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

// if($_GET['action']=='subscribe')
// { echo 'here';exit;
// //return $_POST;
// $request_body = file_get_contents('php://input');

// // print_r(json_decode($request_body,true));exit;
// $data=json_decode($request_body,true);

// $token=$data['token'];
// $plan=$data['plan'];

// echo monthly_subscription($token,$plan);
// exit;

// }






// echo single_payment('tok_CSKT8QbAfKncNx');
// echo monthly_subscription('tok_CSKpCiIq2Ak22q');
// echo create_stripe_coupon();
// exit;

function single_payment($customer_id,$amount)
{
  try{
        $charge = \Stripe\Charge::create(['amount' => $amount, 'currency' => 'usd', 'customer' => $customer_id]);
return array('status'=>1,'charge_id'=>$charge->id);

  }
catch ( \Stripe\Error\Base $e ) {
  // Code to do something with the $e exception object when an error occurs.
  
  return array('status'=>0,'message'=>$e->getMessage(),'stripe_customer_id'=>'');

}    
}





function monthly_subscription($username,$token,$plan)
{
  
  $customer=create_customer($username,$token);
  //$plan=create_stripe_plan();
  if($customer['status']==1 && $plan!='alacarte'){
    $subscription=create_subscription($customer['stripe_customer_id'],$plan);
   //if($subscription['status']==0)
     return $subscription;
  }
   return $customer;
}


function cancel_subscription($subscription_id,$at_period_end=false)
{
  try{
  $subscription = \Stripe\Subscription::retrieve($subscription_id);
  if($at_period_end)
     $subscription->cancel(['at_period_end' => true]);
  else
     $subscription->cancel();
     return array('status'=>1,'message'=>'Cancelled successfully');

  }
  catch ( \Stripe\Error\Base $e ) {
    // Code to do something with the $e exception object when an error occurs.
    
    return array('status'=>0,'message'=>$e->getMessage(),'stripe_customer_id'=>'');
  
  }  
}



function refund_charge($charge_id)
{
  try{
  $refund = \Stripe\Refund::create([
      'charge' => $charge_id,
  ]);
  return array('status'=>1,'refund_id'=>$refund->id);
  }
  catch ( \Stripe\Error\Base $e ) {
    // Code to do something with the $e exception object when an error occurs.
    
    return array('status'=>0,'message'=>$e->getMessage(),'stripe_customer_id'=>'');
  
  }  

}

function change_subscription_plan($customer_id,$subscription_id,$plan)
{
try{
  $subscription = \Stripe\Subscription::retrieve($subscription_id);
  $change_result=\Stripe\Subscription::update($subscription_id, [
    'cancel_at_period_end' => false,
    'items' => [
          [
              'id' => $subscription->items->data[0]->id,
              'plan' => $plan,
          ],
      ],
  ]);
  \Stripe\Invoice::create([
    'customer' => $customer_id,
   ]);
  return array('status'=>1,'id'=>$change_result->id);

    }
  catch ( \Stripe\Error\Base $e ) {
    // Code to do something with the $e exception object when an error occurs.
    
    return array('status'=>0,'message'=>$e->getMessage(),'stripe_customer_id'=>'');
  
  }  

}


function create_customer($username,$token)
{
  try{
    $customer=\Stripe\Customer::create(array(
        "description" => $username,
        "source" => $token // obtained with Stripe.js
      ));
      return array('status'=>1,'message'=>'','stripe_customer_id'=>$customer->id);

    }
      catch ( \Stripe\Error\Base $e ) {
        // Code to do something with the $e exception object when an error occurs.
        
        return array('status'=>0,'message'=>$e->getMessage(),'stripe_customer_id'=>'');

      }    
      //print_r($customer);exit;
      // if($customer->account_balance=='0')
      //   return array('status'=>0,'message'=>'Card has Insufficient balance,please choose another card','stripe_customer_id'=>'');
      // else

      
}

function create_stripe_plan($amount,$plan_name,$plan_id)
{

    $plan=\Stripe\Plan::create(array(
        "amount" => $amount,
        "interval" => "month",
        "product" => array(
          "name" => $plan_name
        ),
        "currency" => "usd",
        "id" => $plan_id
      ));

      return $plan->id;
}


function delete_plan($plan_id)
{
  $product = \Stripe\Product::retrieve($plan_id);
  $product->delete();

}

function create_subscription($customer,$plan)
{
  try{
    $subscription=\Stripe\Subscription::create(array(
        "customer" => $customer,
        "items" => array(
          array(
            "plan" => $plan,
          ),
        )
        ));
        return array('status'=>1,'message'=>'','stripe_customer_id'=>$customer,'stripe_subscription_id'=>$subscription->id);
      }
        catch ( \Stripe\Error\Base $e ) {
          // Code to do something with the $e exception object when an error occurs.
          
          return array('status'=>0,'message'=>$e->getMessage(),'stripe_customer_id'=>$customer);

        }        
       // print_r($subscription);exit;
        // return $subscription->id;

}

function create_stripe_coupon()
{

    $coupon=\Stripe\Coupon::create(array(
        "percent_off" => 25,
        "duration" => "repeating",
        "duration_in_months" => 3,
        "id" => "NEWPOST25OFF")
      );
   return $coupon->id;
}


function retrieve_customer_card($customer)
{

  $cu = \Stripe\Customer::Retrieve(
    array("id" => $customer, "expand" => array("default_source"))
  );

  return array('brand'=>$cu->default_source->brand,'ending_in'=>$cu->default_source->last4);

}


function update_customer_card($customer,$token)
{
  $customer=\Stripe\Customer::update($customer, [
    'source' => $token,
]);
return array('stripe_customer_id'=>$customer->id);

}


?>