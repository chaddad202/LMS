<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\teacher_profile;
use App\Models\User;
use App\Traits\GeneralTrait;
use App\Http\Requests\TeacherProfileRequest;
use App\Http\Requests\TeacherProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\ProfileTeacherResource;

class teacher_profileController extends Controller
{
    use GeneralTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teachers = User::whereHas('roles', function ($query) {
            $query->where('name', 'teacher');
        })->get();
        return
            ProfileTeacherResource::collection($teachers);
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
        $userId = auth()->user()->id;
        $teacher = User::find($userId);
        if (teacher_profile::where('user_id', $userId)->exists()) {
            return $this->returnError('E002', 'User already has a profile');
        }
        $data = $request->all();
        $data['user_id'] =
            $userId;
        $photo = '';
        if ($request->hasFile('photo')) {
            $photo  = $request->file('photo')->store('public/images');
        }
        $data['photo'] = $photo;
        $teacher_profile = teacher_profile::create($data);
        $key = 'Data';

        //return $this->returnSuccessMessage($msg = "success", $errNum = "S000");
        return response([
            'message' => 'created successfully'
        ], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate(["user_id" => "required|Integer|exists:users,id"]);

        $teacher = User::find($request->user_id);
        return new ProfileTeacherResource($teacher);
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
        return response([
            'message' => 'updated successfuly'
        ], 200);
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
