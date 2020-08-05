<?php

require './vendor/autoload.php';

use Webmozart\Assert\Assert;

// class Employee
// {
//     public function __construct($id)
//     {
//         Assert::integer($id, 'The employee ID must be an integer. Got: %s');
//         Assert::greaterThan($id, 0, 'The employee ID must be a positive integer. Got: %s');
//     }
// }

try {
    // Assert::string(123, 'The path is expected to be a string. Got: %s');
    Assert::keyExists(['1' => 123,  '2' => 456], 1, 'The key not exists. Got: %s');
    Assert::numeric('123.3', 'The value is not numeric. Got: %s');
    Assert::true(true, 'That the expected value is true.');
} catch (InvalidArgumentException $th) {
   var_dump($th->getMessage());
}
