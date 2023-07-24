<?php

declare(strict_types=1);

namespace Task1\CommissionTask\Tests\Service;

use PHPUnit\Framework\TestCase;
use Task1\CommissionTask\Service\Converter;

class ConverterTest extends TestCase{
    public function testConvertToEuro(){
        $converter = new Converter(1, 2, 3);
        $this->assertEquals(
            1, $converter->convertToEuros(3, 'JPY')
        );
    }
    public function testConvertFromEuro(){
        $converter = new Converter(1, 2, 3);
        $this->assertEquals(
            2, $converter->convertFromEuros(1, 'USD')
        );
    }
}