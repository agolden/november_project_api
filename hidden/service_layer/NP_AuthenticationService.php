<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/service_layer/NP_UserService.php');
	
	class AuthenticateService extends NP_service{
    	
		function authorizeAction($app_token, $entity, $action)
		{
			$user = $this->validateAppToken($app_token);
		}

		//Get the user record by app token
		function validateAppToken($app_token)
		{
			$userService = new UserService($this->DBH);
			$user;

			try 
				$user = $userService->getUserByToken($token);
			catch (RecordNotFoundException $e)
				throw new AuthenticationFailedException("The token provided is invalid.  Please re-authenticate.");

			//If the token has expired, check the facebook token to see if it, too, has expired
			if($user['token_expiration'] < now) {
				
				$email;
				if(!empty($user['facebook_token']))
					$email = validateFacebookToken($user['facebook_token']);
				else
					throw new AuthenticationFailedException("The token provided is invalid.  Please re-authenticate."
				
				$user['email'] = $email;
				$user['token_expiry'] = Date('Y-m-d H:i:s', strtotime("+10 days"));

				$userService->updateUser($user);
			}

			return $user;
		}

		//Get the Facebook profile by Facebook token
		function validateFacebookToken($facebook_token)
		{
			throw new AuthenticationFailedException("The token provided is invalid.  Please re-authenticate.");
		}

		function authorizeUserByFacebookToken($facebook_token)
		{
			$userService = new UserService($this->DBH);
			$profile = new FacebookProfile($this->validateFacebookToken($facebook_token));
			$user = new NP_UserModel;

			try
				$user = $userService->getUserByFacebookId($profile->getFacebookId());
			catch (RecordNotFoundException $e) {}

			$user['email'] = $profile->getEmail();
			$user['token'] = getNewToken();
			$user['token_expiry'] = Date('Y-m-d H:i:s', strtotime("+10 days"));

			$userService->upsertUser($user);
		}
	}
?>
