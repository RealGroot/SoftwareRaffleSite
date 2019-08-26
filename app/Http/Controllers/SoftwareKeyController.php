<?php

namespace App\Http\Controllers;

use App\SoftwareKey;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class SoftwareKeyController extends Controller
{
	/**
	 * SoftwareKeyController constructor.
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('software.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('software.create');
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
