# mobileAPI.php

This php API deployed on Raspberry Pi and works with Android app [Remote Controller - HTTP API](https://play.google.com/store/apps/details?id=biz.tedc.unlocker)

## Enviorment

![enviorment chart](https://cloud.githubusercontent.com/assets/7614818/21301655/83bfbe56-c5ea-11e6-93ac-50d605297cb5.png)

## Features

- Receive Web HTTP Calls and send RF433Mhz wireless signal.
- Account and password.
- User defines own Action code
- Extensible and simple PHP code

## Require enviorment

- Raspberry Pi(Public IP is needed for using with Internet)
- RF433 Module for Raspberry Pi
- RF signal compatible receiver(such as door locker, wireless switch, etc.)

## Getting Started

Setup your Raspberry Pi with Internet connectivity and Nginx web server(or any webserver).

Put **mobileAPI.php** at web server's root directory.

Edit **RF Code** and **User**(*Name* and *Password* and allow *Action*)

Execute codesend needs **sudo**, make sure www-data(or any other user that executes) in sudoer list

Call this API with [Remote Controller - HTTP API](https://play.google.com/store/apps/details?id=biz.tedc.unlocker)

## Samples

Configuration
```php
<?php
// RF code for sending
$rfCode = '6675618';
// Change path if 433Util in different path
$binaryPath = '/home/pi/433Utils/RPi_utils/codesend';
...
?>
```

Action
```php
<?php
  ...
  case 'action2':
    // You may edit for your own usage, here is sample
    $rfCode2 = '6675999'; // Send another code
    $cmd = $binaryPath.' '.$rfCode2.' &';
    exec($cmd);
    break;
  case 'action3':
    // You may edit for your own usage, here is sample
    $cmd = 'Do something with your RPi';
    exec($cmd);
    break;
...
?>
```

## Known Issue

If it is not stable with RF communication, send command **twice at once** is recommended.

(Make sure using this only when no problem if receives twice command.)

```php
<?php
...
exec($cmd);
exec($cmd);
...
?>
```

## Contribution

If you find a bug or want to contribute to the code or documentation, you can help by submitting an issue or a pull request.