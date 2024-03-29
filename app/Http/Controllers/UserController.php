<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$userQuery = DB::table('users');

		$search = $request->query('search', null);
		if (!is_string($search) || empty($search)) {
			$search = null;
		}

		if (!empty($search)) {
			$userQuery->where('users.name', 'like', '%' . $search . '%');
		}

		$paginator = $userQuery
			->select(['users.id', 'users.name', 'users.email', 'roles.display_name as role_name'])
			->join('role_user', 'users.id', '=', 'role_user.user_id')
			->join('roles', 'role_user.role_id', '=', 'roles.id')
			->orderBy('role_name')
			->orderBy('name')
			->paginate(10)
			->onEachSide(2);

		if ($paginator->currentPage() < 1 || $paginator->currentPage() > $paginator->lastPage()) {
			abort(404);
		}

		if (!empty($search)) {
			$paginator->appends(['search' => $search]);
		}

		return view('user.index', [
			'paginator' => $paginator,
			'searched' => !empty($search),
			'search' => !empty($search) ? $search : '',
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('user.create', ['roles' => Role::all(['name', 'display_name'])]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		$validatedData = $request->validate([
			'username' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:100', 'unique:users,email'],
			'password' => ['required', 'string', 'confirmed'],
			'role' => ['required', 'string', Rule::in(Role::all()->map(function ($role) { return $role->name; }))],
		]);

		$user = new User([
			'name' => $validatedData['username'],
			'email' => $validatedData['email'],
			'password' => Hash::make($validatedData['password']),
		]);
		$user->save();
		$user->attachRole(Role::query()->where('name', '=', $validatedData['role'])->first());

		Cache::tags('user_queries')->flush();

		return redirect()->route('users');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param User $user
	 * @return Response
	 */
	public function edit(User $user)
	{
		return view('user.edit', ['roles' => Role::all(), 'user' => $user]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param User $user
	 * @return Response
	 */
	public function update(Request $request, User $user)
	{
		$validatedData = $request->validate([
			'username' => ['required', 'string', 'max:255'],
			'email' => ['required', 'string', 'email', 'max:100', Rule::unique('users')->ignore($user->id)],
			'role' => ['required', 'string', 'exists:roles,name'],
		]);

		$user->update([
			'name' => $validatedData['username'],
			'email' => $validatedData['email'],
		]);

		$user->detachRoles($user->roles()->get());
		$user->attachRole(Role::query()->where('name', '=', $validatedData['role'])->first());

		Cache::tags('user_queries')->flush();

		return redirect()->route('users');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param User $user
	 * @return Response
	 */
	public function destroy(User $user)
	{
		$user->delete();

		Cache::tags('user_queries')->flush();

		return redirect()->route('users');
	}
}
