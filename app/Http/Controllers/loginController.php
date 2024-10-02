<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use App\Models\User;

function encryptAESCTR($data, $key)
{
    $ivLength = openssl_cipher_iv_length('aes-256-ctr');
    $iv = openssl_random_pseudo_bytes($ivLength);
    $encryptedData = openssl_encrypt($data, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv);
    return base64_encode($iv . $encryptedData);
}

function decryptAESCTR($data, $key)
{
    $data = base64_decode($data);
    $ivLength = openssl_cipher_iv_length('aes-256-ctr');
    $iv = substr($data, 0, $ivLength);
    $encryptedData = substr($data, $ivLength);
    return openssl_decrypt($encryptedData, 'aes-256-ctr', $key, OPENSSL_RAW_DATA, $iv);
}


class loginController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexlogin()
    {
        return view('login');
    }

    public function indexregister()
    {
        return view('register');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // Generate a custom token
            $token = Str::random(60);
            $request->session()->put('custom_token', $token);

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);
        

        // Check if the user exists
        $user = User::where('email', $request->email)->first();
        if ($user) {
            return redirect()->back()->with('showDangerModal', true);
        }

        $encryptedPassword = encryptAESCTR($request->password, env('APP_KEY'));

        // Create the user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect('/')->with('status', 'User created successfully');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // Destroy the custom token
        $request->session()->forget('custom_token');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
