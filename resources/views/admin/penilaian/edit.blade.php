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
              <label for="name" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="periode" value="{{ old('periode', $post->periode) }}" class="form-control @error('periode') is-invalid @enderror" placeholder="Periode" maxlength="50" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Semester</label>
              <div class="col-sm-8">
                <select class="form-control" name="semester" value="{{ old('semester', $post->semester) }}" class="form-control @error('semester') is-invalid @enderror" required>
                  <option value="">-</option>
                  <option {{ $post->semester == 'Ganjil' ? 'selected' : '' }} value="Ganjil">Ganjil</option>
                  <option {{ $post->semester == 'Genap' ? 'selected' : '' }} value="Genap">Genap</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Mulai</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" name="tanggal_mulai" value="{{ old('tanggal_mulai', $post->tanggal_mulai) }}" class="form-control @error('tanggal_mulai') is-invalid @enderror" placeholder="Enter author Name" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Selesai</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" name="tanggal_selesai" value="{{ old('tanggal_selesai', $post->tanggal_selesai) }}" class="form-control @error('tanggal_selesai') is-invalid @enderror" placeholder="Enter author Name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-8">
                <select class="form-control" name="status" value="{{ old('jabatan', $post->jabatan) }}" class="form-control @error('jabatan') is-invalid @enderror" required>
                  <option value="">-</option>
                  <option {{ $post->status == 1 ? 'selected' : '' }} value="1">Aktif</option>
                  <option {{ $post->status == 0 ? 'selected' : '' }} value="0">Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-8">
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
@endsection
