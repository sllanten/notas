<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;


class NotaController extends Controller
{
    public function getData(){
        $ntTest= Nota::where('status','test')->count();
        $ntCant= Nota::all()->count();
        $ntFail= Nota::where('status','fail')->count();
        $ntFish= Nota::where('status','congration')->count();

        $data = array(
            "ntFish" => (int)$ntFish,
            "ntCant" => (int)$ntCant,
            "ntfail" => (int)$ntFail,
            "ntTest" => (int)$ntTest
        );
        
        return json_encode($data);

    }

    public function index(){
        $data= json_decode($this->getData());

        return view('welcome', compact('data'));

    }

    public function store(Request $request){
        $ntNew= new Nota();
        $ntNew->status= $request->status;
        $ntNew->save();
    }
}
