<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use App\Http\Requests\user\TeacherUpdateRequest;
use App\Http\Resources\CustomerShowResource;
use App\Models\Customer;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Traits\GeneralTrait;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $customer=Customer::findOrFail($id);
        return new CustomerShowResource($customer);

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
    public function update(TeacherUpdateRequest $request, $id)
    {
        if ($request->all() === null || count($request->all()) === 0) {
            return $this->returnError(403, 'request input is empty!');
        }
        $user_id = auth()->user()->id;
        $customer = Customer::find($id);
        if ($user_id == $customer->user_id) {
            $customer->update([$request->all]);
            if ($request->hasFile('photo')) {
                Storage::delete($customer->photo);
                $photo  = $request->file('photo')->store('public/images');
                $customer->update(['photo' => $photo]);
            }
            return $this->returnSuccessMessage('updated successfully');
        }
        return $this->returnError(403, 'not authenticated');
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy($id)
    {
        $user_id = auth()->user()->id;
        $customer = Customer::find($id);

        // Check if customer exists
        if (!$customer) {
            return $this->returnError(404, 'Customer not found');
        }

        // Check if the authenticated user is authorized to delete the customer
        if ($user_id == $customer->user_id) {
            // Delete the customer's photo if it exists
            if ($customer->photo) {
                Storage::delete($customer->photo);
            }

            // Delete the customer
            $customer->delete();

            // Find and delete the role association for the user
            $role = Role::where('name', 'teacher')->first();
            if ($role) {
                $user_role = DB::table('role_user')->where('user_id', $user_id)->where('role_id', $role->id)->first();
                if ($user_role) {
                    DB::table('role_user')->where('id', $user_role->id)->delete();
                }
            }

            return $this->returnSuccessMessage('Deleted successfully');
        }

        return $this->returnError(403, 'Not authenticated');
    }
    // public function search(Request $request)
    // {
    //     $searchteacher = $request->validate(['name' => 'required']);
    //     $user = User::where('name', 'like', '%' . $searchteacher['name'] . '%')->get();
    //     if (!count($user) == 0) {
    //         return $user;
    //     } else {
    //         return response(["message" => "medic not found"]);
    //     }
    // }
    }

