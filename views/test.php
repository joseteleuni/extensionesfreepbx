<?php

// Load FreePBX bootstrap environment
require_once('/etc/freepbx.conf');

// Load AMI
global $astman;

$status = [];

$test = get_class_methods($astman); 
echo var_dump($test);
$ends = [];
$endpoints = $astman->PJSIPShowEndpoints();
//ObjectName
foreach ($endpoints as $endpoint){
    $ends[] = $endpoint["ObjectName"];

}

//echo $astman->PJSIPShowRegistrationInboundContactStatuses()[0]["Status"];
$regStatuses = $astman->PJSIPShowRegistrationInboundContactStatuses();

echo var_dump($endpoints);

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

foreach ($ends as $ext) {
    $estado = isset($regs[$ext]) ? $regs[$ext] : "Inalcanzable";
    $status[] = ["Extension" => $ext, "Status" => $estado];
}	


echo var_dump($regStatuses);
//echo var_dump($status);

echo "<table border='1'>";
echo "<tr><th>Item</th><th>Extensión</th><th>Estado</th></tr>";

$contador = 1; // Para enumerar las filas

foreach ($status as $entry) {
    echo "<tr>";
    echo "<td>" . $contador . "</td>"; // Número de fila
    echo "<td>" . $entry["Extension"] . "</td>"; // Extensión
    echo "<td>" . $entry["Status"] . "</td>"; // Estado
    echo "</tr>";
    $contador++;
}

echo "</table>";



?>

	
