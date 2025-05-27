<?php
namespace RomDomain\Test\Validation;

use PHPUnit\Framework\TestCase;
use RomDomain\UserDomain;

class ValidationDomainTest extends TestCase
{
    public function testPasswordConfirmationValidation()
    {
        $user = new UserDomain();
        $user->name = 'Romulo';
        $user->age = 30;
        $user->email = 'romulo@email.com';
        $user->username = 'romuloar';
        $user->phoneNumber = '+5511999999999';
        $user->website = 'https://romuloar.com';
        $user->password = '123456';
        $user->confirmPassword = '654321';

        $this->assertFalse($user->isValidDomain());
        $errors = $user->getValidationErrors();
        $fields = array_map(fn($e) => $e->field, $errors);
        $this->assertContains('', $fields); // campo vazio para erro de senha
    }

    public function testNoPasswordConfirmationErrorWhenPasswordsMatch()
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
        $fields = array_map(fn($e) => $e->field, $user->getValidationErrors());
        $this->assertNotContains('', $fields);
    }

    public function testValidOptionalFields()
    {
        $user = new UserDomain();
        $user->name = 'Romulo';
        $user->age = 25;
        $user->email = 'romulo@email.com';
        $user->username = 'romuloar';
        $user->phoneNumber = '';
        $user->website = '';
        $user->password = '123456';
        $user->confirmPassword = '123456';
        $this->assertTrue($user->isValidDomain());
    }

    public function testInvalidEmailAndUrl()
    {
        $user = new UserDomain();
        $user->name = 'Romulo';
        $user->age = 25;
        $user->email = 'not-an-email';
        $user->username = 'romuloar';
        $user->phoneNumber = '+5511999999999';
        $user->website = 'not-a-url';
        $user->password = '123456';
        $user->confirmPassword = '123456';
        $this->assertFalse($user->isValidDomain());
        $fields = array_map(fn($e) => $e->field, $user->getValidationErrors());
        $this->assertContains('email', $fields);
        $this->assertContains('website', $fields);
    }

    public function testUsernameLengthBoundaries()
    {
        $user = new UserDomain();
        $user->name = 'Romulo';
        $user->age = 25;
        $user->email = 'romulo@email.com';
        $user->username = 'rom'; // too short
        $user->phoneNumber = '+5511999999999';
        $user->website = 'https://romuloar.com';
        $user->password = '123456';
        $user->confirmPassword = '123456';
        $this->assertFalse($user->isValidDomain());
        $fields = array_map(fn($e) => $e->field, $user->getValidationErrors());
        $this->assertContains('username', $fields);

        $user->username = 'romuloar12345'; // too long
        $this->assertFalse($user->isValidDomain());
        $fields = array_map(fn($e) => $e->field, $user->getValidationErrors());
        $this->assertContains('username', $fields);

        $user->username = 'romuloar'; // valid
        $this->assertTrue($user->isValidDomain());
    }

    public function testPhoneNumberValidation()
    {
        $user = new UserDomain();
        $user->name = 'Romulo';
        $user->age = 25;
        $user->email = 'romulo@email.com';
        $user->username = 'romuloar';
        $user->phoneNumber = 'abc'; // invalid
        $user->website = 'https://romuloar.com';
        $user->password = '123456';
        $user->confirmPassword = '123456';
        $this->assertFalse($user->isValidDomain());
        $fields = array_map(fn($e) => $e->field, $user->getValidationErrors());
        $this->assertContains('phoneNumber', $fields);

        $user->phoneNumber = '+5511999999999'; // valid
        $this->assertTrue($user->isValidDomain());
    }

    public function testMultipleErrors()
    {
        $user = new UserDomain();
        $user->name = '';
        $user->age = 10;
        $user->email = 'bad';
        $user->username = 'a';
        $user->phoneNumber = 'x';
        $user->website = 'bad';
        $user->password = '1';
        $user->confirmPassword = '2';
        $this->assertFalse($user->isValidDomain());
        $errors = $user->getValidationErrors();
        $this->assertGreaterThanOrEqual(6, count($errors));
    }
}
