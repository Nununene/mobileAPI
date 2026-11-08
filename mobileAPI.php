<?php
/*
  mobileAPI.php
  - HTTP API for a Telegram bot or another HTTP client
  - Author: Ted.C

  Change log:
    2026/11/08: Remove sudo support
*/

// ======= Edit these configurations =======
$rfCode = '6675618'; // RF code sent by the open action
$binaryPath = '/usr/local/bin/codesend'; // Change if codesend is installed elsewhere

// ======= Users =======
$users = [];
$users['user1']['pw'] = 'changeme1';
$users['user1']['allow'] = ['ping', 'open', 'your_action'];
$users['user2']['pw'] = 'changeme2';
$users['user2']['allow'] = ['ping', 'open'];

// Read POST fields safely. Arrays and missing values are invalid arguments.
$uid = $_POST['uid'] ?? null;
$pwd = $_POST['pwd'] ?? null;
$action = $_POST['action'] ?? null;

/*
Return codes:
  1 : Request accepted
  2 : Password error or unknown user
  3 : Action denied
  4 : Missing or invalid arguments
*/
$allow = 0;

if (!is_string($uid) || !is_string($pwd) || !is_string($action)
    || $uid === '' || $pwd === '' || $action === '') {
    $allow = 4;
} elseif (!isset($users[$uid]) || $pwd !== $users[$uid]['pw']) {
    $allow = 2;
} elseif (in_array($action, $users[$uid]['allow'], true)) {
    $allow = 1;
} else {
    $allow = 3;
}

if ($allow !== 1) {
    echo $allow;
    exit;
}

switch ($action) {
    case 'ping':
        echo 1;
        break;

    case 'open':
        // Send the configured RF code through 433Utils.
        echo 1;
        $cmd = escapeshellarg($binaryPath) . ' '
            . escapeshellarg($rfCode)
            . ' > /dev/null 2>&1 &';
        exec($cmd);
        break;

    case 'your_action':
        // Example custom action that sends another RF code.
        $rfCode2 = '6675999';
        $cmd = escapeshellarg($binaryPath) . ' '
            . escapeshellarg($rfCode2)
            . ' > /dev/null 2>&1 &';
        exec($cmd);
        break;

    default:
        echo 'Action not implemented.';
        break;
}
