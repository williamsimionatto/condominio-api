<?php

namespace Tests\Unit;

use App\Helpers\CNPJValidator;
use PHPUnit\Framework\TestCase;

class CNPJValidatorTest extends TestCase {
    private function getValidatorStub() {
        return $this->getMockBuilder(CNPJValidator::class)
                    ->disableOriginalConstructor()
                    ->disableOriginalClone()
                    ->disableArgumentCloning()
                    ->disallowMockingUnknownTypes()
                    ->getMock();
    }

    public function testIsInvalidcnpj() {
        $stub = $this->getValidatorStub();
        $stub->method('isValid') ->willReturn(false);
        $this->assertEquals(false, $stub->isValid('12345678901234'));
    }
}
