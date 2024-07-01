<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Traits\GeneralTrait;
use App\Http\Requests\UserRequest;
use App\Models\role_user;

class AuthController extends Controller
{
    use GeneralTrait;

    // public function register_Admin(UserRequest $request)
    // {

    //     $data = $request->all();

    //     $data['password'] = Hash::make($request->password);
    //     $user = User::create($data);

    //     //$role = Role::findByName('admin');
    //     $user->assignRole('admin');
    //     $roles = $user->getRoleNames();
    //     //$role = role_user::find($user->id)
    //     $token = $user->createToken('myapptoken')->plainTextToken;
    //     $key = 'Data';
    //     $user->token = $token;
    //     $response = [
    //         'Admin' => $user,
    //         'role' => $roles,
    //         'token' => $token
    //     ];
    //     return $this->returnData($key, $response, $msg = 'Successful registration');
    // }

    public function register_Teacher(Request $request)
    {
        $user = User::find(auth()->user()->id);
        // $data = $request->all();

        // $data['password'] = Hash::make($request->password);
        // $user = User::create($data);


        $user->assignRole('teacher');
         $roles = $user->getRoleNames();

        // $token = $user->createToken('myapptoken')->plainTextToken;
         $key = 'Data';
        // $user->token = $token;
        $response = [
            'teacher' => $user,
            'role' => $roles,
            //'token' => $token
        ];
        return $this->returnData($key, $response, $msg = 'Successful registration');
    }

    public function register_Student(UserRequest $request)
    {

        $data = $request->all();

        $data['password'] = Hash::make($request->password);
        $user = User::create($data);;
        $user->assignRole('student');
        $roles = $user->getRoleNames();

        $token = $user->createToken('myapptoken')->plainTextToken;
        $key = 'Data';
        $user->token = $token;
        $response = [
            'Admin' => $user,
            'role' => $roles,
            'token' => $token
        ];
        return $this->returnData($key, $response, $msg = 'Successful registration');
    }


    public function login(Request $request)
    {

        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $fields['email'])->first();

        if ((!$user || !$user->hasRole(['admin', 'teacher', 'student', 'company_owner']) || !Hash::check($fields['password'], $user->password))) {
            return response([
                'message' => 'Bad Creds'
            ], 401);
        } else if ($user->hasRole('admin')) {
            $token = $user->createToken('myapptoken')->plainTextToken;
            $response = [
                'admin' => $user,
                'token' => $token
            ];
        } else if ($user->hasRole('teacher')) {
            $token = $user->createToken('myapptoken')->plainTextToken;
            $response = [
                'teacher' => $user,
                'token' => $token
            ];
        } else if ($user->hasRole('student')) {
            $token = $user->createToken('myapptoken')->plainTextToken;
            $response = [
                'student' => $user,
                'token' => $token
            ];
        } else if ($user->hasRole('company_owner')) {
            $token = $user->createToken('myapptoken')->plainTextToken;
            $response = [
                'company_owner' => $user,
                'token' => $token
            ];
        }
        $key = 'Data';

        return $this->returnData($key, $response, $msg = 'Successful Login');
    }


    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->returnSuccessMessage($msg = "Logged Out", $errNum = "S000");
    }
}
