<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\Tahunajaran;
use DataTables;
use Alert;
use Auth;

class UsersController extends Controller
{
    public $title = "Dosen";
    public $route = "users";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $identity = array(
        'title' => $this->title,
        'route' => $this->route
      );
      if($request->ajax()) {
        if(Auth::user()->role_id == 102) {
          $data = Users::join('prodis', 'prodis.id', 'users.prodi')
                      ->join('fakultas', 'fakultas.id', 'users.fakultas')
                      ->where('prodis.id', '=', Auth::user()->prodi)
                      ->where('role_id', '=', 100)
                      ->get(['users.*', 'prodis.nama_prodi', 'fakultas.nama_fakultas']);
        } else {
          $data = Users::join('prodis', 'prodis.id', 'users.prodi')
                      ->join('fakultas', 'fakultas.id', 'users.fakultas')
                      ->where('role_id', '=', 100)
                      ->get(['users.*', 'prodis.nama_prodi', 'fakultas.nama_fakultas']);
        }

        return datatables()->of($data)
        ->addColumn('is_active', function($data) {
          return $data->is_active==1?"<span class='btn btn-primary btn-xs'>Aktif</span>":"<span class='btn btn-danger btn-xs'>Tidak Aktif</span>";
        })
        ->addColumn('action', 'users.'.$this->route.'.action')
        ->rawColumns(['action', 'is_active'])
        ->addIndexColumn()
        ->make(true);
      }
      return view('users.'.$this->route.'.index', compact('identity'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $post = Users::findOrFail($id);
      $identity = array(
        'title' => $this->title,
        'route' => $this->route
      );
      return view('users.'.$this->route.'.edit', compact('post', 'identity'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function matakuliah(Request $request) {
      $users_id = $request->id;
      $posts = Tahunajaran::latest()->get();
      // $post = Users::findOrFail($request->id);
      // echo $post->id;exit;
      $identity = array(
        'title' => $this->title,
        'route' => $this->route,
        'users_id' => $request->id
      );
      //   $data = Tahunajaran::latest()->get();
      // if($request->ajax()) {
      //   return datatables()->of($data)
      //   ->addColumn('action', function($data) {
      //     return '<a href="'.url('dosenmk/'.$data->semester.'/'.$data->id).'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success btn-sm edit">
      //               Lihat
      //             </a>';
      //   })
      //   ->rawColumns(['action'])
      //   ->addIndexColumn()
      //   ->make(true);
      // }
      return view('users.'.$this->route.'.matakuliah', compact('posts', 'identity'));
    }

    public function selectDosenProdi(Request $request)
    {
    	$dosen = [];

      if($request->has('q')){
          $search = $request->q;
          $dosen = Users::select("id", "name")
                        ->where('role_id', '=', 100)
                        ->where('prodi', '=', Auth::user()->prodi)
                    		->where('name', 'LIKE', "%$search%")
                    		->get();
      } else {
          $dosen = Users::where('role_id', '=', 100)->where('prodi', '=', Auth::user()->prodi)->limit(10)->get();
      }
      return response()->json($dosen);
    }

    public function selectDosenFakultas(Request $request)
    {
    	$dosen = [];

      if($request->has('q')){
          $search = $request->q;
          $dosen = Users::select("id", "name")
                        ->where('role_id', '=', 100)
                        ->where('fakultas', '=', Auth::user()->fakultas)
                    		->where('name', 'LIKE', "%$search%")
                    		->get();
      } else {
        $dosen = Users::where('role_id', '=', 100)->where('fakultas', '=', Auth::user()->fakultas)->limit(10)->get();
      }
      return response()->json($dosen);
    }

    public function selectDosen(Request $request)
    {
    	$dosen = [];

      if($request->has('q')){
          $search = $request->q;
          $dosen = Users::select("id", "name")
                        ->where('role_id', '=', 100)
                    		->where('name', 'LIKE', "%$search%")
                    		->get();
      } else {
          $dosen = Users::limit(10)->get();
      }
      return response()->json($dosen);
    }

}
