<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/helper_classes/NP_Token.php');
	require_once('../hidden/data_model/NP_UserModel.php');
	require_once('../hidden/service_layer/NP_UserService.php');


	class AuthenticationService extends NP_service{

		function authenticateByFacebookToken($short_lived_facebook_token)
		{

			$facebook_token = AuthenticationService::getLongLivedFacebookToken($short_lived_facebook_token);

			//Confirm that the token is valid.
			$profile = $this->getFacebookProfile($facebook_token);

			//Now get user by the Facebook id to see if the user already exists in the system
			$userService = new UserService($this->DBH);
			$response = $userService->getUserByFacebookId($profile['id']);


			$user = new UserModel;
			$token;
			
			//If the user does not yet exist, this is the first login.  Create the user.
			if(empty($response)) {
				$token = new Token;
				$user->email = $profile['email'];
				$user->facebook_id = $profile['id'];
				$user->facebook_token = $facebook_token;
				
				$user->token = $token->token;
				$user->token_expiry = $token->token_expiry;	

				$record = $userService->doSimpleCreate($user);			
			}
			//Otherwise, check to see if the facebook token has changed.
			else {
				//If the facebook token has changed or the current token is invalid, generate a new token
				if($facebook_token != $response->facebook_token || date($response->token_expiry) < date("Y-m-d H:i:s"))
				{
					$token = new Token;
					$user->id = $response->id;
					$user->token = $token->token;
					$user->token_expiry = $token->token_expiry;	
					$record = $userService->doSimpleUpdate($user);
				}

				//Otherwise, extend the current token
				else
				{
					$token = new Token($response->token);
					$user->id = $response->id;
					$user->token_expiry = $token->token_expiry;	
					$record = $userService->doSimpleUpdate($user);
				}
			}

			return $token;
		}

		public static function getLongLivedFacebookToken($short_lived_facebook_token)
		{
			$facebook = parse_ini_file('../hidden/git_ignore/facebook.ini');
			$graph_url = "https://graph.facebook.com/oauth/access_token?grant_type=fb_exchange_token&client_id=" . $facebook['app_id'] . "&client_secret=" . $facebook['app_secret'] . "&fb_exchange_token=" . $short_lived_facebook_token;
			
			$curl = curl_init($graph_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			parse_str($response, $output);

			if (!array_key_exists('access_token', $output))
				throw new AuthenticationFailedException("The Facebook token provided could not be validated.");
			
			return $output['access_token'];
		}

		public static function getFacebookProfile($facebook_token)
		{
			$graph_url = "https://graph.facebook.com/me?access_token=" . $facebook_token;
			$curl = curl_init($graph_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			$response = json_decode( $response, TRUE );

			if (array_key_exists('error', $response) && !empty($response['error']))
				throw new AuthenticationFailedException("The Facebook token provided could not be validated.");				

			if (!array_key_exists('email', $response))
				throw new AuthenticationFailedException("The identity of the Facebook user could not be validated.");

			return $response;
		}
	}
?>
