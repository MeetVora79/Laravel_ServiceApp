<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Organization;

class OrganizationController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('organizations.index', [
            'organizations' => Organization::orderBy('OrganizationId')->paginate(15)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('organizations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'OrganizationName' => "required|string|max:255"
        ]);
        // $input = $request->all();

        Organization::create($input);

        return redirect()->route('organizations.index')
                ->with('success','New Organization is Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($OrganizationId): View
    {
        $organization = Organization::where('OrganizationID',$OrganizationId)->first();
        return view('organizations.show', [
            'organization' => $organization
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($OrganizationId): View
    {
        $organization = Organization::where('OrganizationID',$OrganizationId)->first();
        return view('organizations.edit', [
            'organization' => $organization,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $OrganizationId): RedirectResponse
    {
        $organization = Organization::where('OrganizationID',$OrganizationId)->first();
        $input = $request->all();
        $organization->update($input);

        if(empty($request->from)){
        return redirect()->route('organizations.index')
                ->with('success','Organization is Updated Successfully.');
        }else{
            return redirect()->route('organizations.edit')
                ->with('error','Something went Wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($OrganizationId): RedirectResponse
    {
        $organization = Organization::where('OrganizationID',$OrganizationId)->first();
        $organization->delete();
        return redirect()->route('organizations.index')->with('success','Organization is Deleted Successfully.');
    }
}
