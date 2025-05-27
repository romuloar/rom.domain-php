<?php
namespace RomDomain;

use RomDomain\Base\RomBaseDomain;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validation;
use RomDomain\Validation\ValidationDomain;

class UserDomain extends RomBaseDomain
{
    #[Assert\NotBlank(message: 'The Name field is required.')]
    public string $name = '';

    #[Assert\Range(min: 18, max: 120, notInRangeMessage: 'The field Age must be between 18 and 120.')]
    public int $age = 0;

    #[Assert\Email(message: 'The Email field is not a valid e-mail address.')]
    public string $email = '';

    #[Assert\Length(min: 6, max: 12, minMessage: 'The field Username must be a string with a minimum length of 6 and maximum of 12.', maxMessage: 'The field Username must be a string with a minimum length of 6 and maximum of 12.')]
    public string $username = '';

    #[Assert\Regex(pattern: '/^\\+?[0-9\-\s]{7,}$/', message: 'The PhoneNumber field is not a valid phone number.')]
    public string $phoneNumber = '';

    #[Assert\Url(message: 'The Website field is not a valid URL.')]
    public string $website = '';

    public string $password = '';
    public string $confirmPassword = '';

    protected function validate(): void
    {
        $this->validationErrors = [];
        $validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
        $violations = $validator->validate($this);
        $this->validationErrors = \RomDomain\Validation\ValidationDomain::fromSymfonyViolations($violations);
        // Custom validation
        if ($this->password !== $this->confirmPassword) {
            $this->addValidationError('', "'ConfirmPassword' and 'Password' do not match.");
        }
    }
}
