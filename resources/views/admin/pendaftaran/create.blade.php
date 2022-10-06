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
          <h3 class="box-title">Tambah Data</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{ route($identity['route'].'.store') }}" class="form-horizontal" method="POST">
            @csrf
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Periode</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" id="periode" name="periode" placeholder="Periode" maxlength="50" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Semester</label>
              <div class="col-sm-8">
                <select class="form-control" id="semester" name="semester" required>
                  <option value="">-</option>
                  <option value="Ganjil">Ganjil</option>
                  <option value="Genap">Genap</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Mulai</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" placeholder="Enter author Name" required>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label">Tanggal Selesai</label>
              <div class="col-sm-8">
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" placeholder="Enter author Name" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-8">
                <select class="form-control" id="status" name="status" required>
                  <option value="">-</option>
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-8">
                <button type="submit" class="btn btn-primary" id="btn-save" value="addNewData">Simpan
                </button>
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
