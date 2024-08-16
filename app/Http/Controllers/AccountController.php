<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountDeleteRequest;
use App\Http\Requests\EmailUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\course\CourseIndexResource;
use App\Models\Course;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AccountController extends Controller
{
    use GeneralTrait;
    //
    public function email_update(EmailUpdateRequest $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        if (!Hash::check($request->password, $user->password)) {
            return response(['message' => 'Bad Creds'], 401);
        }
        $user->update([
            'email' => $request->email
        ]);
        return $this->returnSuccessMessage('updated successfully');
    }
    public function password_update(PasswordUpdateRequest $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        if (!Hash::check($request->old_password, $user->password)) {
            return response(['message' => 'Bad Creds'], 401);
        }
        $user->update([
            'password' => Hash::make(
                $request->new_password
            )
        ]);
        return $this->returnSuccessMessage('updated successfully');
    }
    public function account_delete()
    {
        $user = User::findOrFail(auth()->user()->id);
        $user->delete();
        return $this->returnSuccessMessage('deleted successfully');
    }
    public function profile_update(ProfileUpdateRequest $request)
    {

        $user = User::findOrFail(auth()->user()->id);
        if ($request->has('name')) {
            $user->update([
                'name' => $request->name
            ]);
        }
        $customer = $user->customer;
        if (! $customer) {
            if (!($request->has('photo') & $request->has('profession') & $request->has('description'))) {
                return response(['message' => 'please isert all information'], 401);
            }
            $photo =  $request->file('photo')->store('public/images');


            Customer::create([
                'user_id' => $user->id,
                'photo' => $photo,
                'profession'  => $request->profession,
                'description'  => $request->description,
            ]);
            $user->assignRole('teacher');
            return $this->returnSuccessMessage('created successfully');
        }
        $customer->update($request->all());
        if($request->has('photo')){
            $photo =  $request->file('photo')->store('public/images');
            $customer->update(['photo' => $photo,
        ]);
        }
        return $this->returnSuccessMessage('updated successfully');
    }
    public function user_update(UserUpdateRequest $request, $id)
    {
        $user = User::find($id);
        $amount = $user->wallet + $request->wallet;
        $user->update(['wallet' => $amount]);
        return $this->returnSuccessMessage('updated successfully');
    }
    public function my_courses_enrollnemt()
    {
        $user = User::findOrFail(auth()->user()->id);
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        $enrollment = $user->enrollments;
        if ($enrollment->isEmpty()) {
            return response()->json(['courses' => []], 200);
        }
$course=[];
        $courseIds = $enrollment->pluck('course_id');
        foreach($courseIds as $couse_id){
            $c= Course::find($couse_id);
            $course[]=$c;
        }
        return CourseIndexResource::collection($course);
    }
}
