<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Daftarmbkm;
use App\Models\Tahunajaran;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Users;
use DataTables;
use Alert;
use Auth;

class AsistensiController extends Controller
{
  public $title = "Asistensi Mengajar Dikampus";
  public $route = "asistensi";
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(Request $request)
  {
    $identity = array(
      'title' => $this->title,
      'route' => $this->route,
      'users_id' => Auth::user()->id,
    );
    if($request->ajax()) {
      // $data = Fakultas::join('users', 'users.id', '=', 'fakultas.nama_dekan')
      //                 ->get(['fakultas.*', 'users.name as dekan']);
      $data = Daftarmbkm::join('tahunajarans', 'tahunajarans.id', '=', 'daftarmbkms.tahunajarans_id')
                        ->where('mbkms_id', 6)->where('users_id', Auth::user()->id)
                        ->get(['daftarmbkms.*', 'tahunajarans.periode', 'tahunajarans.semester']);
      return datatables()->of($data)
      ->addColumn('status', function($data) {
        if($data->status==0) {
          return "<span class='btn btn-warning btn-xs'>Belum dikirim</span>";
        } else if($data->status==1) {
          return "<span class='btn btn-info btn-xs'>Menunggu verifikasi</span>";
        } else if($data->status==2) {
          return "<span class='btn btn-success btn-xs'>Diterima</span>";
        } else {
          return "<span class='btn btn-danger btn-xs'>Ditolak</span>";
        }
      })
      // ->addColumn('action', 'admin.'.$this->route.'.action')
      ->addColumn('action', function($data) {
        return '
          <a href="'.route($this->route.'.show', $data->id).'" data-toggle="tooltip" data-original-title="Lihat" class="edit btn btn-info btn-xs edit">
          Lihat
          </a>
          <a href="'.route($this->route.'.edit', $data->id).'" data-toggle="tooltip" data-original-title="Edit" class="edit btn btn-success btn-xs edit">
          Edit
          </a>
          <a href="javascript:void(0)" data-id="'.$data->id.'" data-toggle="tooltip" data-original-title="Delete" class="delete btn btn-xs btn-danger">
          Delete
          </a>
        ';
      })
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
      'route' => $this->route,
      'tahunajaran' => Tahunajaran::orderBy('id')->get(),
      'user' => Users::findOrFail(Auth::user()->id),
      'fakultas' => Fakultas::findOrFail(Auth::user()->fakultas),
      'prodi' => Prodi::findOrFail(Auth::user()->prodi)
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
    // echo json_encode($request);exit;
    if ($file = $request->file('file1')) {
        $destinationPath = 'file-upload/';
        $profileImage = 'file1-'.date('YmdHis') . "." . $file->getClientOriginalExtension();
        $file->move($destinationPath, $profileImage);
        $file = "$profileImage";
    }
    if ($file2 = $request->file('file2')) {
        $destinationPath = 'file-upload/';
        $profileImage = 'file2-'.date('YmdHis') . "." . $file2->getClientOriginalExtension();
        $file2->move($destinationPath, $profileImage);
        $file2 = "$profileImage";
    }

    $post = Daftarmbkm::create([
        'tahunajarans_id' => $request->tahunajarans_id,
        'mbkms_id' => $request->mbkms_id,
        'users_id' => $request->users_id,
        'nama' => $request->nama,
        'nim' => $request->nim,
        'prodi' => $request->prodi,
        'fakultas' => $request->fakultas,
        'telepon' => $request->telepon,
        'alamat' => $request->alamat,
        'jenis_kelamin' => $request->jenis_kelamin,
        'ipk' => $request->ipk,
        'tanggal' => date('Y-m-d'),
        'file1' => $file,
        'file2' => $file2
    ]);

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
  public function kirim($id) {
    $post = Daftarmbkm::findOrFail($id);

    $post->update([
      'status' => 1
    ]);
    if($post) {
      Alert::success('Sukses', 'Berhasil kirim data');
      return redirect()->route($this->route.'.index');
    } else {
      Alert::error('Error', 'Gagal kirim data');
      return redirect()->back()->withInput();
    }
  }

  public function show($id)
  {
    $post = Daftarmbkm::findOrFail($id);
    $identity = array(
      'title' => $this->title,
      'route' => $this->route,
      'tahunajaran' => Tahunajaran::orderBy('id')->get(),
      'user' => Users::findOrFail(Auth::user()->id),
      'fakultas' => Fakultas::findOrFail(Auth::user()->fakultas),
      'prodi' => Prodi::findOrFail(Auth::user()->prodi)
    );
    return view('admin.'.$this->route.'.show', compact('post', 'identity'));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    $post = Daftarmbkm::findOrFail($id);
    $identity = array(
      'title' => $this->title,
      'route' => $this->route,
      'tahunajaran' => Tahunajaran::orderBy('id')->get(),
      'user' => Users::findOrFail(Auth::user()->id),
      'fakultas' => Fakultas::findOrFail(Auth::user()->fakultas),
      'prodi' => Prodi::findOrFail(Auth::user()->prodi)
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
    $input = $request->all();
    if ($file1 = $request->file('file1')) {
        $destinationPath = 'file-upload/';
        $profileImage = 'file1-'.date('YmdHis') . "." . $file1->getClientOriginalExtension();
        $file1->move($destinationPath, $profileImage);
        $input['file1'] = "$profileImage";
        // unlink('file_tte/'.request);
    }else{
        unset($input['file1']);
    }
    if ($file2 = $request->file('file2')) {
        $destinationPath = 'file_tte/';
        $profileImage = 'file2-'.date('YmdHis') . "." . $file2->getClientOriginalExtension();
        $file2->move($destinationPath, $profileImage);
        $input['file2'] = "$profileImage";
        // unlink('file_tte/'.request);
    }else{
        unset($input['file2']);
    }
    $post = Daftarmbkm::findOrFail($id);
    $post->update($input);
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
    $com = Daftarmbkm::where('id', $request->id)->delete();
    return Response()->json($com);
  }
}
