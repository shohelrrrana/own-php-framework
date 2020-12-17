<?php


namespace App\Controllers;


use Core\Controller\Controller;
use Core\Http\Request;

class ContactController extends Controller {
	public function index ( Request $request ) {
		if ( $request->isPost() ) {
			print_r( $request->body() );
		}
		return $this->view( 'contact' );
	}
}