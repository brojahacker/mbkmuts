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
              <label for="name" class="col-sm-3 control-label">Fakultas</label>
              <div class="col-sm-8">
                <select class="form-control" name="fakultas_id" required>
                  <option value="">-</option>
                  @foreach ($fakultas as $row)
                  <option value="{{ $row->id }}">{{ $row->nama_fakultas }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Kode Program Studi</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="kode_prodi" placeholder="Kode Program Studi" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Nama Program Studi</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" name="nama_prodi" placeholder="Nama Program Studi" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Kaprodi</label>
              <div class="col-sm-8">
                <select class="form-control livesearch" name="nama_kaprodi">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Sekprdi</label>
              <div class="col-sm-8">
                <select class="form-control livesearch" name="nama_sekprodi">
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Status</label>
              <div class="col-sm-8">
                <select class="form-control" name="status" required>
                  <option value="">-</option>
                  <option value="1">Aktif</option>
                  <option value="0">Tidak Aktif</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-3 control-label"></label>
              <div class="col-sm-8">
                <button type="submit" class="btn btn-primary" value="addNewData">Simpan
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
<script type="text/javascript">
    $('.livesearch').select2({
        placeholder: 'Pilih',
        ajax: {
            url: '/prodi-autocomplete-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.name
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
@endsection
