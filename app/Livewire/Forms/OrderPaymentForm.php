<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class OrderPaymentForm extends Form
{
    #[Validate('required')]
    public ?string $customerFirstName = '';

    #[Validate('required')]
    public ?string $customerLastName = '';

    #[Validate('required|email')]
    public ?string $customerEmail = '';

    #[Validate('required')]
    public ?string $customerPhone = '';

    #[Validate('nullable|exists:countries,id')]
    public string $customerCountry = '';
}
