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
          <form action="{{ route($identity['route'].'.update_periode', $post->id) }}" class="form-horizontal" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" disabled name="periode" value="{{ old('periode', $post->periode) }}" class="form-control @error('periode') is-invalid @enderror" placeholder="Periode" maxlength="50" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Semester</label>
              <div class="col-sm-8">
                <select class="form-control" name="semester" disabled value="{{ old('semester', $post->semester) }}" class="form-control @error('semester') is-invalid @enderror" required>
                  <option value="">-</option>
                  <option {{ $post->semester == 'Ganjil' ? 'selected' : '' }} value="Ganjil">Ganjil</option>
                  <option {{ $post->semester == 'Genap' ? 'selected' : '' }} value="Genap">Genap</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Pendaftaran</label>
              <div class="col-sm-8">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-info {{ $post->pendaftaran==1?'active':''; }}">
                    <input type="radio" name="pendaftaran" value="1" autocomplete="off"> Buka
                  </label>
                  <label class="btn btn-info {{ $post->pendaftaran==0?'active':''; }}">
                    <input type="radio" name="pendaftaran" value="0" autocomplete="off"> Tutup
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">KRS</label>
              <div class="col-sm-8">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-info {{ $post->krs==1?'active':''; }}">
                    <input type="radio" name="krs" value="1" autocomplete="off"> Buka
                  </label>
                  <label class="btn btn-info {{ $post->krs==0?'active':''; }}">
                    <input type="radio" name="krs" value="0" autocomplete="off"> Tutup
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Penilaian</label>
              <div class="col-sm-8">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                  <label class="btn btn-info {{ $post->penilaian==1?'active':''; }}">
                    <input type="radio" name="penilaian" value="1" autocomplete="off"> Buka
                  </label>
                  <label class="btn btn-info {{ $post->penilaian==0?'active':''; }}">
                    <input type="radio" name="penilaian" value="0" autocomplete="off"> Tutup
                  </label>
                </div>
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
