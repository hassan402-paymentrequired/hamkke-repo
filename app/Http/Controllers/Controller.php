<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableAlias;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    /**
     * @return AuthenticatableAlias|User|null
     */
    public function getAuthUser()
    {
        return auth()->user();
    }

    /**
     * @return AuthenticatableAlias|Customer|null
     */
    public function getAuthUserCustomer()
    {
        return auth(CUSTOMER_GUARD_NAME)->user();
    }
}
