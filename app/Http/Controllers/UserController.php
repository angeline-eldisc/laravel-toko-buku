<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Carbon\Carbon;
use App\User;
use Auth;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware(function($request, $next) {
            if(Gate::allows('manage-users')) {
                return $next($request);
            }

            abort(403, 'Anda tidak memiliki cukup hak akses.');
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $filterKeyword =  $request->get('keyword');
        $status =  $request->get('status');

        if($status){
            $users = User::where('status', $status)->paginate(10);
        } else {
            $users = User::paginate(10);
        }
        
        if($filterKeyword){
            if($status){
                $users = User::where('email', 'LIKE', "%$filterKeyword%")->where('status', $status)->paginate(10);
            } else {
                $users = User::where('email', 'LIKE', "%$filterKeyword%")->paginate(10);
            }
        }
        
        return view('users.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("users.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required||min:5|max:100',
            'username' => 'required|min:5|max:20',
            'roles' => 'required',
            'phone' => 'required|digits_between:10,12',
            'address' => 'required|min:20|max:200',
            'avatar' => 'image|mimes:jpeg,png,jpg',
            'email' => 'required|email',
            'password' => 'required|min:4|confirmed',
        ]);

        if($request->file('avatar')) {
            $file = $request->file('avatar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('avatar')->move("images/avatars", $fileName);
            $avatar = $fileName;
        } else {
            $avatar = NULL;
        }

        User::create([
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'roles' => json_encode($request->get('roles')),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
            'avatar' => $avatar
        ]);

        return redirect()->route('users.create')->with('sukses', 'User successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('users.show', compact(['user']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->route('users.index')->with('warning',  'You can not edit yourself!');
        }

        $user = User::findOrFail($id);
        return view('users.edit', compact(['user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required||min:5|max:100',
            'roles' => 'required',
            'phone' => 'required|digits_between:10,12',
            'address' => 'required|min:20|max:200',
            'avatar' => 'image|mimes:jpeg,png,jpg'
        ]);

        $user = User::findOrFail($id);
        $avatar_lama = $request->avatar;

        if($request->file('avatar')) {
            $avatar = public_path("images/avatars/".$user->avatar);
            if($user->avatar && file_exists($avatar)){
                unlink($avatar);
            }

            $file = $request->file('avatar');
            $dt = Carbon::now();
            $acak  = $file->getClientOriginalExtension();
            $fileName = rand(11111,99999).'-'.$dt->format('Y-m-d-H-i-s').'.'.$acak; 
            $request->file('avatar')->move("images/avatars", $fileName);
            $avatar = $fileName;
        } else {
            $avatar = $avatar_lama;
        }

        $user->update([
            'username' => $request->get('username'),
            'name' => $request->get('name'),
            'status' => $request->get('status'),
            'roles' => json_encode($request->get('roles')),
            'phone' => $request->get('phone'),
            'address' => $request->get('address'),
            'email' => $request->get('email'),
            'avatar' => $avatar
        ]);

        return redirect()->route('users.edit', $user->id)->with('sukses', 'User successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Auth::user()->id == $id) {
            return redirect()->route('users.index')->with('warning',  'You can not delete yourself!');
        }

        $user = User::findOrFail($id);
        $avatar = public_path("images/avatars/".$user->avatar);
        if($user->avatar && file_exists($avatar)){
            unlink($avatar);
        }
        $user->delete();
        return redirect()->route('users.index')->with('sukses',  'User successfully deleted.');
    }
}
