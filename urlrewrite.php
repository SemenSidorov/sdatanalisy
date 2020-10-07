<?php
$arUrlRewrite=array (
  0 => 
  array (
    'CONDITION' => '#^\\/?\\/mobileapp/jn\\/(.*)\\/.*#',
    'RULE' => 'componentName=$1',
    'ID' => NULL,
    'PATH' => '/bitrix/services/mobileapp/jn.php',
    'SORT' => 100,
  ),
  5 => 
  array (
    'CONDITION' => '#^/analyzes/#',
    'RULE' => '',
    'ID' => 'ddp:catalog',
    'PATH' => '/analyzes/index.php',
    'SORT' => 100,
  ),
  7 => 
  array (
    'CONDITION' => '#^/services/#',
    'RULE' => '',
    'ID' => 'ddp:catalog.services',
    'PATH' => '/services/index.php',
    'SORT' => 100,
  ),
  11 => 
  array (
    'CONDITION' => '#^/articles/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/articles/index.php',
    'SORT' => 100,
  ),
  8 => 
  array (
    'CONDITION' => '#^/clinics/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/clinics/index.php',
    'SORT' => 100,
  ),
  10 => 
  array (
    'CONDITION' => '#^/doctors/#',
    'RULE' => '',
    'ID' => 'ddp:catalog',
    'PATH' => '/doctors/index.php',
    'SORT' => 100,
  ),
  1 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 100,
  ),
);
