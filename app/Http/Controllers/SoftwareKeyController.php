<?php

namespace App\Http\Controllers;

use App\Platform;
use App\SoftwareKey;
use Barryvdh\Debugbar\Facade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class SoftwareKeyController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$search = $request->query('search', null);
		if (!is_string($search) || empty($search)) {
			$search = null;
		}

		$searchedIds = null;
		if (!empty($search)) {
			$searchedIds = SoftwareKey::query()->where('software_keys.title', 'like', '%' . $search . '%')->get();
		}

		$paginator = SoftwareKey::query()
			->whereNull('parent_id')
			->orderBy('title')
			->paginate(15)
			->onEachSide(2);

		if ($paginator->currentPage() < 1 || $paginator->currentPage() > $paginator->lastPage()) {
			abort(404);
		}

		if (!empty($search)) {
			$paginator->appends('search', $search);
		}

		return view('software.index', [
			'search' => $search,
			'searched' => !empty($search),
			'paginator' => $paginator,
		]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('software.create', ['platforms' => Platform::all()]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param Request $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		return view('software.store');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param SoftwareKey $key
	 * @return Response
	 */
	public function show(SoftwareKey $key)
	{
		return view('software.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param SoftwareKey $key
	 * @return Response
	 */
	public function edit(SoftwareKey $key)
	{
		return view('software.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param Request $request
	 * @param SoftwareKey $key
	 * @return Response
	 */
	public function update(Request $request, SoftwareKey $key)
	{
		return view('software.update');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param SoftwareKey $key
	 * @return Response
	 */
	public function destroy(SoftwareKey $key)
	{
		return view('software.destroy');
	}
}
