<?php

namespace App\Http\Controllers\Forum;

use App\Http\Controllers\Controller;
use App\Http\Requests\Forum\Theme\StoreThemeRequest;
use App\Http\Requests\Forum\Theme\UpdateThemeRequest;
use App\Http\Resources\Forum\Branch\BranchResource;
use App\Http\Resources\Forum\Theme\ThemeResource;
use App\Models\Forum\Branch;
use App\Models\Forum\Theme;

class ThemeController extends Controller
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

    public function createWithBranchID($branchId)
    {
        $branch = Branch::query()->find($branchId);
        $branch = BranchResource::make($branch)->resolve();

        return inertia('Forum/Theme/Create', compact('branch'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreThemeRequest $request)
    {
        $data = $request->validated();
        Theme::query()->create($data);

        return redirect()->route('branches.show', $data['branch_id']);
    }

    /**
     * Display the specified resource.
     */
    public function show(Theme $theme)
    {
        $theme = ThemeResource::make($theme)->resolve();

        return inertia('Forum/Theme/Show', compact('theme'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Theme $theme)
    {
        return inertia('Forum/Theme/Edit', compact('theme'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateThemeRequest $request, Theme $theme)
    {
        $data = $request->validated();
        $theme->update($data);

        return redirect()->route('branches.show', $theme->branch_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Theme $theme)
    {
        $theme->delete();

        return redirect()->route('branches.show', $theme->branch_id);
    }
}
