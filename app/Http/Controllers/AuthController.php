<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\ReCaptcha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index(){
        return view('auth.login');
    } // END Function (Login View)


    public function login(Request $request){
        //Validate
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'g-recaptcha-response' => ['required', new ReCaptcha]
        ]);
        
        //Get Info
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        $flag = false;
        if ($credentials['password'] === $user->password) {
            $flag = true;
            Auth::login($user);
        } else {
            $flag = false;
            return redirect('/login')->with('alert', [
                'type' => 'error',
                'message' => __('Invalid credentials or user is inactive.'),
            ]);
        }
        
        //Check Auth Role
        if ($user && $user->status == 1 && $flag == true) {
            $user_role = Auth::user()->role;
            switch ($user_role) {
                case 1:
                    return redirect('/own')->with('alert', [
                        'type' => 'success',
                        'message' => __('Dashboard Is Ready'),
                    ]);
                    break;
                case 2:
                    return redirect('/editor')->with('alert', [
                        'type' => 'warning',
                        'message' => __('Please Contact Support Team COD_3663'),
                    ]);
                    break;
                case 3:
                    return redirect('/finance')->with('alert', [
                        'type' => 'success',
                        'message' => __('Welcome Mr/Mrs') . $user->profile->fullname,
                    ]);
                    break;
                case 4:
                    return redirect('/emp')->with('alert', [
                        'type' => 'warning',
                        'message' => __('Please Contact Support Team COD_3663'),
                    ]);
                    break;
                default:
                    Auth::logout();
                    return redirect('/login')->with('alert', [
                        'type' => 'error',
                        'message' => __('Something Went Wrong'),
                    ]);
            }
        } else {
            return redirect('/login')->with('alert', [
                'type' => 'error',
                'message' => __('Account Has Been Suspended.'),
            ]);
        }
    } // END Function (Login Fucntion)

    public function logout(){
        auth()->logout();
        return back();
    } // END Function (Logout)
}
