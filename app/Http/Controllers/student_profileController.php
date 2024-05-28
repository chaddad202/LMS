<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentProfileRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\student_profile;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Storage;


class student_profileController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StudentProfileRequest $request)
    {
        $student = User::find($request->user_id);

        if ($student->hasRole('student')) {
            $data = $request->all();
            /// $data['user_id']= $id;
            $photo = '';
            if ($request->hasFile('photo')) {
                $photo  = $request->file('photo')->store('public/images');
            }
            $data['photo'] = $photo;
            $student_profile = student_profile::create($data);
            $key = 'Data';

            //return $this->returnSuccessMessage($msg = "success", $errNum = "S000");
            return $this->returnData($key, $student_profile, $msg = 'Successfully ');
        } else {
            return response([
                'message' => 'you are not student'
            ], 401);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {

        $request->validate(["user_id" => "required|Integer|exists:users,id"]);
        $student = User::find($request->user_id);
        $profile = $student->student_profile;
        if (!$profile) {
            return response([
                'message' => 'no profile'
            ], 200);
        }
        return response([
            'user_id' => $request->user_id,
            'photo' =>  $profile->photo,
            'age' =>  $profile->age,
            'wallet' =>  $profile->wallet,

        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $student = User::find($request->user_id);
        if ($student->hasRole('student')) {
            $profile = $student->student_profile;
            $data = $request->all();
            if ($request->hasFile('photo')) {
                Storage::delete($profile->photo);
                $photo  = $request->file('photo')->store('public/images');
                $data['photo'] = $photo;
            }
            $profile->update($data);
            $key = "data";
            return $this->returnData($key, $profile, $msg = 'Successfully ');
        } else {
            return response([
                'message' => 'you are not teacher'
            ], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate(["user_id" => "required|Integer|exists:users,id"]);
        $student = User::find($request->user_id);
        $profile = $student->student_profile;
        Storage::delete($profile->photo);
        $profile->delete();
        return response([
            'message' => 'deleted successfuly'
        ], 200);
    }
}
