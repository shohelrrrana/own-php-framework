<?php


namespace App\Controllers;


use App\Models\RegisterModel;
use Core\Controller;
use Core\Request;

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
			$register        = new RegisterModel();
			$register->loadData( $request->body() );
			var_dump( $register->validate() );
			print_r( $register->errors );
		}

		return $this->view( 'auth/register' );
	}
}