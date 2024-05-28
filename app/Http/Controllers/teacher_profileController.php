<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacher_profile;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Http\Requests\TeacherProfileRequest;
use App\Http\Requests\TeacherProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;

class teacher_profileController extends Controller
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
    public function store(TeacherProfileRequest $request)
    {
        $user2 = auth()->user()->id;
        $teacher = User::find($user2);


        $data = $request->all();
        $data['user_id'] =
            $user2;
        $photo = '';
        if ($request->hasFile('photo')) {
            $photo  = $request->file('photo')->store('public/images');
        }
        $data['photo'] = $photo;
        $teacher_profile = teacher_profile::create($data);
        $key = 'Data';

        //return $this->returnSuccessMessage($msg = "success", $errNum = "S000");
        return $this->returnData($key, $teacher_profile, $msg = 'Successfully ');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate(["user_id" => "required|Integer|exists:users,id"]);

        $teacher = User::find($request->user_id);
        $profile = $teacher->teacher_profile;
        if (!$profile) {
            return response([
                'message' => 'no profile'
            ], 200);
        }
        return response([
            'user_id' => $request->user_id,
            'photo' =>  $profile->photo,
            'knowledge' => $profile->knowledge,
            'headline' => $profile->headline,
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
    public function update(TeacherProfileUpdateRequest $request)
    {
        $teacher = User::find($request->user_id);
        $profile = $teacher->teacher_profile;
        $data = $request->all();
        if ($request->hasFile('photo')) {
            Storage::delete($profile->photo);
            $photo  = $request->file('photo')->store('public/images');
            $data['photo'] = $photo;
        }
        $profile->update($data);
        $key = "data";
        return $this->returnData($key, $profile, $msg = 'Successfully ');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $request->validate(["user_id" => "required|Integer|exists:users,id"]);
        $teacher = User::find($request->user_id);
        $profile = $teacher->teacher_profile;
        Storage::delete($profile->photo);
        $profile->delete();
        return response([
            'message' => 'deleted successfuly'
        ], 200);
    }
    public function search(Request $request)
    {
        $searchteacher = $request->validate(['name' => 'required']);
        $user = User::where('name', 'like', '%' . $searchteacher['name'] . '%')->get();
        if (!count($user) == 0) {
            return $user;
        } else {
            return response(["message" => "medic not found"]);
        }
    }
}
