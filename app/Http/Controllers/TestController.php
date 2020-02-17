<?php
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class TestController extends Controller
{


    public function getData(){
        $data = User::all();
        return response()->json($data);
    }
    
    public function postData(Request $request){
        $input          = $request->all();
        $user           = new User;
        $user->name     = $request['name'];
        $user->password = Hash::make($request['password']);
        $user->email    = $request['email'];
        $user->save();
        return response()->json($user);
    }

    public function getDataUserId($user_id){
        $data = User::find($user_id);
        return response()->json($data);
    }



    public function postDataUserId($id, Request $request){
        $user = User::find($id);
        $user->name = $request['name'];
        $user->save();
        return response()->json($user);
    }


    public function deleteDataUserId($id){
        $data = User::find($id);
        $data->delete();
        return response()->json($data);
    }

}