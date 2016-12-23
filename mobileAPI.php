<?php
/*
  mobileAPI.php
  - A HTTP API for Android app [Remote Controller - HTTP API](https://play.google.com/store/apps/details?id=biz.tedc.unlocker)
  - Author: Ted.C
*/
  
// ======= Edit these configurations =======
// RF code for sending
$rfCode = '6675618';
// Change path if 433Util in different path
$binaryPath = '/home/pi/433Utils/RPi_utils/codesend';

// ======= Users =======
$users = [];
$users['user1']['pw'] = 'u1pw';
$users['user1']['allow'] = ['ping','open','edit','sususu','action2'];
$users['user2']['pw'] = 'u2pw';
$users['user2']['allow'] = ['ping'];

$uid = $_POST['uid'];
$pwd = $_POST['pwd'];
$action = $_POST['action'];
$useSudo = true;
$serverPwd = 'changeme'; // server password not implemented yet
/*
Return :
  1 : OK
  2 : Password error
  3 : Action denied
  4 : Argument error
*/
// Authenticate
$allow = 0;
if(!$action || !$uid || !$pwd){
  $allow = 4;
}else{
  if($pwd === $users[$uid]['pw']){
    if(in_array($action, $users[$uid]['allow'])){
      $allow = 1;
    }else{
      $allow = 3;
    }
  }else{
    $allow = 2;
  }
}
if($allow !== 1){
  echo $allow;
  exit;
}
//var_dump($_POST);
switch($action){
  case 'sususu':
    // You may edit for your own usage
    echo "Action not implemented.";
    break;
  case 'action2':
    // You may edit for your own usage, here is sample
    $rfCode2 = '6675999';
    $cmd = $binaryPath.' '.$rfCode2.' &';
    exec($cmd);
    break;
  case 'ping':
    echo 1;
    break;
  case 'open':
    // code 'open' executes send defined rfCode via 433Utils
    echo 1;
    $cmd = '';
    if($useSudo){
      $cmd .= 'sudo ';
    }
    $cmd .= $binaryPath.' '.$rfCode.' &';
    // echo $cmd;
    exec($cmd);
    break;
  default :
    echo "Action not implemented.";
    break;
}
