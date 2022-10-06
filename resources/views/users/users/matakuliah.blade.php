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
          <h3 class="box-title">Mata Kuliah</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="myTable" class="table table-hover">
            <thead>
              <tr>
                <th width="3%">No.</th>
                <th width="30%">Tahun Ajaran</th>
                <th>Semester</th>
                <th width="3%"></th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @forelse ($posts as $post)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $post->periode }}</td>
                <td>{{ $post->semester }}</td>
                <td>
                  <a href="{{ url('dosenmk/'.$identity['users_id'].'/'.$post->id ) }}" class="btn btn-xs btn-primary">Lihat</a>
                </td>
              </tr>
              @empty
              <tr>
                  <td class="text-center text-mute" colspan="7">Data post tidak tersedia</td>
              </tr>
              @endforelse
            </tbody>
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
    $('#myTable').DataTable();
} );
// $(document).ready( function () {
//   $.ajaxSetup({
//     headers: {
//     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//     }
//   });
//
//   $('#table-data').DataTable({
//     processing: true,
//     serverSide: true,
//     ajax: "{{ route($identity['route'].'.matakuliah', $identity['users_id']) }}",
//     columns: [
//       // { data: 'id', name: 'id' },
//       { data: 'DT_RowIndex', name: 'DT_RowIndex' },
//       // render: function (data, type, row, meta) {
//       //   return meta.row + meta.settings._iDisplayStart + 1;
//       // },
//       { data: 'periode', name: 'periode' },
//       { data: 'semester', name: 'semester' },
//       { data: 'action', name: 'action', orderable: false},
//     ],
//     order: [[0, 'desc']]
//   });
// });
</script>
@endsection
