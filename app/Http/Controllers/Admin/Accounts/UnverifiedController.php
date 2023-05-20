<?php

namespace App\Http\Controllers\Admin\Accounts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Accounts;
use App\Models\PersonalInformation;

use App\Http\Controllers\Admin\Accounts\DataController;

class UnverifiedController extends Controller
{
    public function __construct(){
        $this->records = new DataController;
    }

    public function index(){
        // echo json_encode($this->records->index());

        return view('Main.Admin.Accounts.Unverified');
    }

}
