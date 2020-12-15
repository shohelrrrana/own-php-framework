<?php


namespace App\Controllers;


use Core\Controller;
use Core\Request;

class AuthController extends Controller {
	public function login ( Request $request ) {
		if ( $request->isPost() ) {
			print_r( $request->body() );
			echo 'Login';
		}

		$this->view( 'auth/login' );
	}

	public function register ( Request $request ) {
		if ( $request->isPost() ) {
			print_r( $request->body() );
			echo 'Register';
		}

		$this->view( 'auth/register' );
	}
}