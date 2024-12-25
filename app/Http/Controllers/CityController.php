<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('cities.index');
    }

    public function fetchCities()
    {
        $cities = City::with('state.country')->orderBy('name')->get();

        return response()->json([
            'cities'=>$cities,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:cities,name',
            'state_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }

        City::create([
            'name' => $request->name,
            'state_id' => (int) $request->state_id,
        ]);

        return response()->json([
            'status'=>201,
            'message'=>'City Added Successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        if (empty($city)) {
            return response()->json([
                'status'=>404,
                'message'=>'No City Found.'
            ]);
        }

        $countryId = $city->state->country->id;
        
        $countries = Country::orderBy('name')->get();
        $states = State::where('country_id', $countryId)->orderBy('name')->get();

        return response()->json([
            'status'=> 200,
            'city'  => $city,
            'states' => $states,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:countries,name,' . $city->id,
            'state_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }

        if ($city) {

            $city->update([
                'name' => $request->name,
                'state_id' => (int) $request->state_id,
            ]);

            return response()->json([
                'status'=>200,
                'message'=>'City Updated Successfully.'
            ]);
            
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'No City Found.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        if($city)
        {
            $city->delete();

            return response()->json([
                'status'=>200,
                'message'=>'City Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No City Found.'
            ]);
        }
    }
}
