<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Kelas;
use App\Models\Users;
use Auth;
use DataTables;
use Alert;

class KelasController extends Controller
{
    public $title = "Kelas";
    public $route = "kelas";
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
           // $data = Matakuliah::latest()->get();
           $data = Kelas::join('fakultas', 'fakultas.id', '=', 'kelas.fakultas_id')
                             ->join('prodis', 'prodis.id', '=', 'kelas.prodis_id')
                             ->where('prodis.id', Auth::user()->prodi)
                             ->get(['kelas.*', 'fakultas.nama_fakultas', 'prodis.nama_prodi']);
         } else {
           $data = Kelas::join('fakultas', 'fakultas.id', '=', 'kelas.fakultas_id')
                             ->join('prodis', 'prodis.id', '=', 'kelas.prodis_id')
                             ->get(['kelas.*', 'fakultas.nama_fakultas', 'prodis.nama_prodi']);
         }
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
       $post = Kelas::create($request->all());
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
       $post = Kelas::findOrFail($id);
       $identity = array(
         'title' => $this->title,
         'route' => $this->route
       );
       return view('admin.'.$this->route.'.edit', compact('post', 'identity', 'fakultas', 'prodi'));
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
       $post = Kelas::findOrFail($id);
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
       $com = Kelas::where('id', $request->id)->delete();
       return Response()->json($com);
     }

     public function selectKelas(Request $request)
     {
     	$kelas = [];

       if($request->has('q')){
           $search = $request->q;
           $kelas = Kelas::join('prodis', 'prodis.id', '=', 'kelas.prodis_id')
                          ->where('prodis.nama_prodi', 'LIKE', "%$search%")
                          ->get(['kelas.*', 'prodis.nama_prodi']);
           // $kelas = Kelas::select("id", "nama_mk", "kode_mk")
           //           		->where('nama_mk', 'LIKE', "%$search%")
           //           		->get();
       } else {
         $kelas = Kelas::join('prodis', 'prodis.id', '=', 'kelas.prodis_id')->limit(10)
                        ->get(['kelas.*', 'prodis.nama_prodi']);
           // $kelas = Kelas::limit(10)->get();
       }
       return response()->json($kelas);
     }
}
