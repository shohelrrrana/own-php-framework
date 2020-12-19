<?php


namespace Core\Http;

/**
 * Class Response
 *
 * @package Core\Http
 */
class Response {

	/**
	 * set http_response_code
	 *
	 * @param int $code
	 */
	public static function setStatusCode ( int $code ) {
		http_response_code( $code );
	}

	/**
	 * convert array to string
	 *
	 * @param $array
	 *
	 * @return false|string
	 */
	public static function json ( $array ) {
		return json_encode( $array );
	}
}