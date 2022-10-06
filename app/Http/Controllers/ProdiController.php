<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\Users;
use DataTables;
use Alert;

class ProdiController extends Controller
{
    public $title = "Program Studi";
    public $route = "prodi";
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
        $data = Prodi::join('fakultas', 'fakultas.id', '=', 'prodis.fakultas_id')
                     ->get(['prodis.*', 'fakultas.nama_fakultas']);
        // $data = Prodi::latest()->get();
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
      $fakultas = Fakultas::orderBy('id')->get();
      $identity = array(
        'title' => $this->title,
        'route' => $this->route
      );
      return view('admin.'.$this->route.'.create', compact('identity', 'fakultas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $post = Prodi::create($request->all());
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
      $post = Prodi::findOrFail($id);
      $identity = array(
        'title' => $this->title,
        'route' => $this->route
      );
      return view('admin.'.$this->route.'.edit', compact('post', 'identity', 'fakultas'));
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
      $post = Prodi::findOrFail($id);
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
      $com = Prodi::where('id', $request->id)->delete();
      return Response()->json($com);
    }

    public function selectSearch(Request $request)
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

    public function selectProdi(Request $request)
    {
    	$prodi = [];
      $fakultas_id = $request->fakultas_id;
      if($request->has('q')){
          $search = $request->q;
          $prodi = Prodi::select("id", "nama_prodi")
                        ->where('fakultas_id', '=', $fakultas_id)
                    		->where('nama_prodi', 'LIKE', "%$search%")
                    		->get();
      } else {
          $prodi = Prodi::where('fakultas_id', $fakultas_id)->limit(10)->get();
      }
      return response()->json($prodi);
    }
}
