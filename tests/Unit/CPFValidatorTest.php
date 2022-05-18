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
}