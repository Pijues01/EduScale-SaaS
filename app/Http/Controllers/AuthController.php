<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        if (auth()->check()) {
            return redirect($this->redirectToDashboard(auth()->user()->role));
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'unique_id' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['unique_id' => $credentials['unique_id'], 'password' => $credentials['password']])) {
            return redirect($this->redirectToDashboard(Auth::user()->role));
        }

        return back()->withErrors(['unique_id' => 'Invalid credentials']);
    }

    private function redirectToDashboard($role)
    {
        switch ($role) {
            case 'admin':
                return route('admin.dashboard');
            case 'teacher':
                return route('teacher.dashboard');
            case 'student':
                return route('student.dashboard');
            case 'parent':
                return route('parent.dashboard');
            default:
                return route('login');
        }
    }




    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }



    //For register

    public function showRegisterForm()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,teacher,student,parent',
        ]);

        // Create new user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password before saving
            'role' => $request->role,
        ]);

        Auth::login($user); // Auto-login after registration

        // Redirect user to their respective dashboard
        return redirect()->route($user->role . '.dashboard');
    }
    //Register End



    //    public function profileshow()
    //     {
    //         $user = Auth::user();

    //         // Load the appropriate profile based on user role
    //         switch ($user->role) {
    //             case 'student':
    //                 $user->load('studentProfile');
    //                 break;
    //             case 'teacher':
    //                 $user->load('teacherProfile');
    //                 break;
    //             case 'parent':
    //                 $user->load('parentProfile.children');
    //                 break;
    //         }

    //         return view('dashboard.profile', compact('user'));
    //     }

    public function profileshow()
    {
        $user = Auth::user();

        // Load the appropriate profile based on user role
        switch ($user->role) {
            case 'student':
                $user->load(['studentProfile' => function ($query) {
                    $query->where('stu_id', Auth::user()->unique_id);
                }]);
                break;
            case 'teacher':
                $user->load(['teacherProfile' => function ($query) {
                    $query->where('teacher_id', Auth::user()->unique_id);
                }]);
                break;
            case 'parent':
                $user->load(['parentProfile' => function ($query) {
                    $query->where('parent_id', Auth::user()->unique_id);
                }]);
                break;
        }

        return view('dashboard.profile', compact('user'));
    }
}
