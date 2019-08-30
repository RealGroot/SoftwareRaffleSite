<?php

namespace App\Http\Controllers;

use App\Role;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
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

		if (isset($search)) {
			$userQuery = $userQuery->where('users.name', 'like', '%' . $search . '%');
		}

		$page = $request->query('page', 1);
		if (!is_int($page) && is_string($page)) {
			$page = intval($page);
		}
		if (is_int($page) && $page < 1 || !is_int($page)) {
			$page = 1;
		}

		$userPage = $userQuery
			->select(['users.id', 'users.name', 'users.email', 'roles.display_name as role_name'])
			->join('role_user', 'users.id', '=', 'role_user.user_id')
			->join('roles', 'role_user.role_id', '=', 'roles.id')
			->orderBy('role_name')
			->orderBy('name')
			->paginate(10, null, null, $page);

		if (!empty($search)) {
			$userPage = $userPage->appends(['search' => $search]);
		}

		return view('user.index', [
			'userPage' => $userPage,
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
		return view('user.create');
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
			'role' => ['required', 'string', Rule::in(Role::all('name')->map(function ($role) {
				return $role->name;
			}))],
		]);

		$user = new User;
		$user->name = $validatedData['username'];
		$user->email = $validatedData['email'];
		$user->password = Hash::make($validatedData['password']);
		$user->save();
		$user->attachRole(Role::query()->where('name', '=', $validatedData['role'])->first());

		return redirect('/users');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param User $user
	 * @return Response
	 */
	public function show(User $user)
	{
		return view('user.show');
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
		return view('user.update');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param User $user
	 * @return Response
	 */
	public function destroy(User $user)
	{
		return view('user.destroy');
	}
}
