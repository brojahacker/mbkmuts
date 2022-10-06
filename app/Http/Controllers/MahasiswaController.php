<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use DataTables;
use Alert;
use Auth;

class MahasiswaController extends Controller
{
  public $title = "Mahasiswa";
  public $route = "mahasiswa";
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
                      ->where('role_id', '=', 101)
                      ->get(['users.*', 'prodis.nama_prodi', 'fakultas.nama_fakultas']);
        } else {
          $data = Users::join('prodis', 'prodis.id', 'users.prodi')
                      ->join('fakultas', 'fakultas.id', 'users.fakultas')
                      ->where('role_id', '=', 101)
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
}
