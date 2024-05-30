<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class ClienteController extends BaseController
{
    public function index()
    {
        return view('cliente/index');
    }
}
