<?php
include(__DIR__ . '/../vendor/autoload.php');
use PHPUnit\Framework\TestCase;

class SprintfTest extends TestCase
{
    public function testPassthrough() {
        $result = \sergiosgc\sprintf('One: %d, %s: 2, %s: %d', 1, 'two', 'three', 3);
        $this->assertEquals($result, 'One: 1, two: 2, three: 3');
    }
    public function testNamedAndUnnamed() {
        $result = \sergiosgc\sprintf('One: %d, %<text_two>s: 2, %s: %d', 1, 'three', 3, ['text_two' => 'two']);
        $this->assertEquals($result, 'One: 1, two: 2, three: 3');
    }
    public function testOnlyNamed() {
        $result = \sergiosgc\sprintf('One: %<1>d, %<text_two>s: 2, %<text_three>s: %<3>d', 1, 'three', 3, ['text_two' => 'two', 'text_three' => 'three', 1 => '1', '3' => '3']);
        $this->assertEquals($result, 'One: 1, two: 2, three: 3');
    }
}
