<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\UserDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\City;
class AjxController extends AdminController
{
    
    public function index()
    {
       // return $dataTable->render('admin.table', ['link' => route('admin.user.create')]);
    }

    
}
