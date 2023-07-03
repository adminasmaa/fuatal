<?php

namespace App\Http\Controllers\Admin;

use App\Base\Controllers\AdminController;
use App\Http\Controllers\Admin\DataTables\UserDataTable;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Hash;
class UserController extends AdminController
{

    /**
     * @param \App\Http\Controllers\Admin\DataTables\UserDataTable $dataTable
     *
     * @return mixed
     */
    public function index(UserDataTable $dataTable)
    {   
        $users = User::all();
        return view('admin.table', ['link' => route('admin.user.create'),'users' => $users]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function create()
    {
        if(Auth::user()->hasPermission('add_user'))
        {
        return view('admin.forms.user', $this->formVariables('user', null));
        }
        else{
            return view('admin.access_denied');
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function store(Request $request)
    {
        
        // $request->merge(['phone' => $request->phone2]);
        $validator = $request->validate([
            'email'     => 'nullable|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'phone2' => 'required',
            'full_name' => 'required',
            'dob' => 'date|before:-4 years'
        ], ['dob.before' => 'Age must be at least 4 years']);
        $phone_length = '00'.$request->country_code . $request->phone2;
        if(strlen($phone_length) > 15)
        {
            return redirect()->back()->With('error', 'Phone number length exceeded');
        }
        $email=$request->email;
        $dob=$request->dob;
        $city=$request->city;
        User::insert([  
                  "email"=>$email, 
                  "password"=>bcrypt($request->password), 
                  "full_name" =>$request->get("full_name"),
                  "dob" => $dob,
                  "gender" =>$request->get("gender"),
                  "country_code" => $request->country_code,
                  "phone" => '00'.$request->country_code.$request->phone2,
                  "city"=>$city,
                  "country"=>$request->get("country"),
                  'created_at' => Carbon::now(),
                  'updated_at' => Carbon::now(),
                  'is_active' => 1
                //   "location"=>$request->get("city")

            ]);
        return redirect('/admin/user')->with(['success'=>'Successfully added!']);
        //return $this->createFlashRedirect(User::class, $request);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function show(User $user)
    {
        return view('admin.show', ['object' => $user]);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|string
     */
    public function edit(User $user)
    {   
        //dd($user);
        if(Auth::user()->hasPermission('update_user'))
        {

        return view('admin.forms.user', $this->formVariables('user', $user));
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    /**
     * @param \App\Models\User $user
     * @param \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function update(User $user, Request $request)
    {
        $request->merge(['phone' => $request->phone2]);
        $validator = $request->validate([
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'full_name' => 'required',
            'phone' => 'required|digits:11',
            'dob' => 'date|before:-4 years'
        ], ['dob.before' => 'Age must be at least 4 years']);
        $user->email = $request->email;
        $user->full_name = $request->full_name;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->updated_at = Carbon::now();
        // $user->location = $request->city;
        $user->phone = '00'.$request->country_code.substr($request->phone,1);
        $user->save();
      return redirect('/admin/user')->with(['success'=>'Successfully Updated!']);
    }

    /**
     * @param \App\Models\User $user
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(User $user)
    {
        if(Auth::user()->hasPermission('delete_user'))
        {
        if ($user->id !== auth()->user()->id) {
            return $this->destroyFlashRedirect($user);
        }
        return $this->redirectRoutePath('index', 'admin.delete.self');
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function deleteAdmin(User $user)
    {
        if(Auth::user()->hasPermission('delete_admin'))
        {
        if ($user->id !== auth()->user()->id) {
            return $this->destroyFlashRedirect($user);
        }
        return redirect()->route('list.admin');
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function listAdmin()
    {
        if(Auth::user()->hasPermission('view_admin'))
        {
        $admins=User::where('role_id', '!=', '0')->get();
        return view('admin.admin-listing',['admins'=>$admins, 'link' => route('admin.create.admin')]);
        }
        else{
            return view('admin.access_denied');
        }
    }

    public function createAdmin()
    {
        if(Auth::user()->hasPermission('add_admin'))
        return view('admin.forms.admin', ['action' => 'save']);
        else{
            return view('admin.access_denied');
        }
    }

    public function saveAdmin(Request $request)
    {
        $request->merge(['phone' => $request->phone2]);
        $validator = $request->validate([
            'email'     => 'nullable|email|unique:users,email',
            'password'  => 'required|min:6|confirmed',
            'phone' => 'required|digits:11',
            'full_name' => 'required',
            'dob' => 'date|before:-4 years'
        ], ['dob.before' => 'Age must be at least 4 years']);
        
        $email=$request->email;
        $dob=$request->dob;
        $city=$request->city;
        User::insert([  
                  "email"=>$email, 
                  "password"=>bcrypt($request->password), 
                  "full_name" =>$request->get("full_name"),
                  "dob" => $dob,
                  "gender" =>$request->get("gender"),
                  "phone" =>'00'.$request->country_code.substr($request->phone,1),
                  "city"=>$city,
                  "country"=>$request->get("country"),
                  'created_at' => Carbon::now(),
                  'updated_at' => Carbon::now(),
                  'is_active' => 1,
                  'role_id' => '1'
                //   "location"=>$request->get("city")

            ]);
        return redirect('/admin/listing/admin')->with(['success'=>'Successfully added!']);
        //return $this->createFlashRedirect(User::class, $request);
    }

    public function editAdmin($id)
    {   
        if(Auth::user()->hasPermission('update_admin'))
        {
        $user = User::where('id', $id)->first();
        //dd($user);

        return view('admin.forms.admin', ['user' => $user, 'action' => 'update']);
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function updateAdmin(Request $request)
    {
        $user = User::where('id', $request->id)->first();
        $request->merge(['phone' => $request->phone2]);
        $validator = $request->validate([
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'full_name' => 'required',
            'phone' => 'required|digits:11',
            'dob' => 'date|before:-4 years'
        ], ['dob.before' => 'Age must be at least 4 years']);
        $user->email = $request->email;
        $user->full_name = $request->full_name;
        $user->dob = $request->dob;
        $user->gender = $request->gender;
        $user->city = $request->city;
        $user->country = $request->country;
        $user->updated_at = Carbon::now();
        // $user->location = $request->city;
        $user->phone = '00'.$request->country_code.substr($request->phone,1);
        $user->save();
      return redirect('/admin/listing/admin')->with(['success'=>'Successfully Updated!']);
    }

    public function userRoles($id) {
        if (auth()->user()->hasPermission('assign_roles')) {
            $user = User::find($id);
            $roles = Role::get();
            $user_roles = isset($user->roles) ? $user->roles->toArray() : [];
            $roles_keys = [];
            foreach ($user_roles as $u_role) {
                $roles_keys[] = $u_role['id'];
            }
            return view('admin.roles')
                            ->with('roles', $roles)
                            ->with('user', $user)
                            ->with('user_roles', $roles_keys);
        } else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function assignRoles(Request $request) {
            $data = $request->input();
            $user = User::find($data['emp_id']);
            if (isset($user->roles)) {
                $user->detachRoles($user->roles);
            }
            if (!empty($data['roles'])) {
                $user->attachRoles($data['roles']);
            }
            $users = User::all();
            $notification = array(
                'message' => 'Roles Updated Successfully!',
                'alert-type' => 'success'
            );
            return redirect()->route('admin.list.admin')->with('data', $users)->with('no', 1)->with($notification);
        
    }

    public function userPassword($id)
    {
        if(Auth::user()->hasPermission('update_user'))
        {
            return view('admin.forms.password', $this->formVariables('user', $id), ['action' => 'password']);
        }
        else{
            return redirect()->back()->with('error', __('admin.access_denied'));
        }
    }

    public function updatePassword(Request $request,$id)
    {
        $validator = $request->validate([
            'password'  => 'required|min:6|max:15|confirmed',
        ]);
        
        $id->update(['password'=> $request->password]);
        return redirect('/admin/user')->with(['success'=>'Password Successfully Updated!']);
    }
}
