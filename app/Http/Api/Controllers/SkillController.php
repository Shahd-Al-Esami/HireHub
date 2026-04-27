<?php

namespace App\Http\Api\Controllers;

use App\Actions\Skill\AddSkills;
use App\Actions\Skill\UpdateSkills;
use App\Http\Api\Controllers\Controller;
use App\Http\Requests\StoreSkillRequest;
use App\Http\Requests\UpdateSkillRequest;
use App\Models\Profile;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
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
    public function store(AddSkills $action ,StoreSkillRequest $request,$profile)
    {
$skills=$action->add($request->validated(),$profile);
return response()->json($skills);
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSkills $action ,UpdateSkillRequest $request,Profile $profile)
    {
       $skills=$action->update($request->validated(),$skill);
       return response()->json($skills);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        //
    }
}
