<?php
	require_once('../hidden/helper_classes/NP_Service.php');
	require_once('../hidden/helper_classes/NP_exceptions.php');
	require_once('../hidden/service_layer/NP_UserService.php');
	
	class AuthenticateService extends NP_service{
    	
		function authorizeAction($app_token, $entity, $action)
		{
			$user = $this->validateAppToken($app_token);
		}

		//returns the user record true if successful, false if not.
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

		//returns the Facebook profile if successful, false if not
		function validateFacebookToken($facebook_token)
		{
			throw new AuthenticationFailedException("The token provided is invalid.  Please re-authenticate.");
		}

		function authorizeUserByFacebookToken($facebook_token)
		{
			$userService = new UserService($this->DBH);
			$profile = new FacebookProfile($this->validateFacebookToken($facebook_token));
			
			try
				$user = $userService->getUserByFacebookId($profile->getFacebookId());
				$user['email'] = $profile->getNewToken();
				$user['token'] = getNewToken();
				$user['token_expiry'] = Date('Y-m-d H:i:s', strtotime("+10 days"));
				$userService->updateUser($user);
			catch (RecordNotFoundException $e)
				$userService->createUser($email);
				
			//Insert a new record if the user doesn't exist
			//Update the record with a new token if the user does exist
		}
	}
?>
