<?php

namespace App\Http\Controllers\Admin;

use App\BookingNote;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingNoteController extends Controller {

	/**
	 * @return mixed
	 */
	public function index() {

		$date = \request()->query( 'date' );

		$notes = BookingNote::where( 'date', $date )->get();

		return $notes;

	}

	/**
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function store() {

		$data = \request()->validate( [
			'date'        => 'required',
			'description' => 'required'
		] );

		$data['time'] = Carbon::now()->toTimeString();

		$note = \auth()->user()->notes()->create( $data );

		return response()->json( [ 'msg' => 'یادداشت با موفقیت ذخیره شد.', 'note' => $note ] );

	}
}
