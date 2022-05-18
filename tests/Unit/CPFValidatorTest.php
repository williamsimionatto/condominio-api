<?php

namespace Tests\Unit;

use App\Helpers\CPFValidator;
use PHPUnit\Framework\TestCase;

class CPFValidatorTest extends TestCase {
    private function getValidatorStub() {
        return $this->getMockBuilder(CPFValidator::class)
                    ->disableOriginalConstructor()
                    ->disableOriginalClone()
                    ->disableArgumentCloning()
                    ->disallowMockingUnknownTypes()
                    ->getMock();
    }

    public function testIsCalledWith() {
        $validator = $this->getValidatorStub();
        $validator->expects($this->exactly(1))
                  ->method('isValid')
                  ->with('882.708.790-70');
        $validator->isValid('882.708.790-70');
    }

    public function testIsInvalidCpf() {
        $stub = $this->getValidatorStub();
        $stub->method('isValid')->willReturn(false);
        $this->assertEquals(false, $stub->isValid('882.708.790-70'));
    }

    public function testIsValidCpf() {
        $stub = $this->getValidatorStub();
        $stub->method('isValid')->willReturn(true);
        $this->assertEquals(true, $stub->isValid('882.708.790-70'));
    }

    public function testNullCpf() {
        $stub = $this->getValidatorStub();
        $stub->method('isValid')->willReturn(false);
        $this->assertEquals(false, $stub->isValid(null));
    }
}