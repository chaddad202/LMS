<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\TeacherRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Traits\GeneralTrait;
use App\Http\Requests\user\UserRequest;
use App\Http\Resources\UserIndexResource;
use App\Http\Resources\UserShowResource;
use App\Models\Customer;
use App\Models\role_user;

class AuthController extends Controller
{
    use GeneralTrait;


    public function register_Teacher(TeacherRequest $request)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        if ($user->customer) {
            return $this->returnError(403, 'you have already created profile');
        }
        $user->assignRole('teacher');
        $photo =  $request->file('photo')->store('public/images');
        Customer::create([
            'user_id' => $user_id,
            'photo' => $photo,
            'profession' => $request->profession,
            'description' => $request->description
        ]);
        return $this->returnSuccessMessage('you are teacher now');
    }

    public function register_Student(UserRequest $request)
    {

        $data = $request->all();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);;
        $user->assignRole('student');
        $token = $user->createToken('myapptoken')->plainTextToken;
        $user->update(['remember_token' => $token]);

        return $this->returnData('register successfully', 200, $token);
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
        }
        $key = 'Data';

        return $this->returnData($key, $response, $msg = 'Successful Login');
    }


    public function logout(Request $request)
    {
        auth()->user()->currentAccessToken()->delete();
        return $this->returnSuccessMessage($msg = "Logged Out", $errNum = "S000");
    }
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserShowResource($user);
    }
    public function index($id)
    {
        $user = User::all();
        return new UserIndexResource($user);
    }
}
