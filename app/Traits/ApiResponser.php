<?php

namespace App\Traits;

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Api Responser Trait
|--------------------------------------------------------------------------
|
| This trait will be used for any response we sent to clients.
|
*/

trait ApiResponser
{
	/**
	 * Return a success JSON response.
	 *
	 * @param  string  $message
	 * @param  array|string  $data
	 * @param  string  $status
	 * @param  int|null  $code
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function success(string $message, $data = null, $status = null, int $code = 200)
	{
		return response()->json([
			'success' => true,
			'status' => $status ?? "Success",
			'message' => $message,
			'data' => $data ?? ''
		], $code);
	}

	/**
	 * Return an error JSON response.
	 *
	 * @param  string  $message
	 * @param  int  $code
	 * @param  array|string|null  $data
	 * @return \Illuminate\Http\JsonResponse
	 */
	protected function error(string $message = null, $data = null, int $code = 500)
	{
		return response()->json([
			'success' => false,
			'status' => 'Error',
			'message' => $message ?? '',
			'data' => $data ?? ''
		], $code);
	}
}
