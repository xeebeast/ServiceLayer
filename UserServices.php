<?php 

namespace App\ServiceLayer;

use Illuminate\Http\Request;
use App\Http\Requests;
use DB;
use Carbon\Carbon;
use App\User;
use App\AuthToken;
use App\LoginActivity;

/**
* 
*/
class UserServices 
{	
	/*
		Check if user already exists
	*/
	public function UserExistService($request)
	{
		$user = new User();
    	return $user->userExist($request);
	}	


	/*
		Create a new user
	*/
	public function CreateUser($request)
	{
		
		$user = new User();
	    return $user->NewUser($request);
	}

	/*
		User Authentication
	*/
	public function UserAuth($id, $token, $module)
	{
		
		$auth = new AuthToken();
		$user = new User();
		$login = new LoginActivity();
		
		$loginTime = Carbon::now()->toDateTimeString();
		$expiry = Carbon::parse('+1 year')->toDateTimeString();

		$login_id = $login->UserLogin($id, $module, $loginTime);
		$user->UserTokenUpdate($id, $token);

		return $auth->UserToken($id, $token, $expiry, $login_id->login_activity_id);
	}

	/*
		Logout functionality
	*/

	public function UserLogout($id, $autoExpired)
	{
		$auth = new AuthToken();
		$user = new User();
		$login = new LoginActivity();		

		$logoutTime =  Carbon::now()->toDateTimeString();

		$logout1 = $auth->UserLogout($id, $autoExpired);
		$logout2 = $user->UserLogout($id);
		$logout3 = $login->UserLogout($id, $logoutTime);

		return true;
	}	
}