<?php
namespace RomDomain\Base;

use RomDomain\Abstractions\Validation\IRomValidatableDomain;
use RomDomain\Abstractions\DataTransfer\ValidationErrorDataTransfer;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

// This file is part of the RomDomain package.
// It provides a base class for domain objects that need validation.
abstract class RomBaseDomain implements IRomValidatableDomain
{
    /** @var ValidationErrorDataTransfer[] */
    protected array $validationErrors = [];

    // Constructor initializes validation
    public function __construct()
    {
        $this->validate();
    }

    /**
     * Check if the domain is valid.
     * 
     * @return bool True if valid, false otherwise.
     */
    public function isValidDomain(): bool
    {
        $this->validate();
        return empty($this->validationErrors);
    }

    /**
     * @return ValidationErrorDataTransfer[]
     */
    public function getValidationErrors(): array
    {
        $this->validate();
        return $this->validationErrors;
    }

    /**
     * Add a validation error.
     *
     * @param string $field The field that caused the error.
     * @param string $message The error message.
     */
    protected function addValidationError(string $field, string $message): void
    {
        $this->validationErrors[] = new ValidationErrorDataTransfer($field, $message);
    }

    // Override this in child classes for custom validation    
    protected function validate(): void
    {
        $this->validationErrors = [];
        // Use Symfony Validator to validate the domain
        $validator = Validation::createValidatorBuilder()->enableAttributeMapping()->getValidator();
        $violations = $validator->validate($this);
        $this->validationErrors = \RomDomain\Validation\ValidationDomain::fromSymfonyViolations($violations);
        // Custom validation logic can be added here
        if (method_exists($this, 'customValidation')) {
            $this->customValidation();
        }        
    }
}
