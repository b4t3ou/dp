<?php namespace Calculator;

class Calculator
{
    private $_error = false;
    private $_data;
    private $_availableOperators = ['+', '-', '*', '/'];
    private $_result;

    public function calculate($string)
    {
        $this->_error = false;
        $this->_data  = explode(' ', $string);
        $this->_checkString()
            ->_checkDataStructure()
            ->run();
    }

    public function hasError()
    {
        return $this->_error;
    }

    public function getResult()
    {
        return $this->_result;
    }

    private function run()
    {
        if ($this->_error)
        {
            return false;
        }

        $this->_recursiveHigherResolver($this->_data);
        $this->_recursiveLowerResolver($this->_data);
    }

    private function _recursiveHigherResolver($data)
    {
        if (count($data) == 1)
        {
            $this->_result = $data[0];
            return;
        }

        for ($i = 1; $i < count($data); $i += 2)
        {
            if ($data[$i] == '*' || $data[$i] == '/')
            {
                if ($data[$i] == '*')
                {
                    $data[$i - 1] = $data[$i - 1] * $data[$i + 1];

                }
                else if ($data[$i] == '/')
                {
                    $data[$i - 1] = $data[$i - 1] / $data[$i + 1];
                }

                unset($data[$i]);
                unset($data[$i + 1]);

                $this->_data = [];
                foreach ($data as $d)
                {
                    $this->_data[] = $d;
                }

                $this->_recursiveHigherResolver($this->_data);
            }
        }
    }

    private function _recursiveLowerResolver($data)
    {
        if (count($data) == 1)
        {
            $this->_result = $data[0];
            return;
        }

        for ($i = 1; $i < count($data); $i += 2)
        {
            if ($data[$i] == '+' || $data[$i] == '-')
            {
                if ($data[$i] == '+')
                {
                    $data[$i - 1] = $data[$i - 1] + $data[$i + 1];

                }
                else if ($data[$i] == '-')
                {
                    $data[$i - 1] = $data[$i - 1] - $data[$i + 1];
                }

                unset($data[$i]);
                unset($data[$i + 1]);

                $this->_data = [];

                foreach ($data as $d)
                {
                    $this->_data[] = $d;
                }

                $this->_recursiveLowerResolver($this->_data);
            }
        }
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