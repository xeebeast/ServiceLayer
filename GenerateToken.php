<?php 

namespace App\ServiceLayer;
use Illuminate\Http\Request;
use App\Http\Requests;
use Carbon;

/**
* 
*/
class GenerateToken
{
	public function GenerateAuthToken($email, $id)
    {
    
    	$user_id = $id;
    	$mytime = Carbon\Carbon::now();
    	//dd($mytime->toDateTimeString());	
    	$user_email = $email;
    	$random = rand(00000,99999);
    	$token_1 = base64_encode($user_id.$mytime.$user_email.$random);
    	$token_2 = preg_replace('/[^A-Za-z0-9\-]/', '', $token_1);

    	$chars = '$ab$c$$de$fxy$z$$Zz';

    	for ($i=0; $i < 9 ; $i++) { 

    		$random_position = rand(0,strlen($token_2)-$i);
    		$random_char = $chars[rand(0,strlen($chars)-rand(1,10))];
    		$token_2 = substr($token_2,0,$random_position).$random_char.substr($token_2,$random_position);
    	}
    	
    	return $token_2;
    
    }
}