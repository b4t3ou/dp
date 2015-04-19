<?php namespace Calculator;

class Calculator
{
    private $_error = false;
    private $_data;
    private $_availableOperators = ['+', '-', '*', '/'];
    private $_higherOperators = ['*', '/'];

    public function __construct($string)
    {
        $this->_data  = explode(' ', $string);
    }

    public function calculate()
    {
        $data = $this->_resolver(1, $this->_resolver(1, $this->_data, true));

        return $data[0];
    }

    public function checkSource()
    {
        $this->_checkString()->_checkDataStructure();
    }

    public function hasError()
    {
        return $this->_error;
    }

    private function _resolver($key, $data, $higher = false)
    {
        if ($key >= count($data) || count($data) < 3)
        {
            return $data;
        }

        if ($higher && !in_array($data[$key], $this->_higherOperators))
        {
            $key += 2;
            return $this->_resolver($key, $data, $higher);
        }

        return $this->_resolver($key, $this->_operation($data, $key), $higher);
    }

    private function _operation($data, $key)
    {
        switch ($data[$key])
        {
            case '*':
                $data[$key - 1] = $data[$key - 1] * $data[$key + 1];
                break;
            case '/':
                $data[$key - 1] = $data[$key - 1] / $data[$key + 1];
                break;
            case '+':
                $data[$key - 1] = $data[$key - 1] + $data[$key + 1];
                break;
            case '-':
                $data[$key - 1] = $data[$key - 1] - $data[$key + 1];
                break;
        }

        unset($data[$key]);
        unset($data[$key + 1]);

        return array_values($data);
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
            return $this;
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

        return $this;
    }

}