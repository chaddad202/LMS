<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountDeleteRequest;
use App\Http\Requests\EmailUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Http\Requests\ProfileUpdateRequest;
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
        if (!Hash::check($request->password, $user->password)) {
            return response(['message' => 'Bad Creds'], 401);
        }
        $user->update([
            'password' => $request->new_password
        ]);
        return $this->returnSuccessMessage('updated successfully');
    }
    public function account_delete(AccountDeleteRequest $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        if (!Hash::check($request->password, $user->password)) {
            return response(['message' => 'Bad Creds'], 401);
        }
        $user->delete();
        return $this->returnSuccessMessage('deleted successfully');
    }
    public function profile_update(ProfileUpdateRequest $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $customer = $user->customer;
        if (! $customer) {
            if (!($request->has('photo') & $request->has('profession') & $request->has('description'))) {
                return response(['message' => 'please isert all information'], 401);
            }
            Customer::create([
                'user_id' => $user->id,
                'photo' => $request->photo,
                'profession'  => $request->profession,
                'description'  => $request->description,
            ]);
            $user->assignRole('teacher');
            return $this->returnSuccessMessage('created successfully');
        }
        $customer->update($request->all());
        return $this->returnSuccessMessage('updated successfully');
    }
}
