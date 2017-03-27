<?php
/**
 *	Filemanager PHP connector
 *  Initial class, put your customizations here
 *
 *	@license	MIT License
 *	@author		Riaan Los <mail (at) riaanlos (dot) nl>
 *  @author		Simon Georget <simon (at) linea21 (dot) com>
 *  @author		Pavel Solomienko <https://github.com/servocoder/>
 *	@copyright	Authors
 */

// only for debug
// error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
// ini_set('display_errors', '1');

require_once('application/Fm.php');
require_once('application/FmHelper.php');

function auth()
{
    // IMPORTANT : by default Read and Write access is granted to everyone.
    // You can insert your own code over here to check if the user is authorized.
    // If you use a session variable, you've got to start the session first (session_start())


    $file = "/tmp/test_log.txt";

    foreach ($_REQUEST as $key=>$value) {
  		$myfile = file_put_contents($file, "_REQUEST : "."$key = " . urldecode($value).PHP_EOL , FILE_APPEND | LOCK_EX);
  	}

    foreach ($_COOKIE as $key=>$value) {
      $myfile = file_put_contents($file, "_COOKIE : ".$key."=".$value.PHP_EOL , FILE_APPEND | LOCK_EX);
    }

    //allow initate request
  	if ($_REQUEST['mode']=='initiate') {
      session_start();
      $_SESSION["root"]="test";
  		return true;
  	}
    //for other requests, need to check previllages of the folder
    elseif (isset($_REQUEST['path'])) {
      session_start();
      $myfile = file_put_contents($file, "_SESSION ROOT: ".$_SESSION['root'].PHP_EOL , FILE_APPEND | LOCK_EX);
      return siploAuthentication($_COOKIE['PHPSESSID'], $_REQUEST['path']);
    }
}

function siploAuthentication($cookieId, $path){
  if($cookieId){
    file_put_contents("/tmp/test_log.txt", "PHPSESSID =".$cookieId.PHP_EOL , FILE_APPEND | LOCK_EX);
    return true;
  }
  else{
    return false;
  }
}

$config = array();

// example to override the default config
//$config = array(
//    'upload' => array(
//        'policy' => 'DISALLOW_ALL',
//        'restrictions' => array(
//            'pdf',
//        ),
//    ),
//);

$fm = Fm::app()->getInstance($config);

// example to setup files root folder
//$fm->setFileRoot('userfiles', true);

// example to set list of allowed actions
//$fm->setAllowedActions(["select", "move"]);

$fm->handleRequest();