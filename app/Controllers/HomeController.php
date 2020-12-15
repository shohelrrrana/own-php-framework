<?php


namespace App\Controllers;


use Core\Controller;

class HomeController extends Controller {

	public function index () {
		$params = [ 'name' => 'Shohel Rana' ];
		$this->view( 'index', $params );
	}
}