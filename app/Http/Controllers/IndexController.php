<?php

namespace App\Http\Controllers;

class IndexController extends Controller {

	public function index() {
		return redirect('/projects');
	}

}