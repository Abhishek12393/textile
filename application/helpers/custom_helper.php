<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Form Helpers
 *
 * @package		CodeIgniter
 * @subpackage	Helpers
 * @category	Helpers
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/helpers/form_helper.html
 */

 

if ( ! function_exists('pr'))
{
	/**
	 *
	 * print the array
	 *
	 * @return	array
	 */
	function pr($array,$header='-')
	{
		echo "<br><fieldset><legend>$header</legend><br>";
		echo "<pre style='background:black;color:white;width: fit-content;padding: 0 23px;'>";
		print_r($array);
		echo '</pre>';
		echo "</fieldset><br>";
	}
}

//------------------------------------------------------------------------
function prh($array,$header='')
{
	echo "<br><fieldset><legend>$header</legend><br>";
	echo "<pre style='background:#181818;color:white;padding: 0 23px;'>";
	print_r($array);
	echo '</pre>';
	echo "<br>";
}
function prb($array,$header='')
{
	echo "<br><fieldset><legend>$header</legend><br>";
	echo "<pre style='background:black;color:white;width: fit-content;padding: 0 23px;'>";
	print_r($array);
	echo '</pre>';
	echo "</fieldset></fieldset><br>";
}
if ( ! function_exists('prd'))
{
	/**
	 *
	 * print the array
	 *
	 * @return	array
	 */
	function prd($elem,$header='')
	{
		echo "<br><fieldset><legend>$header</legend><br>";
		echo "<pre style='background:black;color:white'>";
		print_r($elem);
		echo '</pre>';
		echo "</fieldset><br>";
		die();
	}
}

  
function send_sms($mobil_num, $rand_num){
	$MobileApiKey ='971f34c0-1a9c-11e7-9462-00163ef91450';
	$api_sms_status = file_get_contents("https://2factor.in/API/V1/".$MobileApiKey."/SMS/+91".$mobil_num."/".$rand_num);
	$sms_status = json_decode($api_sms_status); 
	return $sms_status->Status; 
}

function pincode_address($code){
 //	echo $code ;
 	$url="http://www.postalpincode.in/api/pincode/".urlencode($code);
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $curl_scraped_page = curl_exec($ch);
    curl_close($ch);
    return $curl_scraped_page;
 }
 
       
 

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function postdata(){
	$jsondata = file_get_contents('php://input');
	$postdata = json_decode($jsondata);
	return $postdata;
}


function api_call($urls,$Auth,$data=false){
	// call api when its authenticted //
 
	$url = BASE_URL.$urls;
	$ch = curl_init($url);

	if($data){
		$payload = json_encode($data);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
	}
	$header  = array(
	    'Content-Type:application/json',
	    'Auth:'.$Auth
	);
	//set the content type to application/json
	curl_setopt($ch, CURLOPT_HTTPHEADER,$header );

	//return response instead of outputting
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
	//execute the POST request
	$result = curl_exec($ch);

	//close cURL resource
	curl_close($ch);
	return json_decode($result);

}
 
 
// age calculator func from DOB for client or user
function dobToDate($input ,$user = 'user'){
	$birth_date     = new DateTime($input);
	$current_date   = new DateTime();

	$diff           = $birth_date->diff($current_date);
	if ($user == 'user' ){$text = 'You are' ;}else{$text = 'Client is';}
	return  $years     = $text." ".$diff->y . " years " . $diff->m . " months " . $diff->d . " days old..";
}

// can break into years only or years plus month days
function dobsimple($input,$month = 1 , $days = 1){
	$birth_date     = new DateTime($input);
	$current_date   = new DateTime();

	$diff = $birth_date->diff($current_date);
	$string = $diff->y . " Years ";
	$string .= $month == 1 ? $diff->m . " months " : '';
	$string .= $days == 1 ? $diff->d . " days" : '';

	return  $string;
}

function generate_otp(){
	$otp = 123456;
	return $otp;
}

function twelve_twentyfour($time){
	$_a = $time;
    $_a = explode(':',$_a);
    $_time = "";                    //initialised the variable.
    if($_a[0] == 12 && $_a[1] <= 59 && strpos($_a[2],"PM") > -1)
    {
        $_rpl = str_replace("PM","",$_a[2]);
        $_time = $_a[0].":".$_a[1].":".$_rpl;
    }
    elseif($_a[0] < 12 && $_a[1] <= 59 && strpos($_a[2],"PM")>-1)
    {
        $_a[0] += 12;
        $_rpl = str_replace("PM","",$_a[2]);
        $_time = $_a[0].":".$_a[1].":".$_rpl;
    }
    elseif($_a[0] == 12 && $_a[1] <= 59 && strpos($_a[2],"AM" ) >-1)
    {
        $_a[0] = 00;
        $_rpl = str_replace("AM","",$_a[2]);
        $_time = $_a[0].":".$_a[1].":".$_rpl;
    }
    elseif($_a[0] < 12 && $_a[1] <= 59 && strpos( $_a[2],"AM")>-1)
    {
        $_rpl = str_replace("AM","",$_a[2]);
        $_time = $_a[0].":".$_a[1].":".$_rpl;
    }
    return $_time;
   
}


// function since($timestamp, $level=6) {
// display "X time" ago, $rcs is precision depth
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}

// helper to decide which table to be used for selection or insertion :: 
 

function arr0dlt($arr){
	unset($arr[0]);
	$arr = array_values($arr);
	return $arr;
}

function checkAuth(){
	// has to be made
	if(isset($_SESSION[admin]) && isset($_SESSION['username']) && isset($_SESSION['role'])){
		// check token from database
		return $_SESSION['role'];
	}else{
		return 0;
	}
}

#extra
 
