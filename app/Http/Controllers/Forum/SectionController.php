<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\Section\UpdateSectionRequest;
use App\Http\Resources\Forum\Branch\BranchResource;
use App\Http\Resources\Forum\Section\SectionResource;
use App\Http\Resources\Forum\Section\SectionWithBranchesResource;
use App\Models\Forum\Section;
use App\Http\Requests\Forum\Section\StoreSectionRequest;
use Illuminate\Support\Facades\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sections = Section::query()->with('branches')->get();
        $sections = SectionWithBranchesResource::collection($sections)->resolve();

        return inertia('Forum/Section/Index', compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return inertia('Forum/Section/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request)
    {
        $data = $request->validated();
        $section = Section::query()->firstOrCreate($data);

        return redirect()->route('sections.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Section $section)
    {


    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Section $section)
    {
        $data = $request->validated();
        $section->update($data);

        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section)
    {
        $section->delete();
        return redirect()->back();
    }

    public function getBranches(Section $section)
    {
        return BranchResource::collection($section->branches)->resolve();
    }
}
