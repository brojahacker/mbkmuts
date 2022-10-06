@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Edit {{ $identity['title'] }}
    <small>{{ $identity['dosen']->name }}</small>
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
          <h3 class="box-title">{{ $identity['title'] }} {{ $identity['tahunajaran']->periode }} ({{ $identity['tahunajaran']->semester }})</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{ route($identity['route'].'.update', $identity['matakuliah']->id) }}" class="form-horizontal" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Pilih Mata Kuliah</label>
              <div class="col-sm-6">
                <select class="form-control" name="matakuliahs_id" id="matakuliahs_id" required>
                  <option value="">-</option>
                  @foreach ($identity['matakuliahsemua'] as $row)
                  <option {{ $identity['matakuliah']->matakuliahs_id == $row->id ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->nama_mk }} - {{ $row->kode_mk }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Pilih Kelas</label>
              <div class="col-sm-6">
                <select class="form-control" name="kelas_id" id="kelas_id" required>
                  <option value="">-</option>
                  @foreach ($identity['kelas'] as $row)
                  <option {{ $identity['matakuliah']->kelas_id == $row->id ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->nama_kelas }} ({{ $row->nama_prodi }})</option>
                  @endforeach
                </select>
                <input type="hidden" class="form-control" name="users_id" value="{{ $identity['users_id'] }}">
                <input type="hidden" class="form-control" name="tahunajarans_id" value="{{ $identity['tahunajarans_id'] }}">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Semester</label>
              <div class="col-sm-6">
                <select class="form-control" name="semester" required>
                  <option value="">-</option>
                  <option {{ $identity['matakuliah']->semester == '1' ? 'selected' : '' }} value="1">1</option>
                  <option {{ $identity['matakuliah']->semester == '2' ? 'selected' : '' }} value="2">2</option>
                  <option {{ $identity['matakuliah']->semester == '3' ? 'selected' : '' }} value="3">3</option>
                  <option {{ $identity['matakuliah']->semester == '4' ? 'selected' : '' }} value="4">4</option>
                  <option {{ $identity['matakuliah']->semester == '5' ? 'selected' : '' }} value="5">5</option>
                  <option {{ $identity['matakuliah']->semester == '6' ? 'selected' : '' }} value="6">6</option>
                  <option {{ $identity['matakuliah']->semester == '7' ? 'selected' : '' }} value="7">7</option>
                  <option {{ $identity['matakuliah']->semester == '8' ? 'selected' : '' }} value="8">8</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-6">
                <button type="submit" class="btn btn-primary" value="addNewData">Simpan
                </button>
                <a href="{{ url($identity['route'].'/'.$identity['users_id'].'/'.$identity['tahunajarans_id']) }}" class="btn btn-warning">Kembali</a>
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
  $('#matakuliahs_id').select2({
      placeholder: 'Pilih Mata Kuliah',
      ajax: {
          url: '/mk-search',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
              return {
                  results: $.map(data, function (item) {
                      return {
                        text: item.nama_mk + ' - ' + item.kode_mk,
                        // text: item.nama_mk,
                          id: item.id
                      }
                  })
              };
          },
          cache: true
      }
  });

  $('#kelas_id').select2({
      placeholder: 'Pilih Kelas',
      ajax: {
          url: '/kelas-search',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
              return {
                  results: $.map(data, function (item) {
                      return {
                        text: item.nama_kelas + ' (' + item.nama_prodi + ')',
                        // text: item.nama_mk,
                          id: item.id
                      }
                  })
              };
          },
          cache: true
      }
  });

});
</script>
@endsection
