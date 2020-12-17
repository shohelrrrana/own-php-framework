<?php


namespace App\Controllers;


use App\Models\User;
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
			$user            = new User();
			$user->loadData( $request->body() );
			var_dump( $user->validate() );
			print_r( $user->errors );
		}

		return $this->view( 'auth/register' );
	}
}