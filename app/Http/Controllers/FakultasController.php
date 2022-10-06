<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;
use App\Models\Users;
use DataTables;
use Alert;

class FakultasController extends Controller
{
    public $title = "Fakultas";
    public $route = "fakultas";
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
        $data = Fakultas::latest()->get();
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
      $post = Fakultas::create($request->all());
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
      $post = Fakultas::findOrFail($id);
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
      $post = Fakultas::findOrFail($id);
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
      $com = Fakultas::where('id', $request->id)->delete();
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

    public function selectFakultas(Request $request)
    {
    	$fakultas = [];
      if($request->has('q')){
          $search = $request->q;
          $fakultas = Fakultas::select("id", "nama_fakultas")
                    		->where('nama_fakultas', 'LIKE', "%$search%")
                    		->get();
      } else {
          $fakultas = Fakultas::limit(10)->get();
      }
      return response()->json($fakultas);
    }
}
