<?php

function filterXSS($val) {
            // remove all non-printable characters. CR(0a) and LF(0b) and TAB(9) are allowed
            // this prevents some character re-spacing such as <java\0script>
            // note that you have to handle splits with \n, \r, and \t later since they *are* allowed in some inputs
            $val = preg_replace('/([\x00-\x08][\x0b-\x0c][\x0e-\x20])/', '', $val);
     
            // straight replacements, the user should never need these since they're normal characters
            // this prevents like <IMG SRC=&#X40&#X61&#X76&#X61&#X73&#X63&#X72&#X69&#X70&#X74&#X3A&#X61&#X6C&#X65&#X72&#X74&#X28&#X27&#X58&#X53&#X53&#X27&#X29>
            $search = 'abcdefghijklmnopqrstuvwxyz';
            $search .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $search .= '1234567890!@#$%^&*()';
            $search .= '~`";:?+/={}[]-_|\'\\';
            for ($i = 0; $i < strlen($search); $i++) {
                // ;? matches the ;, which is optional
                // 0{0,7} matches any padded zeros, which are optional and go up to 8 chars
     
                // &#x0040 @ search for the hex values
                $val = preg_replace('/(&#[x|X]0{0,8}'.dechex(ord($search[$i])).';?)/i', $search[$i], $val); // with a ;
                // &#00064 @ 0{0,7} matches '0' zero to seven times
                $val = preg_replace('/(&#0{0,8}'.ord($search[$i]).';?)/', $search[$i], $val); // with a ;
            }
     
            // now the only remaining whitespace attacks are \t, \n, and \r
            $ra1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');
            $ra2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
            $ra = array_merge($ra1, $ra2);
     
            $found = true; // keep replacing as long as the previous round replaced something
            while ($found == true) {
                $val_before = $val;
                for ($i = 0; $i < sizeof($ra); $i++) {
                    $pattern = '/';
                    for ($j = 0; $j < strlen($ra[$i]); $j++) {
                        if ($j > 0) {
                            $pattern .= '(';
                            $pattern .= '(&#[x|X]0{0,8}([9][a][b]);?)?';
                            $pattern .= '|(&#0{0,8}([9][10][13]);?)?';
                            $pattern .= ')?';
                    }
                    $pattern .= $ra[$i][$j];
                 }
                 $pattern .= '/i';
                 $replacement = substr($ra[$i], 0, 2).''.substr($ra[$i], 2); // add in <> to nerf the tag
				 $replacement = "";
                 $val = preg_replace($pattern, $replacement, $val); // filter out the hex tags
                 if ($val_before == $val) {
                    // no replacements were made, so exit the loop
                    $found = false;
                 }
              }
            }
     
            return $val;
  }
  /*  Finaliza Agregado */


function trim_r(&$item, $key)
{
    // If the item is an array, recursively use array_walk 
    if(is_array($item))
        array_walk($item, 'trim_r');
    // Trim the item
    else if(is_string($item))
        $item = trim($item);
}

function stripslashes_r(&$item, $key)
{
    // If the item is an array, recursively use array_walk 
    if(is_array($item))
        array_walk($item, 'stripslashes_r');
    // stripslashes the item
    else if(is_string($item))
        $item = stripslashes($item);
}

function mysql_real_escape_string_r(&$item, $key)
{
global $vinculo;
    // If the item is an array, recursively use array_walk 
    if(is_array($item))
        array_walk($item, 'mysql_real_escape_string_r');
    // mysql_real_escape_string the item
    else if(is_string($item))
        $item = mysqli_real_escape_string($vinculo,$item);
        //$item = mysql_real_escape_string($item);
}








function get_ip() {

		//Just get the headers if we can or else use the SERVER global
		if ( function_exists( 'apache_request_headers' ) ) {

			$headers = apache_request_headers();

		} else {

			$headers = $_SERVER;

		}

		//Get the forwarded IP if it exists
		if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

			$the_ip = $headers['X-Forwarded-For'];

		} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
		) {

			$the_ip = $headers['HTTP_X_FORWARDED_FOR'];

		} else {
			
			$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );

		}

		return $the_ip;

	}
	
	
	function getRealIP() {
        if (!empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
           
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
       
        return $_SERVER['REMOTE_ADDR'];
    }

function session_segura(){
	
	
       ini_set('session.use_only_cookies', 'Off');
        ini_set('session.use_cookies', 'On');
        ini_set('session.use_trans_sid', 'Off');
        ini_set('session.cookie_httponly', 'On');

        if (isset($_COOKIE[session_name()]) && !preg_match('/^[a-zA-Z0-9,\-]{22,52}$/', $_COOKIE[session_name()])) {
            exit('Error: Invalid session ID!');
        }

        session_set_cookie_params(0, '/');


	$secure = false; //https
	$httponly = true;
	// Force the session to only use cookies, not URL variables.
	ini_set('session.use_only_cookies', 1);
	// Get session cookie parameters 
	$cookieParams = session_get_cookie_params(); 
	// Set the parameters
	session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $cookieParams["domain"], $secure, $httponly); 

        session_start();	
	
	
}

function check_abort(){
	echo "abortado.....";
	exit();
}
//register_shutdown_function("check_abort");

function checkAcceso($redirecciona = ''){
	$token = isset($_REQUEST["token"]) ? $_REQUEST["token"] : '';
	
	//Leer variables de session y cerrarla.
	session_start([
		'read_and_close'  => true,
	]);	
	
	if(
	$_SESSION['_USER_IP'] != getRealIP() ||
	$_SESSION['_USER_AGENT'] != $_SERVER['HTTP_USER_AGENT'] ||
	 !isset($_SESSION['accesos'][$token]) || 
	 !isset($_SESSION['accesos'][$token]["id_usuarios"]) || 
	 !isset($_SESSION['accesos'][$token]["nombre_usuarios"]) ){
		 
		//session_write_close();
		 //print_r($_SESSION);
		if($redirecciona!=''){
			header("location: $redirecciona",true,301);
		}
		exit();
	}
}
	
	
function checkApp($aApps = array(),$appid='',$redirecciona = ''){
	$flag_ok = 0;
	foreach($aApps as $app){
		if($app['appid']==$appid){$flag_ok = 1;}
	}
	if($flag_ok==0){
		if($redirecciona!=''){
			header("location: $redirecciona",true,301);
		}
		exit();
	}	
}	
	
include "plantilla1.php";
include "plantilla_listado1.php";	
?>