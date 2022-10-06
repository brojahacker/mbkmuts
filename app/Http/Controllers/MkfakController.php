<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Matakuliah;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Users;
use DataTables;
use Alert;
use Auth;

class MkfakController extends Controller
{
  public $title = "Mata Kuliah Fakultas";
  public $route = "mkfak";
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
      if(Auth::user()->role_id == 5) {
        // $data = Matakuliah::latest()->get();
        $data = Matakuliah::join('fakultas', 'fakultas.id', '=', 'matakuliahs.fakultas_id')
                          ->where('fakultas.id', Auth::user()->fakultas)
                          ->where('unit_penyelenggara', 2)
                          ->get(['matakuliahs.*', 'fakultas.nama_fakultas']);
      } else {
        $data = Matakuliah::join('fakultas', 'fakultas.id', '=', 'matakuliahs.fakultas_id')
                          ->where('unit_penyelenggara', 2)
                          ->get(['matakuliahs.*', 'fakultas.nama_fakultas']);
      }
      // $data = Matakuliah::latest()->get();
      return datatables()->of($data)
      ->addColumn('unit_penyelenggara', function($data) {
        if($data->unit_penyelenggara == 1) {
          $penyelenggara = "Program Studi";
        } else if($data->unit_penyelenggara == 2) {
          $penyelenggara = "Fakultas";
        } else {
          $penyelenggara = "Universitas";
        }
        return $penyelenggara;
      })
      ->addColumn('status', function($data) {
        return $data->status==1?"<span class='btn btn-primary btn-xs'>Aktif</span>":"<span class='btn btn-danger btn-xs'>Tidak Aktif</span>";
      })
      ->addColumn('action', 'admin.'.$this->route.'.action')
      ->rawColumns(['action', 'status'])
      ->addIndexColumn()
      ->make(true);
    }
    return view('admin.'.$this->route.'.index', compact('identity'));
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    // if(Auth::user()->role_id == 102) {
      // $pd = Auth::user()->prodi;
    //   $prodis = Prodi::where('nama_prodi', "'$pd'")->first();
    // }

    $fakultas = Fakultas::orderBy('id')->get();
    $prodi = Prodi::orderBy('id')->get();
    // echo json_encode($prodi);exit;
    $identity = array(
      'title' => $this->title,
      'route' => $this->route
    );
    return view('admin.'.$this->route.'.create', compact('identity', 'fakultas', 'prodi'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $post = Matakuliah::create($request->all());
    // Logsactivity::record(Auth::user(), 'Menambah data jabatan '.$request->jabatan, 'Proses tambah data jabatan');

    if ($post) {
      Alert::success('Sukses', 'Berhasil tambah data');
        return redirect()
            ->route($this->route.'.index');
    } else {
      Alert::error('Error', 'Gagal tambah data');
      // echo "Erwin";exit;
        return redirect()
            ->back()
            ->withInput();
    }
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
    $fakultas = Fakultas::orderBy('id')->get();
    $prodi = Prodi::orderBy('id')->get();
    $post = Matakuliah::findOrFail($id);
    if(Auth::user()->role_id == 5) {
      $pengampuh = Users::where('role_id', '=', 100)->where('fakultas', '=', Auth::user()->fakultas)->get();
    } else {
      $pengampuh = Users::where('role_id', '=', 100)->get();
    }
    $identity = array(
      'title' => $this->title,
      'route' => $this->route
    );
    return view('admin.'.$this->route.'.edit', compact('post', 'identity', 'fakultas', 'prodi', 'pengampuh'));
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
    $post = Matakuliah::findOrFail($id);
    $post->update($request->all());

    if($post) {
      Alert::success('Sukses', 'Berhasil ubah data');
      return redirect()->route($this->route.'.index');
    } else {
      Alert::error('Error', 'Gagal ubah data');
      return redirect()->back()->withInput();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy(Request $request)
  {
    $com = Matakuliah::where('id', $request->id)->delete();
    return Response()->json($com);
  }
}
