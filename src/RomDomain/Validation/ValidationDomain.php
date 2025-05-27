<?php
namespace RomDomain\Validation;

use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use RomDomain\Abstractions\DataTransfer\ValidationErrorDataTransfer;

class ValidationDomain
{
    /**
     * @param ConstraintViolationListInterface $violations
     * @return ValidationErrorDataTransfer[]
     */
    public static function fromSymfonyViolations(ConstraintViolationListInterface $violations): array
    {
        $errors = [];
        /** @var ConstraintViolationInterface $violation */
        foreach ($violations as $violation) {
            $errors[] = new ValidationErrorDataTransfer(
                $violation->getPropertyPath(),
                $violation->getMessage()
            );
        }
        return $errors;
    }
}
