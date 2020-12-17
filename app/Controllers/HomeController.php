<?php


namespace App\Controllers;


use Core\Controller\Controller;

class HomeController extends Controller {

	public function index () {
		$params = [ 'name' => 'Shohel Rana' ];
		return $this->view( 'index', $params );
	}
}