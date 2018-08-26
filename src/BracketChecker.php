<?php

namespace Otus;

class BracketChecker
{
    public static $allowedChars = ['(', ')', ' ', '\n', '\s', '\r', '\t'];

    public function __construct()
    {
    }

    public function parseString($input)
    {
        $input = trim($input);
        if (empty($input)) {
            throw new \InvalidArgumentException('The string is empty.');
        }

        if (!preg_match('/[\(\)\s\n\r\t ]/', $input)) {
            throw new \InvalidArgumentException('The string contains not allowed characters. Please, use only \'(\', \')\', \' \', \'\n\', \'\s\', \'\r\' and \'\t\'');
        }

        $input = str_split(preg_replace('/[\s\n\r\t ]/', '', $input));

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

            $sequence += ($char === '(') ? 1 : -1;
            if ($sequence < 0) {
                throw new \InvalidArgumentException('Your sequence is wrong.');
            }
        }

        $result = ($sequence === 0 && $result) ? 'All good' : false;

        return $result;

    }

}