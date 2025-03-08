<?php

// Load FreePBX bootstrap environment
require_once('/etc/freepbx.conf');

// Load AMI
global $astman;

//DB 
global $db;

$extens = [];

$sql_0 = "SELECT * FROM users"; //Muestra las extensiones
$users = $db->getAll($sql_0, DB_FETCHMODE_ASSOC);

//echo var_dump($users);

foreach($users as $user){
    $extens[$user['extension']]=$user['name'];
}

//echo $extens["217"];
//echo var_dump(array_keys($extens));
//echo var_dump(array_values($extens));
//$columna_extens = array_column($extens, "extension");

$status = [];

$class_astman = get_class_methods($astman);
$class_db = get_class_methods($db);

//echo var_dump($class_db);
//echo var_dump($test);
$ends = [];
$endpoints = $astman->PJSIPShowEndpoints();

foreach ($endpoints as $endpoint){
    if ($endpoint["ObjectName"] !== "080000605" && $endpoint["ObjectName"] !== "dpma_endpoint") {
        $ends[] = $endpoint["ObjectName"];
    }
}

//echo $astman->PJSIPShowRegistrationInboundContactStatuses()[0]["Status"];
$regStatuses = $astman->PJSIPShowRegistrationInboundContactStatuses();

//echo var_dump($endpoints);

$regs = [];
// Recorres cada elemento del array
foreach ($regStatuses as $contact) {
    $regs[$contact["EndpointName"]] = $contact["Status"];
}

//foreach ($regs as $reg) {
//    echo $reg[0]."\n";
//    echo $reg[1]."\n";
//}

//echo var_dump($endp);
//foreach ($ends as $end){
//    echo $end."\n";
//}

foreach (array_keys($extens) as $ext) {
    $estado = isset($regs[$ext]) ? "CONECTADO" : "DESCONECTADO";
    $status[] = ["Extension" => $ext , "Nombre" => $extens[$ext],"Status" => $estado];
}	


//echo var_dump($regStatuses);
//echo var_dump($status);

echo "<style>
    table {
        width: 80%;
        border-collapse: collapse;
        margin: 20px auto;
    }
    th, td {
        border: 1px solid black;
        padding: 15px; /* Aumenta el espacio dentro de las celdas */
        text-align: center;
    }
    th {
        background-color: #f2f2f2;
    }
    tr {
        height: 40px; /* Aumenta el espacio entre filas */
    }
</style>";

echo "<h1>Estado de las extensiones</h1> <br>";
echo "<table>";
echo "<tr><th style='width: 10%;'>Item</th>
      <th style='width: 30%;'>Extensión</th>
      <th style='width: 30%;'>Nombre</th>
      <th style='width: 30%;'>Estado</th></tr>";

$contador = 1;

foreach ($status as $entry) {
    echo "<tr>";
    echo "<td>" . $contador . "</td>";
    echo "<td>" . $entry["Extension"] . "</td>";
    echo "<td>" . $entry["Nombre"] . "</td>";
    echo "<td>" . $entry["Status"] . "</td>";
    echo "</tr>";
    $contador++;
}

echo "</table>";



?>

	
