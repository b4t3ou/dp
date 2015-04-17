<?php namespace Calculator;

class Calculator
{
    private $_error = false;
    private $_data;
    private $_availableOperators = ['+', '-', '*', '/'];
    private $_higherOperands = ['*', '/'];

    public function __construct($string)
    {
        $this->_data  = explode(' ', $string);
    }

    public function calculate()
    {
        $data = $this->_recursiveLowerResolver(1, $this->_recursiveHigherResolver(1, $this->_data));

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

    private function _recursiveHigherResolver($key, $data)
    {
        if ($key >= count($data) || count($data) < 3)
        {
            return $data;
        }

        if (!in_array($data[$key], $this->_higherOperands))
        {
            return $this->_recursiveHigherResolver($key += 2, $data);
        }

        switch ($data[$key])
        {
            case '*':
                $data[$key - 1] = $data[$key - 1] * $data[$key + 1];
                break;
            case '/':
                $data[$key - 1] = $data[$key - 1] / $data[$key + 1];
                break;
        }

        return $this->_recursiveHigherResolver($key, $this->_rearrangeDataSet($data, $key));
    }

    private function _recursiveLowerResolver($key, $data)
    {
        if (count($data) < 3 || $key > count($data))
        {
            return $data;
        }

        switch ($data[$key])
        {
            case '+':
                $data[$key - 1] = $data[$key - 1] + $data[$key + 1];
                break;
            case '-':
                $data[$key - 1] = $data[$key - 1] - $data[$key + 1];
                break;
        }

        return $this->_recursiveLowerResolver($key, $this->_rearrangeDataSet($data, $key));
    }

    private function _rearrangeDataSet($rawData, $i)
    {
        unset($rawData[$i]);
        unset($rawData[$i + 1]);

        return array_values($rawData);
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