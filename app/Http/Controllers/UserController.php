<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use App\Models\Client;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Filters\UserFilter;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;

class UserController extends Controller
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

         $includeBank = $request->query('include');

         $users = User::where($queryItems);

         if($includeBank) {
            $users = $users->with('bank');
         }
         
         return new UserCollection($users->orderBy('id','DESC')->paginate(20)->appends($request->query()));
 
       
    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginRequest $request, User $user)
    {
        $credentials = $request->validated();
        if(!Auth::attempt($credentials)) {
            return \response([
                "message" => "Invalid credential", "success"=> false, "code" => 401
            ], 400);
        }

        $user = Auth::user();
        $token = $user->createToken('main')->plainTextToken;

        $user =  new UserResource($user);
       
        return response()->json(
            [
                "success" => true,
                "message"=> "User Logged-In successfully",
                "data" => $user,
                "token" => $token
            ], 200);

    }


     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request, User $user)
    {
      if(Auth::logout()) {
        return response([
            "message" => "Logout successfully"
        ]);
      }
    }


    public function stat(Request $request)
    {
        $totalUsers = User::count();
        $totalClients  = Client::count();
        $totalProperties = Property::count();

        $data = ["allUsers" => $totalUsers, "allClient" => $totalClients, "allProperties" => $totalProperties];
        return response()->json([
            "success" => true,
            "message" => "Dashboard statistics",
            "data" => $data
        ], 200);

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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $data = $request->validated();
        $data['referal_code'] = Str::upper(Str::random(8));


        /** @var \App\Models\User $user */
        $user = User::create([
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'email' => $data['email'],
            'password' => \bcrypt($data['password']),
            'address' => $data['address'],
            'phone_number' => $data['phoneNumber'],
            'referal_code' => $data['referal_code'],
            'refered_by' => $data['referedBy'],
            'gender' => $data['gender'],
            'dob' => $data['dob']
            // 'profile_picture' => $imageName

        ]);

        $token = $user->createToken('main')->plainTextToken;
        $user =  new UserResource($user);

        // return response(\compact('user'));
        return response()->json(
            [
                "success" => true,
                "message"=> "User created successfully",
                "data" => $user,
                "token" => $token
            ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        $includeBank = request()->query('include');
        if($includeBank){
            $user = User::with('bank')->get()->find($id);
        }
        $myRef = User::where('refered_by', $user->referal_code)->get();
        $myAuthor = User::where('referal_code', $user->refered_by)->get()->first();
        if ($user) {
            return response()->json(
                            [
                                "success" => true,
                                "message"=> "User fetch successfully",
                                "data" => new UserResource($user),
                                "referals" => $myRef,
                                "author" => $myAuthor
                            ], 200);
        } else {
            return response()->json(["success" => false, "message" => "User not found!", "data"=>""], 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id)
    {
        $data = $request->validated();
        $user = User::find($id);
        if (!$user) {
            return response()->json(["success"=>false, "message"=>"No user for this id" ], 400);
        } else {
             if (isset($data['password']))
                {
                    $data['password'] = \bcrypt($data['password']);
                }
           $user->update($data);
             return response()->json([
                        "success" => true,
                        "message" => "User succesfully updated!",
                        "data" => new UserResource($user)
                    ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (User::find($id)) {
            User::destroy($id);

            return response()->json([
                "Success" => true,
                "message" => "User deleted successfully!"], 200);
        } else {
            return response()->json([
                        "Success" => false,
                        "message" => "No user found with that id"], 400);
        }
    }
}
