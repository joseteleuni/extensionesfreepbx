<?php
require_once('/etc/freepbx.conf');
global $astman;

//$response = $astman->send_request('Command', array('Command' => 'core show version'));

$response = $astman->PJSIPShowEndpoint("214")[1]["Username"];
//$reg = $astman->PJSIPShowRegistrations();

$regStatuses = $astman->PJSIPShowRegistrationInboundContactStatuses();

// Recorres cada elemento del array
foreach ($regStatuses as $contact) {
    // Imprimes el valor de "Status"
    echo $contact["Status"] . "<br>";
}

?>

<h1><?php echo $title; ?></h1>
<p>En el cuadro se ven los estados de los anexos.</p>


