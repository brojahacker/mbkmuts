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
            <?php
              if(Auth::user()->role_id == 102) {
            ?>
            <?php
              } else {
            ?>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Fakultas</label>
              <div class="col-sm-6">
                <select class="form-control" name="fakultas_id" id="fakultas_id" required>
                  <option value="">-</option>
                  @foreach ($fakultas as $row)
                  <option {{ $post->fakultas_id == $row->id ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->nama_fakultas }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Program Studi</label>
              <div class="col-sm-6">
                <select class="form-control" name="prodis_id" id="prodis_id" required>
                  <option value="">-</option>
                  @foreach ($prodi as $row)
                  <option {{ $post->prodis_id == $row->id ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->nama_prodi }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <?php
              }
            ?>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Nama Kelas</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="nama_kelas"  value="{{ old('nama_kelas', $post->nama_kelas) }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Tahun Masuk/Angkatan</label>
              <div class="col-sm-6">
                <input type="number" class="form-control" name="angkatan"  value="{{ old('angkatan', $post->angkatan) }}" placeholder="">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Status</label>
              <div class="col-sm-6">
                <select class="form-control" name="status" required>
                  <option value="">-</option>
                  <option {{ $post->status == 1 ? 'selected' : '' }} value="1">Aktif</option>
                  <option {{ $post->status == 0 ? 'selected' : '' }} value="0">Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-4 control-label"></label>
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
