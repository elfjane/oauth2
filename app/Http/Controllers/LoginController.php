<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LdapRecord\Container;
use LdapRecord\Models\Entry;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Str;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('dashboard'));
        }

        // LDAP Fallback
        try {
            $connection = Container::getConnection('default');

            $ldapUser = Entry::on('default')
                ->where('mail', '=', $request->email)
                ->orWhere('uid', '=', $request->email)
                ->orWhere('sAMAccountName', '=', $request->email)
                ->orWhere('cn', '=', $request->email)
                ->first();
            echo $ldapUser->getDn();
            exit;
            if ($ldapUser && $connection->auth()->attempt($ldapUser->getDn(), $request->password)) {
                // Try to get email from LDAP, fallback to input if it looks like an email
                $email = $ldapUser->mail[0] ?? (filter_var($request->email, FILTER_VALIDATE_EMAIL) ? $request->email : null);
                echo $email;
                exit;
                if (!$email) {
                    // Handle case where we can't determine an email. 
                    // For now, we might generate a fake one or fail. 
                    // Let's assume we can generate one based on the username for now if missing.
                    $email = $request->email . '@elfjane.com';
                }

                $user = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $ldapUser->cn[0] ?? $request->email,
                        'password' => Hash::make(Str::random(24)),
                    ]
                );

                Auth::login($user, $request->boolean('remember'));
                $request->session()->regenerate();

                return redirect()->intended(route('dashboard'));
            }
        } catch (\Exception $e) {
            Log::error('LDAP Error: ' . $e->getMessage());
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
