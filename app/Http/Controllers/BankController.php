<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bank;
use App\Http\Requests\StoreBankRequest;
use App\Http\Requests\UpdateBankRequest;

use App\Http\Resources\BankResource;
use App\Http\Resources\BankCollection;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $banks = new BankCollection(Bank::orderBy('id', 'DESC')->paginate(15));
        return response()->json(
            [
                "success" => true,
                "message"=> "Bank fetched successfully",
                "data" => $banks
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
     * @param  \App\Http\Requests\StoreBankRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankRequest $request)
    {
        $data = $request->validated();
        /** @var \App\Models\Buyer $user */
        $bank = Bank::create([
             'user_id' => $data['userId'],
            'bank_name' => $data['bankName'],
            'account_number' => $data['accountNumber'],
            'account_name' => $data['accountName']
           

        ]);

        return  new BankResource($bank);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $bank = Bank::find($id);
    
        if ($bank) {
            return response()->json(
                            [
                                "success" => true,
                            "message"=> "Bank fetch successfully",
                            "data" => new BankResource($bank),
                           
                            ], 200);
        } else {
            return response()->json(["success" => false, "message" => "bank not found!", "data"=>""], 400);
        }
    }

    public function userBank(Request $request)
    {
        $userId = $request->query('userId');
        $bank = Bank::where('user_id' , $userId)->get();
        if ($bank) {
            return response()->json(
                            [
                                "success" => true,
                                "message"=> "Bank fetch successfully",
                                "data" => $bank,
                           
                            ], 200);
        } else {
            return response()->json(["success" => false, "message" => "bank not found!", "data"=>""], 400);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBankRequest  $request
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBankRequest $request, $id)
    {
        $data = $request->validated();
        $bank = Bank::find($id);
        if (!$bank) {
            return response()->json(["success"=>false, "message"=>"No bank for this id" ], 400);
        } else {

           $bank->update($data);
             return response()->json([
                        "success" => true,
                        "message" => "Bank succesfully updated!",
                        "data" => new BankResource($bank)
                    ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Bank::find($id)) {
            Bank::destroy($id);

            return response()->json([
                "Success" => true,
                "message" => "Bank deleted successfully!"], 200);
        } else {
            return response()->json([
                        "Success" => false,
                        "message" => "No bank found with that id"], 400);
        }
    }
}
