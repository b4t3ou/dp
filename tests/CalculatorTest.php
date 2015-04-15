<?php

use Calculator\Calculator;

class CalculatorTest extends PHPUnit_Framework_TestCase
{
    protected $_calculator;

    public function setUp()
    {
        parent::setUp();

        $this->_calculator = new Calculator();
    }

    /**
     * @dataProvider shortStringDataProvider
     */
    public function testTheStringMinimalLength($string)
    {
        $this->_calculator->calculate($string);
        $this->assertTrue($this->_calculator->hasError());
    }

    /**
     * @dataProvider stringDataProvider
     */
    public function testDataArrayIsValidation($expected, $string)
    {
        $this->_calculator->calculate($string);
        $this->assertSame($expected, $this->_calculator->hasError());
    }

    public function shortStringDataProvider()
    {
        return [ [''], ['1'], ['+1'], ['+1+'], ['+1 +'], ['1 +1']];
    }

    public function stringDataProvider()
    {
        return [
            [false, '1 + 1'],
            [false, '1 + 1 + 6 * 2'],
            [true, '1 + 1+6 * 2'],
            [true, '1+1+6*4'],
            [false, '1 + 13'],
        ];
    }

}