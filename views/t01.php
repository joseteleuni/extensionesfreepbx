<?php

// Load FreePBX bootstrap environment
require_once('/etc/freepbx.conf');

// Load AMI
global $astman;

//DB 
global $db;

//Mostrar las clases
$test = get_class_methods($db);

echo var_dump($test);

//echo var_dump($db->getAll(1));

// Define una clave única para tu módulo (ej: 'my_module_config')
//$key = 'my_module_config';
//$data = ['setting1' => 'value1', 'setting2' => 'value2'];

$sql_0 = "SHOW TABLES";
$sql_1 = "SELECT * FROM users"; //Muestra las extensiones

$results_0 = $db->getAll($sql_0, DB_FETCHMODE_ASSOC);
$results_1 = $db->getAll($sql_1, DB_FETCHMODE_ASSOC);



echo var_dump($results_0);
echo var_dump($results_1);
// Guarda los datos y obtén el ID único
//echo var_dump($db->getID($key, $data));

