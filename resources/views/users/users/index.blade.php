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
          <h3 class="box-title">{{ $identity['title'] }}</h3>

          <!-- <div class="box-tools">
            <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
              <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

              <div class="input-group-btn">
                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
              </div>
            </div>
          </div> -->
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="table-data" class="table table-hover">
            <thead>
              <tr>
                <th width="3%">No.</th>
                <th>Nama</th>
                <th>NIDN</th>
                <th>Fakultas</th>
                <th>Prodi</th>
                <th>Status</th>
                <th width="16%"></th>
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

  $('#table-data').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route($identity['route'].'.index') }}",
    columns: [
      { data: 'id', name: 'id' },
      // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
      // render: function (data, type, row, meta) {
      //   return meta.row + meta.settings._iDisplayStart + 1;
      // },
      { data: 'name', name: 'name' },
      { data: 'nidn', name: 'nidn' },
      { data: 'nama_fakultas', name: 'nama_fakultas' },
      { data: 'nama_prodi', name: 'nama_prodi' },
      { data: 'is_active', name: 'is_active' },
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
        url: "{{ url('delete-penilaian') }}",
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
