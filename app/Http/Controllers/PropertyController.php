<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Http\Requests\StorePropertyRequest;
use App\Http\Requests\UpdatePropertyRequest;

use Illuminate\Http\Request;
use App\Filters\PropertyFilter;
use App\Http\Resources\PropertyResource;
use App\Http\Resources\PropertyCollection;


class PropertyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // adding query features to the route
        $filter = new PropertyFilter();

        $queryItems = $filter->transform($request);

        if (\count($queryItems) == 0) {
            return new PropertyCollection(Property::orderBy('id', 'DESC')->paginate(10));
        } else {
            $properties = Property::where($queryItems)->paginate(10);
            return new PropertyCollection($properties->appends($request->query()));
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
     * @param  \App\Http\Requests\StorePropertyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropertyRequest $request)
    {
        $data = $request->validated();

        $files = [];

        //  if ($request->has('images')) {
        //     $image = $request->images;
        //    foreach ($image as $key => $value) {
        //         $name = time().$key.".".$value->getClientOriginalExtension();
        //         $path = \public_path('properties');
        //         $value->move($path, $name);
        //         $files[] = $name;
               
        //    }
        // }
           
          
        $imageName = time().'.'.$request->images->extension();  
        $request->images->move(public_path('images'), $imageName);

        /** @var \App\Models\Property $property */
        $property = Property::create([
            'property_name' => $data['propertyName'],
            'description' => $data['description'],
            'actual_price' => $data['actualPrice'],
            'promo_price' => $data['promoPrice'],
            'survey_price' => $data['surveyPrice'],
            'location' => $data['location'],
            'promo_details' => $data['promoDetails'],
            'c_of_o' => $data['cofo'],
            'deed_of_assignment' => $data['deedofAssignment'],
            'developmental_levy' => $data['developmentalLevy'],
            'property_images' =>  $imageName                //\json_encode($files)
        ]);

      
          $property = new PropertyResource($property);
        return \response(\compact('property'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function show(Property $property)
    {
        $property = new PropertyResource($property);
        if ($property) {
            return \response(\compact('property'));
        } else {
            return \response("No Property");
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function edit(Property $property)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePropertyRequest  $request
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePropertyRequest $request, Property $property)
    {
        $data = $request->validated();

        $property->update($data);

        return new PropertyResource($data);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function destroy(Property $property)
    {
        $property->delete();

        return response("", 201);
    }
}
