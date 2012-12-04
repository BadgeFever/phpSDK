<?php
require_once 'BadgefeverSDK.php';

$bf = new BadgefeverSDK();
echo $bf->getBadges('dostal.it@gmail.com','html',array('size'=>'medium'));