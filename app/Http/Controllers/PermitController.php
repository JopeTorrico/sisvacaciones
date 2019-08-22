<?php

namespace App\Http\Controllers;

use App\Vacation;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;

class PermitController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create($id_worker,$name_worker)
    {
        try {
            $decrypted_id = \Crypt::decrypt($id_worker);
            $decrypted_name = \Crypt::decrypt($name_worker);
        } catch (DecryptException $e) {
            return redirect('/home');
        }
        return view('permit.create')->with('id_worker',$decrypted_id)->with('name_worker',$decrypted_name);
    }

    public function store(Request $request)
    {
       $this->validate($request, [
            'type' => 'required',
            'days_taken' => 'required',
            'reason' => 'required',
            'observations' => 'required',
            'date_init' => 'required',
            'worker_id' => 'required',
        ]);
        
        $permit = new Vacation();
        $permit->type = $request['type'];
        $permit->days_taken = $request['days_taken'];
        $permit->reason = $request['reason'];
        $permit->observations = $request['observations'];
        $permit->date_init = date("Y-m-d", strtotime($request['date_init']));
        $permit->worker_id = $request['worker_id'];

        $permit->save();

        return redirect('/home');
        /* los datos de permiso no pueden ser guardados porque el modelo Permit  no tiene tabla*/
        /*$datosEmpleado = request()-> all();
        return response()->json($datosEmpleado);*/
    }
    public function store1(Request $request)
    {
        $datosPermiso = request()-> all();
        return response()->json($datosPermiso);
    }
}
