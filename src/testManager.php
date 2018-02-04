<?php

include ("user.php");
$user = new User();

$message = $user->verifyManager('test','test');

echo $message;