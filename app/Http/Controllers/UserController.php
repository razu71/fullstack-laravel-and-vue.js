<?php

namespace App\Http\Controllers;

use App\Http\Requests\EditUserRequest;
use App\Http\Requests\LoginRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::check() && $request->path() != 'login') {
            return redirect('/login');
        }

        if (!Auth::check() && $request->path() == 'login') {
            return view('welcome');
        }
//         you are already logged in... so check for if you are an admin user..
        $user = Auth::user();
        if ($user->userType == 'User') {
            return redirect('/login');
        }
        if ($request->path() == 'login') {
            return redirect('/');
        }
//        return $request->path();

//        return $this->checkForPermission($user, $request);
    }
    public function checkForPermission($user, $request)
    {
        $permission = json_decode($user->role->permission);
        $hasPermission = false;
        if (!$permission) {
            return view('welcome');
        }

        foreach ($permission as $p) {
            if ($p->name == $request->path()) {
                if ($p->read) {
                    $hasPermission = true;
                }
            }
        }
        if ($hasPermission) {
            return view('welcome');
        }

        return view('welcome');
        return view('notfound');
    }
    public function userList()
    {
        return User::orderBy('id', 'desc')->get();
    }

    public function createUser(Request $request)
    {
        $this->validate($request, [
            'fullName' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'userType' => 'required',
        ]);
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userType' => $request->userType
        ];
        $user = User::create($data);
        return response()->json([
            'success' => true,
            'data' => $user,
            'message' => __('User added successfully')
        ]);
    }

    public function deleteUser(Request $request)
    {
        $user = User::find($request->id);
        if (!empty($user)) {
            $user->delete();
            return response()->json([
                'success' => true,
                'data' => $user,
                'message' => __('User deleted successfully')
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => null,
                'message' => __('Something went wrong')
            ]);
        }
    }

    public function editUser(EditUserRequest $request)
    {
        $data = [
            'fullName' => $request->fullName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userType' => $request->userType,
        ];
        return User::where('id', $request->id)->update($data);
    }

    public function login(Request $request)
    {
        return 'ok';
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return ['success' => true, 'data' => [], 'message' => 'you are logged in'];
        }else{
            return ['success' => false, 'data' => [], 'message' => 'Un authorized'];
        }
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
