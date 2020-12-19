<?php


namespace App\Controllers;


use Core\Controller\Controller;
use Core\Database\DB;

class HomeController extends Controller {

	public function index () {
		$data = [ 'name' => 'Shohel Rana' ];
		return $this->view( 'index', $data );
	}
}