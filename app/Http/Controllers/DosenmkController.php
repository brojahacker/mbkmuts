<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosenmk;
use App\Models\Fakultas;
use App\Models\Matakuliah;
use App\Models\Kelas;
use App\Models\Tahunajaran;
use App\Models\Users;
use DataTables;
use Alert;
use Auth;

class DosenmkController extends Controller
{
    public $title = "Mata Kuliah";
    public $route = "dosenmk";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function matakuliah($users_id, $tahunajarans_id) {
      $posts = Dosenmk::join('users', 'users.id', '=', 'dosenmks.users_id')
                      ->join('matakuliahs', 'matakuliahs.id', '=', 'dosenmks.matakuliahs_id')
                      ->join('kelas', 'kelas.id', '=', 'dosenmks.kelas_id')
                      ->join('tahunajarans', 'tahunajarans.id', '=', 'dosenmks.tahunajarans_id')
                      ->where('users.id', $users_id)
                      ->where('tahunajarans.id', $tahunajarans_id)
                      ->get(['dosenmks.*', 'matakuliahs.nama_mk', 'matakuliahs.kode_mk', 'matakuliahs.bobot_kuliah', 'kelas.nama_kelas', 'tahunajarans.periode']);
      // echo $users_id;exit;
      $identity = array(
        'title' => $this->title,
        'route' => $this->route,
        'users_id' => $users_id,
        'tahunajarans_id' => $tahunajarans_id,
        'tahunajaran' => Tahunajaran::findOrFail($tahunajarans_id),
        'dosen' => Users::findOrFail($users_id)
      );
      return view('admin.'.$this->route.'.matakuliah', compact('posts', 'identity'));
    }

    public function tambah($users_id, $tahunajarans_id) {
      $prodi = Users::findOrFail($users_id);
      // echo $prodi->prodi;exit;
      $identity = array(
        'title' => $this->title,
        'route' => $this->route,
        'users_id' => $users_id,
        'tahunajarans_id' => $tahunajarans_id,
        'tahunajaran' => Tahunajaran::findOrFail($tahunajarans_id),
        'dosen' => Users::findOrFail($users_id),
        'kelas' => Kelas::join('prodis', 'prodis.id', '=', 'kelas.prodis_id')->get(['kelas.*', 'prodis.nama_prodi'])
      );
      return view('admin.'.$this->route.'.create', compact('identity'));
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
      $post = Dosenmk::create($request->all());

      if ($post) {
        Alert::success('Sukses', 'Berhasil tambah data');
          return redirect($this->route.'/'.$request->users_id.'/'.$request->tahunajarans_id);
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
    public function edit($users_id, $tahunajarans_id, $id)
    {
      $prodi = Users::findOrFail($users_id);
      // echo $prodi->prodi;exit;
      $identity = array(
        'title' => $this->title,
        'route' => $this->route,
        'users_id' => $users_id,
        'tahunajarans_id' => $tahunajarans_id,
        'tahunajaran' => Tahunajaran::findOrFail($tahunajarans_id),
        'dosen' => Users::findOrFail($users_id),
        'matakuliah' => Dosenmk::findOrFail($id),
        'matakuliahsemua' => Matakuliah::orderBy('id')->get(),
        'kelas' => Kelas::join('prodis', 'prodis.id', '=', 'kelas.prodis_id')->get(['kelas.*', 'prodis.nama_prodi'])
      );
      return view('admin.'.$this->route.'.edit', compact('identity'));
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
      $post = Dosenmk::findOrFail($id);
      $post->update($request->all());

      if($post) {
        Alert::success('Sukses', 'Berhasil ubah data');
        return redirect($this->route.'/'.$request->users_id.'/'.$request->tahunajarans_id);
      } else {
        Alert::error('Error', 'Gagal ubah data');
        return redirect()->back()->withInput();
      }
    }

    public function hapus($users_id, $tahunajarans_id, $id) {
      $post = Dosenmk::findOrFail($id);
      $post->delete();

      if($post) {
        Alert::success('Sukses', 'Berhasil hapus data');
        return redirect($this->route.'/'.$users_id.'/'.$tahunajarans_id);
      } else {
        Alert::error('Error', 'Gagal hapus data');
        return redirect()
            ->route($this->route.'.index');
      }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
