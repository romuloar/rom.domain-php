# 🧠 RomBaseDomain – Your Validatable Domain Base Class (PHP)

Welcome, dev! 👋

This package helps you create cleaner and more robust domain models by centralizing business rule validation. It combines automatic validation (using Symfony Validator) and custom validation, making it easy to use in modern PHP APIs and applications.

---

## 💡 What is it?

`RomBaseDomain` is an abstract base class for your domain models. By inheriting from it, you get:

- ✅ Automatic field validation (required, range, email, etc.) via Symfony Validator
- 🧠 Support for custom validation by overriding the `validate()` method
- 📋 Serializable validation error list for APIs/frontends
- 🛡️ Internal methods are not exposed when serializing to JSON

### Naming conventions:
- Prefix `List` for lists
- Suffix `Domain` for domain models
- Suffix `DataTransfer` for DTOs

---

## 🚀 How to use

### 1. Installation

```bash
composer require romuloar/rom.domain-php
```

### 2. Example usage

```php
use RomDomain\UserDomain;

$user = new UserDomain();
$user->name = '';
$user->age = 15;
$user->email = 'not-an-email';
$user->username = 'usr';
$user->phoneNumber = 'abc';
$user->website = 'not-a-url';
$user->password = '123456';
$user->confirmPassword = '654321';

$isValid = $user->isValidDomain(); // false
$errors = $user->getValidationErrors();

foreach ($errors as $error) {
    echo "Field: {$error->field} | Message: {$error->message}\n";
}
```

### 3. Example API response

```json
{
  "success": false,
  "errors": [
    { "field": "name", "message": "The Name field is required." },
    { "field": "age", "message": "The field Age must be between 18 and 120." },
    { "field": "email", "message": "The Email field is not a valid e-mail address." },
    { "field": "username", "message": "The field Username must be a string with a minimum length of 6 and maximum of 12." },
    { "field": "phoneNumber", "message": "The PhoneNumber field is not a valid phone number." },
    { "field": "website", "message": "The Website field is not a valid URL." },
    { "field": "", "message": "'ConfirmPassword' and 'Password' do not match." }
  ]
}
```

### 4. Custom validation

Just override the `validate()` method and use `addValidationError($field, $message)` in your domain class.

---

## 📦 Dependencies

- PHP >= 8.0
- symfony/validator ^7.0

For running tests:
- phpunit/phpunit ^10.0

---

## 📄 License

MIT

---

## Author

Romulo Ribeiro  
Instagram: [@romuloar](https://instagram.com/romuloar)