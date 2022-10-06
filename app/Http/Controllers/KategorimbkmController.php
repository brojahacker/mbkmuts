<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategorimbkm;
use App\Models\Users;
use DataTables;
use Alert;

class KategorimbkmController extends Controller
{
  public $title = "Kategori Program MBKM";
  public $route = "kategorimbkm";
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
      // $data = Fakultas::join('users', 'users.id', '=', 'fakultas.nama_dekan')
      //                 ->get(['fakultas.*', 'users.name as dekan']);
      $data = Kategorimbkm::latest()->get();
      return datatables()->of($data)
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
    $identity = array(
      'title' => $this->title,
      'route' => $this->route
    );
    return view('admin.'.$this->route.'.create', compact('identity'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $post = Kategorimbkm::create($request->all());
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
    $post = Kategorimbkm::findOrFail($id);
    $identity = array(
      'title' => $this->title,
      'route' => $this->route
    );
    return view('admin.'.$this->route.'.edit', compact('post', 'identity'));
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
    $post = Kategorimbkm::findOrFail($id);
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
    $com = Kategorimbkm::where('id', $request->id)->delete();
    return Response()->json($com);
  }

  public function selectKategorimbkm(Request $request)
  {
    $kategrimbkm = [];
    if($request->has('q')){
        $search = $request->q;
        $kategrimbkm = Kategorimbkm::select("id", "nama_kategrimbkm")
                      ->where('nama_kategrimbkm', 'LIKE', "%$search%")
                      ->get();
    } else {
        $kategrimbkm = Kategorimbkm::limit(10)->get();
    }
    return response()->json($kategrimbkm);
  }
}
