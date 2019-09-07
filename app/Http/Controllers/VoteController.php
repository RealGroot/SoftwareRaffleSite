<?php

namespace App\Http\Controllers;

use App\RaffleVote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
	function toggle_vote(Request $request)
	{
		$validated = $request->validate([
			'payload' => ['required', 'string'],
			'enabled' => ['required', 'boolean']
		]);

		$data = decrypt($validated['payload']);

		if ($validated['enabled']) {
			(new RaffleVote([
				'user_id' => $data['user'],
				'software_id' => $data['software']
			]))->save();
		} else {
			RaffleVote::query()
				->where('user_id', '=', $data['user'])
				->where('software_id', '=', $data['software'])
				->delete();
		}

		return response()->json();
	}
}
