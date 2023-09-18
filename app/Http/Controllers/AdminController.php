<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Http\Requests\StoreAdminRequest;
use App\Http\Requests\UpdateAdminRequest;
use App\Http\Requests\AdminLoginRequest;
use App\Filters\UserFilter;
use App\Http\Resources\AdminResource;
use App\Http\Resources\AdminCollection;

class AdminController extends Controller
{
    /**  
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
           // adding query features to the route
           $filter = new UserFilter();

           $queryItems = $filter->transform($request);
           $admins = Admin::where($queryItems);
  
        
           return new AdminCollection($admins->orderBy('id','DESC')->paginate(20)->appends($request->query()));
   
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(AdminLoginRequest $request, Admin $admin)
    {
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)) {
            return \response([
                "message" => "Invalid credential", "success"=> false, "code" => 401
            ], 400);
        }

        $admin = Auth::admin();
        $token = $admin->createToken('main')->plainTextToken;

        $admin =  new AdminResource($admin);
       
        return response()->json(
            [
                "success" => true,
                "message"=> "User Logged-In successfully",
                "data" => $admin,
                "token" => $token
            ], 200);

    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request, Admin $admin)
    {
      if(Auth::logout()) {
        return response([
            "message" => "Logout successfully"
        ]);
      }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminRequest $request)
    {
        $data = $request->validated();

        /** @var \App\Models\User $user */
        $admin = Admin::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'username' => $data['username'],
            'password' => \bcrypt($data['password']),
            'role' => $data['role']
        ]);

        $token = $admin->createToken('main')->plainTextToken;
        $admin =  new AdminResource($admin);

        return response()->json(
            [
                "success" => true,
                "message"=> "Admin created successfully",
                "data" => $admin,
                "token" => $token
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdminRequest  $request
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRequest $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        //
    }
}
