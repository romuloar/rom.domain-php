<?php
namespace RomDomain\Test\Base;

use PHPUnit\Framework\TestCase;
use RomDomain\UserDomain;

class RomBaseDomainTest extends TestCase
{
    public function testInvalidUserDomainReturnsValidationErrors()
    {
        $user = new UserDomain();
        $user->name = '';
        $user->age = 15;
        $user->email = 'not-an-email';
        $user->username = 'usr';
        $user->phoneNumber = 'abc';
        $user->website = 'not-a-url';
        $user->password = '123456';
        $user->confirmPassword = '654321';

        $this->assertFalse($user->isValidDomain());
        $errors = $user->getValidationErrors();
        $this->assertNotEmpty($errors);
        $fields = array_map(fn($e) => $e->field, $errors);
        $this->assertContains('name', $fields);
        $this->assertContains('age', $fields);
        $this->assertContains('email', $fields);
        $this->assertContains('username', $fields);
        $this->assertContains('phoneNumber', $fields);
        $this->assertContains('website', $fields);
        $this->assertContains('', $fields); // senha
    }

    public function testValidUserDomainReturnsNoErrors()
    {
        $user = new UserDomain();
        $user->name = 'Romulo';
        $user->age = 30;
        $user->email = 'romulo@email.com';
        $user->username = 'romuloar';
        $user->phoneNumber = '+5511999999999';
        $user->website = 'https://romuloar.com';
        $user->password = '123456';
        $user->confirmPassword = '123456';

        $this->assertTrue($user->isValidDomain());
        $this->assertEmpty($user->getValidationErrors());
    }
}
