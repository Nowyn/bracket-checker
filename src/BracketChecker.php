<?php

namespace Otus;

class BracketChecker
{
    private $input;
    public static $allowedChars = ['(', ')', ' ', '\n', '\s', '\r', '\t'];

    public function __construct($input)
    {
        $this->input = $input;
    }

    public function parseString($input)
    {
        $input = trim($input);
        if (empty($input)) {
            throw new \InvalidArgumentException('The string is empty.');
        }

        $input = str_split($input);

        if ($input[0] !== '(') {
            throw new \InvalidArgumentException('The string doesn\'t start with an opening bracket.');
        }

        if (array_slice($input, -1)[0] !== ')') {
            throw new \InvalidArgumentException('The string doesn\'t end with a closing bracket.');
        }

        $op = count(array_keys($input, '('));
        $cl = count(array_keys($input, ')'));
        if ($op !== $cl) {
            throw new \InvalidArgumentException('The string contains ' . $op . ' opening brackets and ' . $cl . ' closing brackets.');
        }

        $result = true;
        $sequence = 0;

        foreach ($input as $char) {

            if (!in_array($char, self::$allowedChars)) {
                throw new \InvalidArgumentException('The string contains not allowed characters. Please, use only \'(\', \')\', \' \', \'\n\', \'\s\', \'\r\' and \'\t\'');
            }
            $sequence += ($char === '(') ? 1 : -1;
            if ($sequence < 0) {
                throw new \InvalidArgumentException('Your sequence is wrong.');
            }
        }
        $result = ($sequence == 0 && $result) ? true : false;

        return $result;

    }

}