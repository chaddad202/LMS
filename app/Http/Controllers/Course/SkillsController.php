<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\Skills\SkillsRequest;
use App\Http\Requests\Skills\SkillsUpdateRequest;
use App\Http\Resources\Skills\SkillsIndexResource;
use App\Http\Resources\Skills\SkillsShowResource;
use App\Models\Course_skills;
use App\Models\Skills;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Traits\GeneralTrait;

class SkillsController extends Controller
{
    use GeneralTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $skills = Skills::all();
        return SkillsIndexResource::collection($skills);
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
    public function store(SkillsRequest $request)
    {
        if ($request->maximunPoint > 100) {
            return $this->returnError(304, 'maximun=100');
        }
        Skills::create($request->all());
        return $this->returnSuccessMessage('created successfully');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $skill = Skills::findOrFail($id);
        return new SkillsShowResource($skill);
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
    public function update(SkillsUpdateRequest $request, $id)
    {
        if ($request == Null) {
            return $this->returnError(304, 'nothing to update');
        }
        $skill = Skills::findOrFail($id);
        $skill->update($request->all());
        return $this->returnSuccessMessage("updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $skill = Skills::findOrFail($id);
        $skill->delete();
        return $this->returnSuccessMessage("destroyed successfully");
    }
}
