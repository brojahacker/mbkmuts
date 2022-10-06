@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
          <h3 class="box-title">{{ $identity['title'] }}</h3>
          <div class="box-tools pull-right">
            <a href="{{ route($identity['route'].'.create') }}" class="btn btn-primary"><i class="fa fa-plus"></i>
              Tambah Data
            </a>
          </div>

        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="datatable-crud" class="table table-hover">
            <thead>
              <tr>
                <th width="3%">No.</th>
                <th>Tahun Ajaran</th>
                <th>Semester</th>
                <th>Tanggal</th>
                <th>Status</th>
                <th width="13%">Aksi</th>
              </tr>
            </thead>
          </table>
        </div>
        <!-- /.box-body -->
      </div>
      <!-- /.box -->
    </div>
  </div>
</section>
<!-- /.content -->
<script type="text/javascript">
$(document).ready( function () {
  $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $('#datatable-crud').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route($identity['route'].'.index') }}",
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex' },
      { data: 'periode', name: 'periode' },
      { data: 'semester', name: 'semester' },
      { data: 'tanggal', name: 'tanggal' },
      { data: 'status', name: 'status' },
      { data: 'action', name: 'action', orderable: false},
    ],
    order: [[0, 'desc']]
  });

  $('body').on('click', '.delete', function () {
    if (confirm("Apakah anda yakin?") == true) {
      var id = $(this).data('id');
      // ajax
      $.ajax({
        type:"POST",
        url: "{{ url('delete-uts-mengajar') }}",
        data: { id: id},
        dataType: 'json',
        success: function(res){
          Swal.fire(
            'Sukses!',
            'Berhasil hapus data!',
            'success'
          )
          var oTable = $('#datatable-crud').dataTable();
          oTable.fnDraw(false);
        },
        error: function (data) {
          Swal.fire(
            'Gagal!',
            'Gagal hapus data!',
            'error'
          )
        }
      });
    }
  });
});
</script>
@endsection
