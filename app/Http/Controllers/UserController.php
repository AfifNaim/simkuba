<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\CashBook;
use App\Models\Category;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','verified']);
    }

    /**
     * Display all users
     *
     * @return Application|Factory|View
     * @throws AuthorizationException
     */
    public function index()
    {
        $this->authorize('user-access');

        $user = \auth()->user();
        abort_if(! $user->hasPermissionTo('user-show'), 403);

        $users = User::when(auth()->user()->hasAnyRole('Manager|Employe'), function ($query){
            return $query->whereNotNull('company_id')
                ->where('company_id', auth()->user()->company_id)
                ->orWhere('id', auth()->user()->id);
        })->get();

        return view('users.index', compact('users'));
    }

    /**
     * Show form for creating user
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created user
     *
     * @param StoreUserRequest $request
     *
     * @return RedirectResponse
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('user-create');

        if (! $request->company_id)
            $saveUser = $request->safe()->merge(['company_id' => \auth()->user()->company_id]);

        $user = User::create($saveUser ? $saveUser->toArray() : $request->validated());

        if (auth()->user()->hasRole('Manager'))
            $user->assignRole('Employe');

        return redirect()->route('users.index')
            ->with('success', __('User created successfully.'));
    }

    /**
     * Show user data
     *
     * @param User $user
     *
     * @return Application|Factory|View
     */
    public function show(User $user)
    {
        $this->authorize('user-show');

        return view('users.show', [
            'user' => $user
        ]);
    }

    /**
     * Edit user data
     *
     * @param User $user
     *
     * @return Application|Factory|View
     */
    public function edit(User $user)
    {
        $this->authorize('user-edit');

        return view('users.edit', [
            'user' => $user,
            'userRole' => $user->roles->pluck('name')->toArray(),
            'roles' => Role::latest()->get()
        ]);
    }

    /**
     * Update user data
     *
     * @param User $user
     * @param UpdateUserRequest $request
     *
     * @return RedirectResponse
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        $user->update($request->validated());

        $user->syncRoles($request->get('role'));

        return redirect()->route('users.index')
            ->with('success', __('User updated successfully.'));
    }

    public function profile(Request $request)
    {
        $this->authorize('user-profile');

        return view('users.profile', [
            'user' => $request->user()
        ]);
    }

    public function update_profile(Request $request)
{
    $request->user()->update(
        $request->all()
    );

    return redirect()->route('users.profile');
}

    /**
     * Delete user data
     *
     * @param User $user
     *
     * @return RedirectResponse
     */

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', __('User deleted successfully.'));
    }
}
