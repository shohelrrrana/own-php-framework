<?php


namespace App\Controllers;


use Core\Controller;
use Core\Request;

class ContactController extends Controller {
	public function index ( Request $request ) {
		if ( $request->isPost() ) {
			print_r( $request->body() );
		}
		$this->view( 'contact' );
	}
}