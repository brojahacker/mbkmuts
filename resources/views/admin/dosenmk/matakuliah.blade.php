@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    {{ $identity['title'] }}
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
          <div class="box-tools pull-right">
            <a href="{{ url($identity['route'].'/tambah/'.$identity['users_id'].'/'.$identity['tahunajarans_id'] ) }}" class="btn btn-primary"><i class="fa fa-plus"></i>
              Tambah Data
            </a>
          </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body table-responsive">
          <table id="myTable" class="table table-hover">
            <thead>
              <tr>
                <th width="3%">No.</th>
                <th>Kelas</th>
                <th>Kode MK</th>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th width="10%"></th>
              </tr>
            </thead>
            <tbody>
              @php $no = 1; @endphp
              @forelse ($posts as $post)
              <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $post->nama_kelas }}</td>
                <td>{{ $post->kode_mk }}</td>
                <td>{{ $post->nama_mk }}</td>
                <td>{{ $post->bobot_kuliah }}</td>
                <td>{{ $post->semester }}</td>
                <td>
                  <a href="{{ url($identity['route'].'/edit/'.$identity['users_id'].'/'.$identity['tahunajarans_id'].'/'.$post->id ) }}" class="btn btn-xs btn-primary">Edit</a>
                  <a href="{{ url($identity['route'].'/hapus/'.$identity['users_id'].'/'.$identity['tahunajarans_id'].'/'.$post->id ) }}" onclick="confirm('Apakah Anda Yakin ?')" class="btn btn-xs btn-danger">Hapus</a>
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
</script>
@endsection
