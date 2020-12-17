<?php


namespace Core\Http;

/**
 * Class Request
 *
 * @package Core\Http
 */
class Request {

	/**
	 * get the request path
	 *
	 * @return string
	 */
	public function path () {
		return $_SERVER['PHP_SELF'] ?? '/';
	}

	/**
	 * get the request method
	 *
	 * @return string
	 */
	public function method () {
		return strtolower( $_SERVER['REQUEST_METHOD'] );
	}

	/**
	 * check is get the request
	 *
	 * @return bool
	 */
	public function isGet () {
		return $this->method() === 'get';
	}

	/**
	 * check is post the request
	 *
	 * @return string
	 */
	public function isPost () {
		return $this->method() === 'post';
	}

	/**
	 * check is delete the request
	 *
	 * @return string
	 */
	public function isDelete () {
		return $this->method() === 'delete';
	}

	/**
	 * get the request params
	 *
	 * @param string $key
	 *
	 * @return array|bool
	 */
	public function body ( $key = '' ) {
		$body = [];

		if ( $this->method() === 'get' ) {
			foreach ( $_GET as $_key => $value ) {
				$body[ $_key ] = filter_input( INPUT_GET, $_key, FILTER_SANITIZE_SPECIAL_CHARS );
			}
		}

		if ( $this->method() === 'post' ) {
			foreach ( $_POST as $_key => $value ) {
				$body[ $_key ] = filter_input( INPUT_POST, $_key, FILTER_SANITIZE_SPECIAL_CHARS );
			}
		}

		if ( ! empty( $key ) ) {
			if ( isset( $body[ $key ] ) ) {
				return $body[ $key ];
			}
			return false;
		}

		return $body;
	}
}