@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    {{ $identity['title'] }}
    <small>Data</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="{{ route('home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">{{ $identity['title'] }}</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">
  <!-- /.row -->
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-primary">
        <div class="box-header with-border">
          <h3 class="box-title">Edit Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{ route($identity['route'].'.update', $post->id) }}" class="form-horizontal" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Pilih Tahun Ajaran</label>
              <div class="col-sm-6">
                <select class="form-control" name="tahunajarans_id" required>
                  <option value="">-</option>
                  @foreach ($identity['tahunajaran'] as $row)
                  <option {{ $post->tahunajarans_id == $row->id ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->periode }} - {{ $row->semester }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Nama</label>
              <div class="col-sm-6">
                <input type="hidden" class="form-control" name="mbkms_id" value="3" placeholder="" required>
                <input type="hidden" class="form-control" name="users_id" value="{{ Auth::user()->id }}" placeholder="" required>
                <input type="text" class="form-control" name="nama" value="{{ Auth::user()->name }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">NIM</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="nim" value="{{ Auth::user()->nik }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">IPK</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="ipk" value="{{ old('ipk', $post->ipk) }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Fakultas</label>
              <div class="col-sm-6">
                <input type="hidden" class="form-control" name="fakultas" value="{{ Auth::user()->fakultas }}" placeholder="" required>
                <input type="text" class="form-control" value="{{ $identity['fakultas']->nama_fakultas }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Program Studi</label>
              <div class="col-sm-6">
                <input type="hidden" class="form-control" name="prodi" value="{{ Auth::user()->prodi }}" placeholder="" required>
                <input type="text" class="form-control" value="{{ $identity['prodi']->nama_prodi }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Jenis Kelamin</label>
              <div class="col-sm-6">
                <select class="form-control" name="jenis_kelamin" required>
                  <option value="">-</option>
                  <option {{ Auth::user()->kelamin == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                  <option {{ Auth::user()->kelamin == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Nomor Telepon/WA</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="telepon" value="{{ Auth::user()->no_hp }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Alamat Asal</label>
              <div class="col-sm-6">
                <textarea class="form-control" name="alamat" required>{{ Auth::user()->alamat }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Upload Transkrip Nilai</label>
              <div class="col-sm-4">
                <input type="file" class="form-control" name="file1" placeholder="">
                (PDF, JPG, JPEG) <br>
                Kosongkan jika file tidak ingin diubah
              </div>
              <div class="col-sm-2">
                <a href="/file-upload/{{ $post->file1 }}" class="btn btn-primary" target="_blank">Lihat File Surat</a>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Upload Keterangan Bukti Pembayaran</label>
              <div class="col-sm-4">
                <input type="file" class="form-control" name="file2" placeholder="">
                Kwitansi Pembayaran dari Keuangan, Bukan Bukti Transfer (PDF, JPG, JPEG) <br>
                Kosongkan jika file tidak ingin diubah
              </div>
              <div class="col-md-2">
                <a href="/file-upload/{{ $post->file2 }}" class="btn btn-primary" target="_blank">Lihat File Surat</a>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-6">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewData">Simpan</button>
                <a href="{{ route($identity['route'].'.index') }}" class="btn btn-warning">Kembali</a>
              </div>
            </div>
          </form>

        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<script type="text/javascript">
$(document).ready(function() {
  $('#fakultas_id').select2({
      placeholder: 'Pilih Fakultas',
      ajax: {
          url: '/fakultas-search',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
              return {
                  results: $.map(data, function (item) {
                      return {
                          text: item.nama_fakultas,
                          id: item.id
                      }
                  })
              };
          },
          cache: true
      }
  });

  //  Event on change select province:start
  $('#fakultas_id').change(function() {
     //clear select
     $('#prodis_id').empty();
     //set id
     let fakultas_id = $(this).val();
     if (fakultas_id) {
        $('#prodis_id').select2({
           allowClear: true,
           ajax: {
              url: "/prodi-search?fakultas_id=" + fakultas_id,
              dataType: 'json',
              delay: 250,
              processResults: function(data) {
                 return {
                    results: $.map(data, function(item) {
                       return {
                          text: item.nama_prodi,
                          id: item.id
                       }
                    })
                 };
              }
           }
        });
     } else {
        $('#prodis_id').empty();
     }
  });
  //  Event on change select province:end
});
</script>
@endsection
