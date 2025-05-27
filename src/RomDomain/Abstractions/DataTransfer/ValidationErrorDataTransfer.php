<?php
namespace RomDomain\Abstractions\DataTransfer;

class ValidationErrorDataTransfer
{
    public string $field;
    public string $message;

    public function __construct(string $field, string $message)
    {
        $this->field = $field;
        $this->message = $message;
    }
}
