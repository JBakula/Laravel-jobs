<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;

class ListingController extends Controller
{
    public function index(){
        $data = Listing::latest()->paginate(6);
        return view('listings.index',['listings'=>$data]);
    }
    
    public function show($id){
        $single = Listing::find($id);
        return view('listings.show',['listing'=>$single]);
    }

    public function create(){
        return view('listings.create');
    }

    public function store(Request $request){
        $userInput = $request->validate([
            'company' => 'required|unique:listings',
            'title' => 'required|max:125',
            'location' => 'required',
            'email' => 'email',
            'website' =>'url',
            'tags' => 'required',
            'description' => 'required'
            
        ]);

        if($request->hasFile('logo')){
            $userInput['logo']=$request->file('logo')->store('logos','public');
        }
        Listing::create($userInput);
        return redirect('/')->with('poruka','Listing created successfully!!');
    }
}
