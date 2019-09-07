<?php

namespace App\Http\Controllers;

use App\Platform;
use App\RaffleVote;
use App\SoftwareKey;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Zizaco\Entrust\EntrustFacade as Entrust;

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

		$query = SoftwareKey::query();

		if (!empty($search)) {
			$searchedIds = SoftwareKey::query()
				->whereIn('id', function (Builder $query) use ($search) {
					$query->select('parent_id')
						->from((new SoftwareKey)->getTable())
						->whereNotNull('parent_id')
						->where('title', 'like', "%{$search}%")
						->distinct();
				})
				->orWhereNull('parent_id')
				->where('title', 'like', "%{$search}%")
				->pluck('id');

			$query->whereIn('id', $searchedIds);
		}

		if (!Entrust::hasRole('admin')) {
			$query->where('raffled', '=', false);
			$votes = Auth::user()->votes()->pluck('software_id');
		} else {
			$votes = DB::table((new RaffleVote)->getTable())
				->select('software_id', DB::raw('count(*) as total'))
				->groupBy('software_id')
				->get()->mapWithKeys(function ($values) { return [$values->software_id => $values->total]; });
		}

		$paginator = $query->whereNull('parent_id')
			->orderBy('title')
			->paginate(15)
			->onEachSide(2);

		if ($paginator->currentPage() < 1 || $paginator->currentPage() > $paginator->lastPage()) {
			abort(404);
		}

		if (!empty($search)) {
			$paginator->appends('search', $search);
		}

		$raffleDate = date('j. F Y', mktime(0, 0, 0, date('n') + 1, 1, date('Y')));

		return view('software.index', [
			'search' => $search,
			'searched' => !empty($search),
			'paginator' => $paginator,
			'raffleDate' => $raffleDate,
			'votes' => $votes,
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
		$validatedData = $request->validate([
			'title' => ['required', 'string', 'max:255'],
			'key' => ['required', 'string', 'max:100', 'unique:software_keys,key'],
			'platform_name' => ['required', 'string', 'exists:platforms,name'],
			'shop_link' => ['nullable', 'url'],
			'back_img_link' => ['nullable', 'url'],
			'instruction_link' => ['nullable', 'url'],
			'parent_id' => ['nullable', 'integer', 'min:1', 'exists:software_keys,id'],
		]);

		$validatedData['platform_id'] = Platform::query()
			->where('name', '=', $validatedData['platform_name'])
			->first()->id;

		(new SoftwareKey($validatedData))->save();

		Cache::tags('software_queries')->flush();

		return redirect()->route('keys');
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
		return view('software.edit', ['key' => $key, 'platforms' => Platform::all()]);
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
		$validatedData = $request->validate([
			'title' => ['required', 'string', 'max:255'],
			'key' => ['required', 'string', 'max:100', Rule::unique('software_keys')->ignore($key->id)],
			'platform_name' => ['required', 'string', 'exists:platforms,name'],
			'shop_link' => ['nullable', 'url'],
			'back_img_link' => ['nullable', 'url'],
			'instruction_link' => ['nullable', 'url'],
			'parent_id' => ['nullable', 'integer', 'min:1', 'exists:software_keys,id'],
		]);

		$validatedData['platform_id'] = Platform::query()
			->where('name', '=', $validatedData['platform_name'])
			->first()->id;

		$key->update($validatedData);

		Cache::tags('software_queries')->flush();

		return redirect()->route('keys');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param SoftwareKey $key
	 * @return Response
	 * @throws Exception
	 */
	public function destroy(SoftwareKey $key)
	{
		$key->delete();

		Cache::tags('software_queries')->flush();

		return redirect()->route('keys');
	}
}
