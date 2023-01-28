<?php

namespace App\Http\Controllers;


use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        $roles = Role::with('permissions')
            ->orderBy('id','DESC')
            ->get();

        return view('roles.index',compact('roles'))
            ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->get('name')]);
        $role->syncPermissions($request->get('permission'));

        return redirect()->route('roles.index')
            ->with('success','Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function show(Role $role)
    {
        $rolePermissions = $role->permissions;

        return view('roles.show', compact('role', 'rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Role $role
     * @return Application|Factory|View
     */
    public function edit(Role $role)
    {
        $rolePermissions = $role->permissions->pluck('name')->toArray();
        $permissions = Permission::get();

        return view('roles.edit', compact('role', 'rolePermissions', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Role $role
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Role $role, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'permission' => 'required',
        ]);

        $role->update($request->only('name'));

        $role->syncPermissions($request->get('permission'));

        return redirect()->route('roles.index')
            ->with('success','Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return RedirectResponse
     */
    public function destroy(Role $role)
    {
        $role->delete();

        return redirect()->route('roles.index')
            ->with('success','Role deleted successfully');
    }
}
