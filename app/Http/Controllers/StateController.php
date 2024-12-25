<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('states.index');
    }

    public function fetchStates()
    {
        $states = State::with('country')->orderBy('name')->get();

        return response()->json([
            'states'=>$states,
        ]);
    }

    public function fetchStatesByCountry($countryId)
    {
        $states = State::where('country_id', (int) $countryId)->get();

        return response()->json([
            'states'=>$states,
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
            'name' => 'required|string|max:255|unique:states,name',
            'country_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }

        State::create([
            'name' => $request->name,
            'country_id' => (int) $request->country_id,
        ]);

        return response()->json([
            'status'=>201,
            'message'=>'State Added Successfully.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {
        if (empty($state)) {
            return response()->json([
                'status'=>404,
                'message'=>'No State Found.'
            ]);
        }

        $countries = Country::orderBy('name')->get();

        return response()->json([
            'status'=>200,
            'state'=> $state,
            'countries' => $countries,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:states,name,' . $state->id,
            'country_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages()
            ]);
        }

        if ($state) {

            $state->update([
                'name' => $request->name,
                'country_id' => (int) $request->country_id,
            ]);

            return response()->json([
                'status'=>200,
                'message'=>'State Updated Successfully.'
            ]);
            
        } else {
            return response()->json([
                'status'=>404,
                'message'=>'No State Found.'
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        if($state)
        {
            $state->delete();

            return response()->json([
                'status'=>200,
                'message'=>'State Deleted Successfully.'
            ]);
        }
        else
        {
            return response()->json([
                'status'=>404,
                'message'=>'No State Found.'
            ]);
        }
    }
}
