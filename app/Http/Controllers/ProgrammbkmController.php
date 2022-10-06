<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategorimbkm;
use App\Models\Programmbkm;
use App\Models\Users;
use DataTables;
use Alert;

class ProgrammbkmController extends Controller
{
  public $title = "Program MBKM";
  public $route = "programmbkm";
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
      $data = Programmbkm::join('kategorimbkms', 'kategorimbkms.id', '=', 'programmbkms.kategorimbkms_id')
                   ->get(['programmbkms.*', 'kategorimbkms.nama_kategorimbkm']);
      // $data = Programmbkm::latest()->get();
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
    $kategorimbkm = Kategorimbkm::orderBy('id')->get();
    $identity = array(
      'title' => $this->title,
      'route' => $this->route
    );
    return view('admin.'.$this->route.'.create', compact('identity', 'kategorimbkm'));
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    $post = Programmbkm::create($request->all());
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
    $kategorimbkm = Kategorimbkm::orderBy('id')->get();
    $post = Programmbkm::findOrFail($id);
    $identity = array(
      'title' => $this->title,
      'route' => $this->route
    );
    return view('admin.'.$this->route.'.edit', compact('post', 'identity', 'kategorimbkm'));
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
    $post = Programmbkm::findOrFail($id);
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
    $com = Programmbkm::where('id', $request->id)->delete();
    return Response()->json($com);
  }


  public function selectProgrammbkm(Request $request)
  {
    $programmbkm = [];
    $kategorimbkms_id = $request->kategorimbkms_id;
    if($request->has('q')){
        $search = $request->q;
        $programmbkm = Programmbkm::select("id", "nama_programmbkm")
                      ->where('kategorimbkms_id', '=', $kategorimbkms_id)
                      ->where('nama_programmbkm', 'LIKE', "%$search%")
                      ->get();
    } else {
        $programmbkm = Programmbkm::where('kategorimbkms_id', $kategorimbkms_id)->limit(10)->get();
    }
    return response()->json($programmbkm);
  }
}
