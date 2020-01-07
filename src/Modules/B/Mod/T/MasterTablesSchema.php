<?php


dd(\MS\Core\Helper\MSTableSchema::setUpForMod('Users'));

$m1=\MS\Core\Helper\MSTableSchema::getTableDataForTable('Mod');
$m2=\MS\Core\Helper\MSTableSchema::getTableDataForField('Mod');
$m3=\MS\Core\Helper\MSTableSchema::getTableDataForAction('Mod');
$m4=\MS\Core\Helper\MSTableSchema::getTableDataForMSForms('Mod');
$m5=\MS\Core\Helper\MSTableSchema::getTableDataForMSViews('Mod');
$m6=\MS\Core\Helper\MSTableSchema::getTableDataForMSLogin('Mod');
$mf=array_merge($m1,$m2,$m3,$m4,$m5,$m6);
