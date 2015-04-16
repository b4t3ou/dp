<?php namespace Calculator;

class Calculator
{
    private $_error = false;
    private $_data;
    private $_availableOperators = ['+', '-', '*', '/'];

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
        if ($data[$key] == '*' || $data[$key] == '/')
        {
            switch ($data[$key])
            {
                case '*':
                    $data[$key - 1] = $data[$key - 1] * $data[$key + 1];
                    break;
                case '/':
                    $data[$key - 1] = $data[$key - 1] / $data[$key + 1];
                    break;
            }

            $data = $this->_rearrangeDataSet($data, $key);
        }
        else
        {
            $key += 2;
        }

        if ($key < count($data) && count($data) >= 3)
        {
            $data = $this->_recursiveHigherResolver($key, $data);
        }

        return $data;
    }

    private function _recursiveLowerResolver($key, $data)
    {
        if (count($data) < 3)
        {
            return $data;
        }

        if (($data[$key] == '+' || $data[$key] == '-'))
        {
            switch ($data[$key])
            {
                case '+':
                    $data[$key - 1] = $data[$key - 1] + $data[$key + 1];
                    break;
                case '-':
                    $data[$key - 1] = $data[$key - 1] - $data[$key + 1];
                    break;
            }

            $data = $this->_rearrangeDataSet($data, $key);
        }

        if ($key < count($data) && count($data) >= 3)
        {
            $data = $this->_recursiveLowerResolver($key, $data);
        }

        return $data;
    }

    private function _rearrangeDataSet($rawData, $i)
    {
        $data = [];
        unset($rawData[$i]);
        unset($rawData[$i + 1]);

        foreach ($rawData as $d)
        {
            $data[] = $d;
        }

        return $data;
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