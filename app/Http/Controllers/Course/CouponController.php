<?php

namespace App\Http\Controllers\course;

use App\Http\Controllers\Controller;
use App\Http\Requests\coupon\CouponRequest;
use App\Http\Requests\coupon\CouponUpdateRequest;
use App\Models\Coupon;
use App\Models\Course;
use App\Traits\GeneralTrait;
use App\Models\User;

class CouponController extends Controller
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
    public function store(CouponRequest $request)
    {
        $user_id = auth()->user()->id;

        Coupon::create([
            'user_id' => $user_id,
            'coupon_code' => generateUniqueCouponCode(),
            'discount' => $request->discount
        ]);
        return $this->returnSuccessMessage("created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function update(CouponUpdateRequest $request,  $id)
    {
        if ($request->all() === null || count($request->all()) === 0) {
            return $this->returnError(403, 'request input is empty!');
        }
        $user = auth()->user()->id;
        $coupon = Coupon::findOrFail($id);
        if ($user == $coupon->user_id || $user->hasRole('admin')) {
            $coupon->update($request->all());
            return $this->returnSuccessMessage("updated successfully");
        }
        return $this->returnError(403, 'not authenticated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $coupon = Coupon::findOrFail($id);
        $courses = $coupon->courses;
        if ($courses) {
            foreach ($courses as $course) {
                $course->coupon_id = null;
            }
        }
        if ($user_id == $coupon->user_id || $user->hasRole('admin')) {
            $coupon->delete();
            return $this->returnSuccessMessage("deleted successfully");
        }
        return $this->returnError(403, 'not authenticated');
    }
}
