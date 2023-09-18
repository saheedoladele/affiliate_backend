<?php

namespace App\Http\Controllers;

use App\Filters\BuyerFilter;
use App\Models\Buyer;
use App\Models\Client;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;

use App\Filters\ClientFilter;
use App\Http\Requests\StoreBuyerRequest;
use App\Http\Requests\UpdateBuyerRequest;
use App\Http\Resources\BuyerResource;
use App\Http\Resources\BuyerCollection;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        /// adding query features to the route
        $filter = new BuyerFilter();

        $queryItems = $filter->transform($request);

        if (\count($queryItems) == 0) {
            return new BuyerCollection(Buyer::orderBy('id', 'DESC')->paginate(15));
        } else {
            $buyers = Buyer::where($queryItems)->paginate(10);
            return new BuyerCollection($buyers->appends($request->query()));
        }
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBuyerRequest $request)
    {
        $data = $request->validated();
        /** @var \App\Models\Buyer $user */
        $buyer = Buyer::create([
             'client_id' => $data['clientId'],
            'consultant_id' => $data['consultantId'],
            'property_id' => $data['propertyId'],
            'amount_paid' => $data['amountPaid'],
            'purchase_date' => $data['purchaseDate'],
            'description' => $data['description'],
            'first_ref' => $data['firstRef'],
            'second_ref' => $data['secondRef'],
            'direct_ref' => $data['directRef'],

        ]);

        return  new BuyerResource($buyer);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $buyer = Buyer::find($id);
        $consultant = User::where('id', $buyer->consultant_id)->get();
        $client = Client::where('id', $buyer->client_id)->get();
        $property = Property::where('id', $buyer->property_id)->get();


        if ($buyer) {
            return response()->json(
                            [
                                "success" => true,
                            "message"=> "Buyer fetch successfully",
                            "data" => new BuyerResource($buyer),
                            "consultant" => $consultant,
                            "client" => $client,
                            "property" => $property
                            ], 200);
        } else {
            return response()->json(["success" => false, "message" => "Buyer not found!", "data"=>""], 400);
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBuyerRequest $request, $id)
    {
        $data = $request->validated();
        $buyer = Buyer::find($id);
        if (!$buyer) {
            return response()->json(["success"=>false, "message"=>"No buyer for this id" ], 400);
        } else {

           $buyer->update($data);
             return response()->json([
                        "success" => true,
                        "message" => "Buyer succesfully updated!",
                        "data" => new BuyerResource($buyer)
                    ], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Buyer  $buyer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        if (Buyer::find($id)) {
            Buyer::destroy($id);

            return response()->json([
                "Success" => true,
                "message" => "Buyer deleted successfully!"], 200);
        } else {
            return response()->json([
                        "Success" => false,
                        "message" => "No buyer found with that id"], 404);
        }
    }
}
