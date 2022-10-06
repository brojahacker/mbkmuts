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
              if(Auth::user()->role_id == 5) {
            ?>
            <input type="hidden" class="form-control" name="fakultas_id" value="<?php echo Auth::user()->fakultas; ?>">
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
            </div>            <!-- <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Program Studi</label>
              <div class="col-sm-6">
                <select class="form-control" name="prodis_id" id="prodis_id" required>
                </select>
              </div>
            </div> -->
            <?php
              }
            ?>

            <!-- <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Program Studi</label>
              <div class="col-sm-6">
                <select class="form-control" name="prodis_id" id="prodis_id" required>
                  <option value="">-</option>
                  @foreach ($prodi as $row)
                  <option {{ $post->prodis_id == $row->id ? 'selected' : '' }} value="{{ $row->id }}">{{ $row->nama_prodi }}</option>
                  @endforeach
                </select>
              </div>
            </div> -->
            <!-- <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Semester</label>
              <div class="col-sm-6">
                <select class="form-control" name="semester" required>
                  <option value="">-</option>
                  <option {{ $post->semester == 'Satu' ? 'selected' : '' }} value="Satu">Satu</option>
                  <option {{ $post->semester == 'Dua' ? 'selected' : '' }} value="Dua">Dua</option>
                  <option {{ $post->semester == 'Tiga' ? 'selected' : '' }} value="Tiga">Tiga</option>
                  <option {{ $post->semester == 'Empat' ? 'selected' : '' }} value="Empat">Empat</option>
                  <option {{ $post->semester == 'Lima' ? 'selected' : '' }} value="Lima">Lima</option>
                  <option {{ $post->semester == 'Enam' ? 'selected' : '' }} value="Enam">Enam</option>
                  <option {{ $post->semester == 'Tujuh' ? 'selected' : '' }} value="Tujuh">Tujuh</option>
                  <option {{ $post->semester == 'Delapan' ? 'selected' : '' }} value="Delapan">Delapan</option>
                </select>
              </div>
            </div> -->
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Kode Mata Kuliah</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="kode_mk"  value="{{ old('kode_mk', $post->kode_mk) }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Nama Mata Kuliah</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="nama_mk"  value="{{ old('nama_mk', $post->nama_mk) }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Dosen Pengampuh</label>
              <div class="col-sm-6">
                <select class="form-control livesearch" name="dosen_pengampuh">
                  <option value="">-</option>
                  @foreach ($pengampuh as $row)
                  <option {{ $post->dosen_pengampuh == $row->name ? 'selected' : '' }} value="{{ $row->name }}">{{ $row->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <!-- <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Mata Kuliah Kompetensi</label>
              <div class="col-sm-6">
                <select class="form-control" name="mk_kompetensi">
                  <option value="">-</option>
                  <option {{ $post->mk_kompetensi == 1 ? 'selected' : '' }} value="1">Ya</option>
                  <option {{ $post->mk_kompetensi == 0 ? 'selected' : '' }} value="0">Tidak</option>
                </select>
              </div>
            </div> -->
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Kuliah/Responsi/Tutorial (Bobot Kredit SKS)</label>
              <div class="col-sm-6">
                <input type="number" class="form-control" name="bobot_kuliah"  value="{{ old('bobot_kuliah', $post->bobot_kuliah) }}" placeholder="" required>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Seminar (Bobot Kredit SKS)</label>
              <div class="col-sm-6">
                <input type="number" class="form-control" name="bobot_seminar"  value="{{ old('bobot_seminar', $post->bobot_seminar) }}" placeholder="">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Praktikum/Praktik/Praktik Lapangan (Bobot Kredit SKS)</label>
              <div class="col-sm-6">
                <input type="number" class="form-control" name="bobot_praktikum"  value="{{ old('bobot_praktikum', $post->bobot_praktikum) }}" placeholder="">
              </div>
            </div>
            <!-- <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Konversi Kredit ke Jam</label>
              <div class="col-sm-6">
                <input type="number" class="form-control" name="konveksi_kredit_kejam"  value="{{ old('konveksi_kredit_kejam', $post->konveksi_kredit_kejam) }}" placeholder="">
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Sikap (Capaian Pembelajaran)</label>
              <div class="col-sm-6">
                <select class="form-control" name="sikap">
                  <option value="">-</option>
                  <option {{ $post->sikap == 1 ? 'selected' : '' }} value="1">Ya</option>
                  <option {{ $post->sikap == 0 ? 'selected' : '' }} value="0">Tidak</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Pengetahuan (Capaian Pembelajaran)</label>
              <div class="col-sm-6">
                <select class="form-control" name="pengetahuan">
                  <option value="">-</option>
                  <option {{ $post->pengetahuan == 1 ? 'selected' : '' }} value="1">Ya</option>
                  <option {{ $post->pengetahuan == 0 ? 'selected' : '' }} value="0">Tidak</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Keterampilan Umum (Capaian Pembelajaran)</label>
              <div class="col-sm-6">
                <select class="form-control" name="keterampilan_umum">
                  <option value="">-</option>
                  <option {{ $post->keterampilan_umum == 1 ? 'selected' : '' }} value="1">Ya</option>
                  <option {{ $post->keterampilan_umum == 0 ? 'selected' : '' }} value="0">Tidak</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Keterampilan Khusus (Capaian Pembelajaran)</label>
              <div class="col-sm-6">
                <select class="form-control" name="keterampilan_khusus">
                  <option value="">-</option>
                  <option {{ $post->keterampilan_khusus == 1 ? 'selected' : '' }} value="1">Ya</option>
                  <option {{ $post->keterampilan_khusus == 0 ? 'selected' : '' }} value="0">Tidak</option>
                </select>
              </div>
            </div>
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Dokumen Rencana Pembelajaran</label>
              <div class="col-sm-6">
                <input type="text" class="form-control" name="dokumen_rencana_pembelajaran"  value="{{ old('dokumen_rencana_pembelajaran', $post->dokumen_rencana_pembelajaran) }}" placeholder="">
              </div>
            </div> -->
            <div class="form-group">
              <label for="name" class="col-sm-4 control-label">Unit Peneyelanggara</label>
              <div class="col-sm-6">
                <select class="form-control" name="unit_penyelenggara" required>
                  <option value="">-</option>
                  <!-- <option {{ $post->unit_penyelenggara == '1' ? 'selected' : '' }} value="1">Program Studi</option> -->
                  <option {{ $post->unit_penyelenggara == '2' ? 'selected' : '' }} value="2">Fakultas</option>
                  <!-- <option {{ $post->unit_penyelenggara == '3' ? 'selected' : '' }} value="3">Universitas</option> -->
                </select>
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
<script type="text/javascript">
    $('.livesearch').select2({
        placeholder: 'Pilih Dosen Pengampuh',
        ajax: {
            @if(Auth::user()->role_id == 5)
            url: '/dosen-search-fakultas',
            @else
            url: '/dosen-search-universitas',
            @endif
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
