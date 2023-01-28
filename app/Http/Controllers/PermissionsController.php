<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $permissions = Permission::all();

        return view('permissions.index', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Show form for creating permissions
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:users,name'
        ]);

        Permission::create($request->only('name'));

        return redirect()->route('permissions.index')
            ->with('success', __('Permission created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return Application|Factory|View
     */
    public function edit(Permission $permission)
    {
        return view('permissions.edit', [
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  Permission  $permission
     * @return RedirectResponse
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,'.$permission->id
        ]);

        $permission->update($request->only('name'));

        return redirect()->route('permissions.index')
            ->with('success', __('Permission updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return RedirectResponse
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', __('Permission deleted successfully.'));
    }
}
