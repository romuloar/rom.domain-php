<?php
namespace RomDomain\Abstractions\Validation;

interface IRomValidatableDomain
{
    public function isValidDomain(): bool;
    public function getValidationErrors(): array;
}
