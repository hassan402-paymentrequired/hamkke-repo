<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationContoller extends Controller
{
    public function showRegistrationForm()
    {
        return view();
    }
}
