<?php

class fblogin
{

	public function login()
	{
	
		require 'facebook.php';
		
		define('APP_ID', '451833041516954');
		define('APP_SECRET', '84531d8e509577986352c9107cd42262');
		
		$facebook 	= new Facebook(array(
					'appId' 	=> APP_ID,
					'secret' 	=> APP_SECRET,
					));
				 
		$my_url 	=  ConfigUrl::base().'index/register/facebook';
		$code		= $_REQUEST["code"];
		if($code != '')
		{
			$token_url = 'https://graph.facebook.com/oauth/access_token?client_id='
						. APP_ID . '&redirect_uri=' . urlencode($my_url) 
						. '&client_secret=' . APP_SECRET 
						. '&code=' . $code;
			$access_token = file_get_contents($token_url);
		
			if($access_token != '')
			{
				// code to get the user name and userid
				// Run fql multiquery
				$fql_multiquery_url = 'https://graph.facebook.com/'
				. 'fql?q={"my+name":"SELECT+name,uid+FROM+user+WHERE+uid=me()"}'
				. '&' . $access_token;
				$fql_multiquery_result = file_get_contents($fql_multiquery_url);
				$fql_multiquery_obj = json_decode($fql_multiquery_result, true);
				$userDet = array('data'=> $fql_multiquery_obj,'access_token'=>$access_token);
				return $userDet;
			}
		
			
		} else {
			# There's no active session, let's generate one
			$login_url = $facebook->getLoginUrl(array( 'scope' => 'email'));
			header("Location: " . $login_url);
		}
	}
}
?>