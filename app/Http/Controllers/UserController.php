<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use DB;
use Hash;
use App\Repositories\User\UserInterface as UserInterface;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data = User::orderBy('id','DESC')->paginate(5);
        return view('users.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $roles = DB::table('roles')->pluck('display_name', 'id');
        return view('users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
         $this->validate($request, [
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles'    => 'required'
        ]);


        $input = $request->all();

        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        //table role_user
            $user->attachRole($request->roles);
        
  
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function show($id)
    {
        //
        $user = User::find($id);
        return view('users.show',compact('user'));

    }

    // *
    //  * Show the form for editing the specified resource.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
     
    public function edit($id)
    {
        //
        $user = User::find($id);
        $roles = Role::pluck('display_name','id');
        $userRole = $user->roles->pluck('id','id')->toArray();


        return view('users.edit',compact('user','roles','userRole'));
    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function update(Request $request, $id)
    {
        //
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = Hash::make($input['password']);
        }else{
            $input = array_except($input,array('password'));    
        }


        $user = User::find($id);
        $user->update($input);
        DB::table('role_user')->where('user_id',$id)->delete();

        
        foreach ($request->input('roles') as $key => $value) {
            $user->attachRole($value);
        }


        return redirect()->route('users.index')
                        ->with('success','User updated successfully');
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function destroy($id)
    {
        //
        User::find($id)->delete();
        return redirect()->route('users.index');    
    }

    //Repositories
    // public function __construct(UserInterface $user){
    //     $this->user =$user;
    // }
    // public function index(){
    //     $users = $this->user->getAll();
    //     return view('user.index',compact('users'));
    // }

    // public function show($id){
    //     $user = $this->user->find($id);
    //     return view('user.show',compact('user'));
    // }

    // public function delete(){
    //     $this->user->delete($id);
    //     return redirect()->back();
    // }

    public function getData(){

        $data = User::all();

        return json_encode($data);
    }
}
