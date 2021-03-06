<?php

class Plugin_Pdf_CommandTest extends PHPUnit_Framework_TestCase {

    public function testDefaultWidthDefined() {
        $this->assertEquals(
            800,
            self::command()->width()
        );
    }

    public function testCommandStringContainsTheWidth() {
        $this->assertEquals(
            150,
            self::command('150')->width()
        );
    }

    public function testWidthIsLimitedWithMinimalValue() {
        $this->assertEquals(
            10,
            self::command('0')->width()
        );
    }

    public function testWidthIsLimitedWithMaximalValue() {
        $this->assertEquals(
            2000,
            self::command('500000')->width()
        );
    }

    public function testAmbiguityTest() {
        $this->assertFalse(self::command('200sda')->conforms('200'));
    }

//--------------------------------------------------------------------------------------------------

    private static function command($commandString = null) {
        $command = new Plugin_Pdf_Command();
        return $command->configure($commandString);
    }
}
