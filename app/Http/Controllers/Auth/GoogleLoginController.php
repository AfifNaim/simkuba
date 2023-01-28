<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleLoginController extends Controller
{

    public function redirectToProvider()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    public function handleProviderCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
        } catch (ClientException $exception) {
            return redirect()->route('login')
                ->with('error','Invalid credentials provided.');
        }

        $username = explode('@', $user->getEmail());

        $userCreated = User::firstOrCreate(
            [
                'email' => $user->getEmail()
            ],
            [
                'email_verified_at' => now(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
            'password' => bcrypt('password'),
                'status' => true,
            ]
        );

        $userCreated->assignRole('Manager');

        Auth::login($userCreated);
        if (auth()->user()->hasRole('Admin')) {
            return redirect()->route('dashboard');
        }elseif (auth()->user()->hasRole('Manager')) {
            if (auth()->user()->company_id == NULL){
                return redirect()->route('companies.create');
            }else{
                return redirect()->route('dashboard');
            }
        }elseif (auth()->user()->hasRole('Employe')) {
            return redirect()->route('dashboard');
        }
        else{
            return redirect()->route('cash-books.index');
        }
    }
}
