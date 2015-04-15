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
   /* public function testTheStringMinimalLength($string)
    {
        $this->_calculator->calculate($string);
        $this->assertTrue($this->_calculator->hasError());
    }*/

    /**
     * @dataProvider stringValidationDataProvider
     */
    /*public function testDataArrayIsValidation($expected, $string)
    {
        $this->_calculator->calculate($string);
        $this->assertSame($expected, $this->_calculator->hasError());
    }*/

    /**
     * @dataProvider stringDataProvider
     */
    public function testCalculate($expected, $string)
    {
        $this->_calculator->calculate($string);
        $this->assertSame($expected, $this->_calculator->getResult());
    }



    public function shortStringDataProvider()
    {
        return [ [''], ['1'], ['+1'], ['+1+'], ['+1 +'], ['1 +1']];
    }

    public function stringValidationDataProvider()
    {
        return [
            [false, '1 + 1'],
            [false, '1 + 1 + 6 * 2'],
            [true, '1 + 1+6 * 2'],
            [true, '1+1+6*4'],
            [false, '1 + 13'],
        ];
    }

    public function stringDataProvider()
    {
        return [
            [4, '2 * 2'],
            [1, '2 / 2'],
            [5, '2 / 2 * 5'],
            [2, '1 + 1'],
            [14, '1 + 1 + 6 * 2'],
            [7, '1 + 12 / 2'],
            [13, '1 + 12 / 2 * 2'],
            [7, '2 * 2 + 3']
        ];
    }



}