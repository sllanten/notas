<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use WebSocket\Client;
use Illuminate\Support\Facades\Http;


class NotaController extends Controller
{
    public function getData(){
        $data = array(
            "ntFish" => (int)Nota::where('status','congration')->count(),
            "ntCant" => (int)Nota::all()->count(),
            "ntfail" => (int)Nota::where('status','fail')->count(),
            "ntTest" => (int)Nota::where('status','test')->count()
        );
        
        return json_encode($data);
    }

    public function index(){
        return view('welcome');        
    }

    public function storage(Request $request){
        $request->validate([
            'status' => 'required|string|max:4',
            ],[
                'status.required' => 'El campo status es obligatorio.',
                'status.max' => 'El campo status como maximo se espera 4 caracteres.',
            ]);

        if(($_POST['status'] != "congration") || ($_POST['status'] != "fail") || ($_POST['status'] != "test")){
            return redirect()->route('wellcome');
        }

        $ntNew= new Nota();
        $ntNew->status= $request->status;
        $ntNew->save();

        return redirect()->route('wellcome');

    }

    public function sendToWebSocket($data){
        $wsUrl = "ws://localhost:3001";
        $jsonData = json_encode($data);
        $client = new Client($wsUrl);
        $client->send($jsonData);
    }

    public function apiGet(){
        return response()->json(json_decode($this->getData()), 200);
    }

    public function apiStorage(Request $request){
        $ntNew= new Nota();
        $ntNew->status= $request->status;
        $ntNew->save();

        $this->sendToWebSocket($this->getData());
        return response()->json(['status' => 'success saved'], 200);
    }

}
