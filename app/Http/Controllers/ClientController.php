<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */

   public function DisplayGreetings() {
    $name = "Michelle R. Cariño";
    $address = "San Carlos City";

    return view('greetings', compact('name','address'));
}

public function DisplayProfile(){
    return view('clientProfile');
}
public function DisplayDashboard(){
    return view('clientDashboard');
}
public function DisplayAboutUs(){
    return view('clientaboutus');
}
    public function index()
    {
        //
        $grade = 99;
        $client =[
            'name' => 'Mia Shiela Grace Uson',
            'sex' => 'Female',
            'address' => 'San Carlos City'
        ];

        $clients = array(
            array ("name" => "Michelle  ","sex"=>"Female  ","address"=>"San Carlos City"),
            array ("name" => "Maricar   ","sex"=>"Female  ","address"=>"San Carlos City"),
            array ("name" => "Arlyn   ","sex"=>"Female  ","address"=>"San Carlos City")
        );

        // $clients = array();
        return view("client")->with("grade",$grade)->with("clients",$clients);
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}