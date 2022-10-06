<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tahunajaran;
use DataTables;
use Alert;

class TahunajaranController extends Controller
{
  public $title = "Periode Tahun Ajaran";
  public $route = "tahunajaran";

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
      $data = Tahunajaran::get();
      return datatables()->of($data)
      ->addColumn('status', function($data) {
        return $data->status==1?"<span class='btn btn-primary btn-xs'>Aktif</span>":"<span class='btn btn-danger btn-xs'>Tidak Aktif</span>";
      })
      ->addColumn('periodes', function($data) {
        if($data->pendaftaran == 1) {
          $pendaftaran = "success";
        } else {
          $pendaftaran = "warning";
        }
        if($data->krs == 1) {
          $krs = "success";
        } else {
          $krs = "warning";
        }
        if($data->penilaian == 1) {
          $penilaian = "success";
        } else {
          $penilaian = "warning";
        }
        return '
          <span class="edit btn btn-'.$pendaftaran.' btn-xs edit">
            Pendaftaran
          </span>
          <span class="edit btn btn-'.$krs.' btn-xs edit">
            KRS
          </span>
          <span class="edit btn btn-'.$penilaian.' btn-xs edit">
            Penilaian
          </span>
        ';
      })
      ->addColumn('action', 'admin.'.$this->route.'.action')
      ->rawColumns(['action', 'periodes', 'status'])
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
    $post = Tahunajaran::create($request->all());
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
  // public function pendaftaran($id) {
  //  echo $id;
  // }
  //
  // public function krs($id) {
  //  echo $id;
  // }
  //
  // public function penilaian($id) {
  //  echo $id;
  // }

  public function periode($id) {
    $post = Tahunajaran::findOrFail($id);
    $identity = array(
      'title' => $this->title,
      'route' => $this->route
    );
    return view('admin.'.$this->route.'.periode', compact('post', 'identity'));
  }

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
    $post = Tahunajaran::findOrFail($id);
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
    $post = Tahunajaran::findOrFail($id);
    $post->update([
      'periode' => $request->periode,
      'semester' => $request->semester,
      'tanggal_mulai' => $request->tanggal_mulai,
      'tanggal_selesai' => $request->tanggal_selesai,
      'status' => $request->status
    ]);

    if($post) {
      Alert::success('Sukses', 'Berhasil ubah data');
      return redirect()->route($this->route.'.index');
    } else {
      Alert::error('Error', 'Gagal ubah data');
      return redirect()->back()->withInput();
    }
  }

  public function update_periode(Request $request, $id)
  {
    // dd($request->all());
    $post = Tahunajaran::findOrFail($id);
    $post->update([
      'pendaftaran' => $request->pendaftaran,
      'krs' => $request->krs,
      'penilaian' => $request->penilaian
    ]);

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
    $com = Tahunajaran::where('id', $request->id)->delete();
    return Response()->json($com);
  }
}
