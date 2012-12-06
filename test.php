<?php
require_once 'BadgefeverSDK.php';

$bf = new BadgefeverSDK('qwepoi61','7000671891ef69412715f88218908540');
echo $bf->getBadges('test@badgefever.com','json',array('size'=>'medium'));