<?php

// Load FreePBX bootstrap environment
require_once('/etc/freepbx.conf');

// Load AMI
global $astman;

$status = [];

$test = get_class_methods($astman); 
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

foreach ($ends as $ext) {
    $estado = isset($regs[$ext]) ? $regs[$ext] : "Inalcanzable";
    $status[] = ["Extension" => $ext, "Status" => $estado];
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
echo "<tr><th style='width: 10%;'>Item</th><th style='width: 40%;'>Extensión</th><th style='width: 50%;'>Estado</th></tr>";

$contador = 1;

foreach ($status as $entry) {
    echo "<tr>";
    echo "<td>" . $contador . "</td>";
    echo "<td>" . $entry["Extension"] . "</td>";
    echo "<td>" . $entry["Status"] . "</td>";
    echo "</tr>";
    $contador++;
}

echo "</table>";



?>

	
