<?php


namespace Core;


class Request {
	public function path () {
		return $_SERVER['PHP_SELF'] ?? '/';
	}

	public function method () {
		return strtolower( $_SERVER['REQUEST_METHOD'] );
	}

	public function isGet () {
		return $this->method() === 'get';
	}

	public function isPost () {
		return $this->method() === 'post';
	}

	public function isDelete () {
		return $this->method() === 'delete';
	}

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