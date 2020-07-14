<?php
function apiResponseBuilder($code, $data)
{
	if ($code == 200) {
		$response['status'] = 200;
		$response['data'] = $data;

	} else if ($code == 400) {
		$response['status'] = 400;
		$response['data'] = $data;

	} else if ($code == 404) {
		$response['status'] = 404;
		$response['data'] = $data;

	} else if ($code == 401) {
		$response['status'] = 401;
		$response['data'] = $data;

	} else if ($code == 405) {
		$response['status'] = 405;
		$response['data'] = $data;

	} else {
		$response['status'] = 500;
		$response['data'] = $data;
	}

	return response()-> json($response, $code);
}