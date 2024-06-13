<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\Branch\StoreBranchRequest;
use App\Http\Requests\Forum\Branch\UpdateBranchRequest;
use App\Http\Resources\Forum\Branch\BranchResource;
use App\Http\Resources\Forum\Section\SectionResource;
use App\Models\Branch;
use App\Models\Forum\Section;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sections = Section::all();
        $sections = SectionResource::collection($sections)->resolve();
        return inertia('Forum/Branch/Create', compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBranchRequest $request)
    {
        $data = $request->validated();
        Branch::query()->firstOrCreate($data);

        return redirect()->route('sections.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Branch $branch)
    {
        $children = $branch->children;
        $children = BranchResource::collection($children)->resolve();

        $branch = BranchResource::make($branch)->resolve();

        return inertia('Forum/Branch/Show', compact('branch', 'children'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Branch $branch)
    {
        $sections = Section::all();
        $sections = SectionResource::collection($sections)->resolve();
        $branch = BranchResource::make($branch)->resolve();

        return inertia('Forum/Branch/Edit', compact('sections', 'branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $data = $request->validated();
        $branch->update($data);

        return redirect()->route('sections.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Branch $branch)
    {
        $branch->delete();
        return redirect()->back();
    }
}
