<?php

declare(strict_types=1);

use BarCode\Code;
use BarCode\Exception\ReadOnlyException;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    public function testLengthCode_Give7CharacterCode_ReturnCorrectLength(): void
    {
        $code = new Code('1234567');

        $this->assertEquals(7, $code->length());
    }

    public function testIsNumericCode_GiveNumericString_ReturnTrue(): void
    {
        $code = new Code('1234567');

        $this->assertTrue($code->isNumeric());
    }

    public function testIsNumericCode_GiveNonNumericString_ReturnFalse(): void
    {
        $code = new Code('12E4567');

        $this->assertFalse($code->isNumeric());
    }

    public function testCode_GetCodeCharacter_ReturnCharacter(): void
    {
        $code = new Code('1234567');

        $this->assertEquals('1', $code[0]);
    }

    public function testCode_UnsetCodeCharacter_ThrowException(): void
    {
        $this->expectException(ReadOnlyException::class);

        $code = new Code('1234567');
        unset($code[0]);
    }

    public function testCode_OverrideCodeCharacter_ThrowException(): void
    {
        $this->expectException(ReadOnlyException::class);

        $code = new Code('1234567');
        $code[0] = '1';
    }
}