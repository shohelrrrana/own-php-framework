<?php


namespace App\Controllers;

use Core\Controller\Controller;
use Core\Http\Request;

class AuthController extends Controller {
	public function login ( Request $request ) {
		if ( $request->isPost() ) {
			print_r( $request->body() );
			return 'Login';
		}

		return $this->view( 'auth/login' );
	}

	public function register ( Request $request ) {
		if ( $request->isPost() ) {
			$name            = $request->body( 'name' );
			$email           = $request->body( 'email' );
			$password        = $request->body( 'password' );
			$confirmPassword = $request->body( 'confirmPassword' );
		}

		return $this->view( 'auth/register' );
	}
}