<?php

namespace App\Http\Controllers\Customer;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CustomerRegistrationRequest;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Notifications\CustomerWelcomeNotification;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthenticationContoller extends Controller
{
    public function register(CustomerRegistrationRequest $request)
    {
        if($request->isMethod('GET')){
            return view('customer.auth.register');
        }
        $customer = Customer::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password'))
        ]);
        $customer->notify(new CustomerWelcomeNotification());
        flashSuccessMessage('Registration Successful :: Welcome to Hamkke 🫰');
        return $this->processLogin($request);
    }

    public function login(LoginRequest $request)
    {
        if($request->isMethod('GET')){
            return view('customer.auth.login');
        }
        return $this->processLogin($request);
    }

    public function processLogin(Request $request)
    {
        $cartItems = Cart::getGuestCartData();
        $request->authenticate(CUSTOMER_GUARD_NAME);

        $request->session()->regenerate();
        Session::put(CART_KEY_IN_SESSION, $cartItems);
        foreach ($cartItems as $item){
            $item['id'] = $item['product_id'];
            Cart::addToCart($item, $item['quantity']);
        }
        return redirect()->intended(RouteServiceProvider::HOME);
    }


    /**
     * Destroy an authenticated session.
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard(CUSTOMER_GUARD_NAME)->logout();

        if(!auth()->check()) {
            $request->session()->invalidate();

            $request->session()->regenerateToken();
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
