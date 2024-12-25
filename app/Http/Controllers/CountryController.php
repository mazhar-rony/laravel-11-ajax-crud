<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('countries.index');
    }

    public function fetchCountries()
    {
        $countries = Country::orderBy('name')->get();
        
        return response()->json([
            'countries'=>$countries,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:countries,name',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }

        Country::create($request->only('name'));

        return response()->json([
            'status'=>201,
            'message'=>'Country Added Successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
       
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        if (empty($country)) {
            return response()->json([
                'status'=>404,
                'message'=>'No Country Found.'
            ]);
        }

        return response()->json([
            'status'=>200,
            'country'=> $country,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:countries,name,' . $country->id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }

        if ($country) {

            $country->update($request->only('name'));

            return response()->json([
                'status'=>200,
                'message'=>'Country Updated Successfully.'
            ]);
            
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'No Country Found.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        if($country)
        {
            $country->delete();

            return response()->json([
                'status'=>200,
                'message'=>'Country Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No Country Found.'
            ]);
        }
    }
}
