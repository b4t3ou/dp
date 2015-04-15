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

    public function testNothing()
    {

    }

}