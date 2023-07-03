<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RolesController extends AdminController {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        if(Auth::user()->role_id == '2')
        {
        // if (Auth::user()->hasPermission('view_role')) {
            $deps = Role::all();
            return view('roles.all')->with('data', $deps)->with('no', 1);
        }
        else{
            return view('admin.access_denied');
        }
        // } else {
            //// return redirect()->route('access-denied');
        // }
    }

    public function add() {
        if(Auth::user()->role_id == '2')
        {
        // if (Auth::user()->hasPermission('add_role')) {
            return view('roles.add');
        }
        else{
            return view('admin.access_denied');
        }
        // } else {
           // return redirect()->route('access-denied');
        // }
    }
    /**
     * @param \App\Models\Category $category
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function show(Role $role)
    {
        //dd($category);
        // $dataTable=new CategoryDataTable; 
        return view('roles.view', ['object' => $role]);
    }

    public function edit($id) {
        if(Auth::user()->role_id == '2')
        {
        // if (Auth::user()->hasPermission('update_role')) {
            $dep = Role::find($id);
            return view('roles.edit')->with('data', $dep);
        }
        else{
            return view('admin.access_denied');
        }
        // } else {
           // return redirect()->route('access-denied');
        // }
    }

    /**
     * add role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function insert(Request $request) {
//        $rules = [
//            'name' => 'required',
//            'description' => 'required',
//        ];
//        $validator = Validator::make($request->all(), $rules);
        $data = $request->input();
        try {
            $dep = new Role;
            $dep->name = $data['name'];
            $dep->display_name = $data['display_name'];
            $dep->description = $data['description'];
            $dep->save();
            $notification = array(
                'message' => 'Role Added Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.roles.all')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => 'Operation Failed. Please try again!',
                'alert-type' => 'danger'
            );
            return redirect()->route('role-add')->with($notification);
        }
    }

    /**
     * update role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function update(Request $request, $id) {
//        $rules = [
//            'name' => 'required',
//            'description' => 'required',
//        ];
//        $validator = Validator::make($request->all(), $rules);
        $data = $request->input();
        try {
            $dep = Role::find($id);
            $dep->name = $data['name'];
            $dep->display_name = $data['display_name'];
            $dep->description = $data['description'];
            $dep->save();
            $notification = array(
                'message' => 'Role Updated Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.roles.all')->with($notification);
        } catch (Exception $e) {
            $notification = array(
                'message' => 'Operation Failed. Please try again!',
                'alert-type' => 'danger'
            );
            return redirect()->route('role-edit', ['id' => $id])->with($notification);
        }
    }

    /**
     * update role.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function delete($id) {
        if (Auth::user()->hasPermission('delete_role')) {
            try {
                $dep = Role::find($id);
                $dep->delete();
                return redirect()->route('admin.roles.all')->with('status', "deleted successfully");
            } catch (Exception $e) {
                return redirect()->route('admin.roles.all')->with('failed', "operation failed");
            }
        } else {
           // return redirect()->route('access-denied');
        }
    }

    public function rolesPermissions($id) {
        if(Auth::user()->role_id == '2')
        {
        // dd(Auth::user()->allPermissions());
        // if (Auth::user()->hasPermission('assign_permissions')) {
            $role = Role::find($id);
            $per_groups = \App\Models\PermissionsGroup::get();
            $role_per = isset($role->permissions) ? $role->permissions->toArray() : [];
            $per_keys = [];
            foreach ($role_per as $r_per) {
                $per_keys[] = $r_per['id'];
            }
            return view('roles.permissions')
                            ->with('permissions_groups', $per_groups)
                            ->with('role', $role)
                            ->with('role_permissions', $per_keys);
        }
        else{
            return view('admin.access_denied');
        }
        // } else {
           // return redirect()->route('access-denied');
        // }
    }

    public function assignPermissions(Request $request) {
        $data = $request->input();
        $role = Role::find($data['role_id']);
        if (isset($role->permissions)) {
            $role->detachPermissions($role->permissions);
        }
        if (!empty($data['permissions'])) {
            $role->attachPermissions($data['permissions']);
        }
        $notification = array(
            'message' => 'Permissions Updated Successfully!',
            'alert-type' => 'success'
        );
        return redirect()->route('admin.roles.all')->with($notification);
    }

}
