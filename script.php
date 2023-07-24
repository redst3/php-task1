<?php
require('vendor/autoload.php');
use Task1\CommissionTask\Entity\Client;
use Task1\CommissionTask\Service\Commission;

if(isset($argv[1])){
    $file = $argv[1];
}else{
    $file = 'src\Data\input.csv';
}

if(file_exists($file)){
    $handle = fopen($file, 'r');
    $contents = fread($handle, filesize($file));
    fclose($handle);

    $clientOperations = [];
    $lines = explode("\n", $contents);
    foreach($lines as $line) {
        $clientData = explode (',', $line);
        $clientId = (int) $clientData[1];
        $client = new Client(
            $clientData[0],
            $clientId,
            $clientData[2],
            $clientData[3],
            (float) $clientData[4],
            trim(strtoupper($clientData[5])),
        );
        $clientOperations[] = $client;
    }
    $commission = new Commission($clientOperations);
    $commission->calculateCommission();
    $commission->getOutput($clientOperations);



}else {
    echo 'File does not exist.';
}