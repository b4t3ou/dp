<?php namespace Calculator;

class Calculator
{
    private $_error = false;
    private $_data;
    private $_availableOperators = ['+', '-', '*', '/'];

    public function calculate($string)
    {
        $this->_error = false;
        $this->_data  = explode(' ', $string);
        $this->_checkString()->_checkDataStructure();
    }

    public function hasError()
    {
        return $this->_error;
    }

    private function _checkString()
    {
        if (count($this->_data) < 3)
        {
            $this->_error = true;
        }

        return $this;
    }

    private function _checkDataStructure()
    {
        if ($this->_error)
        {
            return false;
        }

        foreach ($this->_data as $index => $value)
        {
            if (($index % 2 == 0 && !preg_match('/^[0-9]+$/', $value))
                || ($index % 2 == 1 && !in_array($value, $this->_availableOperators))
            )
            {
                $this->_error = true;
            }
        }
    }

}