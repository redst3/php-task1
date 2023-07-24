<?php

declare(strict_types=1);

namespace Task1\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Task1\CommissionTask\Service\Commission;
use Task1\CommissionTask\Entity\Client;


class CommissionTest extends TestCase{
    public function testCalculateCommissionResults(){
        $expectedResults = [
            0.60,
            3.00,
            0.00,
            0.06,
            1.50,
            0,
            0.69,
            0.30,
            0.30,
            3.00,
            0.00,
            0.00,
            8611,
        ];
        $file = dirname(__DIR__) . '\Data\test_input.csv';
        if(file_exists($file)){
            $this->assertEquals(1, 1);
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
            $results = $commission->getOutput($clientOperations);
            $this->assertEquals($expectedResults, $results);
        } else {
            $this->assertFileExists($file, 'File does not exist.');
        }
    }
}