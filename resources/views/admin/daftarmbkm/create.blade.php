@extends('layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Tambah {{ $identity['title'] }}
    <small>{{ $identity['user']->name }}</small>
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
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <form action="{{ route($identity['route'].'.store') }}" class="form-horizontal" method="POST" enctype="multipart/form-data">
            @csrf
            <?php
              // echo count($identity['tahunajaran']);
              // Use App\Models\Tahunajaran;
              // $data = Tahunajaran::where
            ?>

            <div class="form-group">
              <label for="name" class="col-sm-3 control-label">Pilih Tahun Ajaran</label>
              <div class="col-sm-6">
                <select class="form-control" name="tahunajarans_id" id="tahunajarans_id" required>
                  <!-- <option value="">-</option> -->
                  @foreach ($identity['tahunajaran'] as $row)
                  <option value="{{ $row->id }}">{{ $row->periode }} - {{ $row->semester }}</option>
                  @endforeach
                </select>
              </div>
            </div>


            @if (count($identity['tahunajaran']) > 0)
              @if ($identity['tahunajaran'][0]->pendaftaran === 1)
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Kategori Program</label>
                <div class="col-sm-6">
                  <select class="form-control" name="kategorimbkms_id" id="kategorimbkms" required>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Program MBKM</label>
                <div class="col-sm-6">
                  <select class="form-control" name="programmbkms_id" id="programmbkms_id" required>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Nama</label>
                <div class="col-sm-6">
                  <input type="hidden" class="form-control" name="mbkms_id" value="6" placeholder="" required>
                  <input type="hidden" class="form-control" name="users_id" value="{{ Auth::user()->id }}" placeholder="" required>
                  <input type="text" class="form-control" name="nama" value="{{ Auth::user()->name }}" placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">NIM</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="nim" value="{{ Auth::user()->nik }}" placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">IPK</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="ipk" placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Fakultas</label>
                <div class="col-sm-6">
                  <input type="hidden" class="form-control" name="fakultas" value="{{ Auth::user()->fakultas }}" placeholder="" required>
                  <input type="text" class="form-control" value="{{ $identity['fakultas']->nama_fakultas }}" placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Program Studi</label>
                <div class="col-sm-6">
                  <input type="hidden" class="form-control" name="prodi" value="{{ Auth::user()->prodi }}" placeholder="" required>
                  <input type="text" class="form-control" value="{{ $identity['prodi']->nama_prodi }}" placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Jenis Kelamin</label>
                <div class="col-sm-6">
                  <select class="form-control" name="jenis_kelamin" required>
                    <option value="">-</option>
                    <option {{ Auth::user()->kelamin == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                    <option {{ Auth::user()->kelamin == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Nomor Telepon/WA</label>
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="telepon" value="{{ Auth::user()->no_hp }}" placeholder="" required>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Alamat Asal</label>
                <div class="col-sm-6">
                  <textarea class="form-control" name="alamat" required>{{ Auth::user()->alamat }}</textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label" id="title_upload_1">Upload Transkrip Nilai</label>
                <label for="name" class="col-sm-3 control-label" id="title_upload_2" style="display: none">Upload SK Penetapan</label>
                <div class="col-sm-6">
                  <input type="file" class="form-control" name="file1" placeholder="" required>
                  (PDF, JPG, JPEG)
                </div>
              </div>
              <div class="form-group">
                <label for="name" class="col-sm-3 control-label">Upload Keterangan Bukti Pembayaran</label>
                <div class="col-sm-6">
                  <input type="file" class="form-control" name="file2" placeholder="" required>
                  Kwitansi Pembayaran dari Keuangan, Bukan Bukti Transfer (PDF, JPG, JPEG)
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label"></label>
                <div class="col-sm-6">
                  <button type="submit" class="btn btn-primary" value="addNewData">Simpan
                  </button>
                  <a href="{{ url($identity['route']) }}" class="btn btn-warning">Kembali</a>
                </div>
              </div>
              @else
              <div style="text-align: center;font-size: 16px;font-weight: bold;margin: 49px;">
                PERIODE PENDAFTARAN MBKM BELUM DIBUKA/SUDAH DITUTUP
              </div>
              @endif
            @else
            <div style="text-align: center;font-size: 16px;font-weight: bold;margin: 49px;">
              PERIODE PENDAFTARAN MBKM BELUM DIBUAT
            </div>
            @endif
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
  $('#kategorimbkms').select2({
      placeholder: 'Pilih Kategori',
      ajax: {
          url: '/kategorimbkm-search',
          dataType: 'json',
          delay: 250,
          processResults: function (data) {
              return {
                  results: $.map(data, function (item) {
                      return {
                          text: item.nama_kategorimbkm,
                          id: item.id
                      }
                  })
              };
          },
          cache: true
      }
  });

  //  Event on change select province:start
  $('#kategorimbkms').change(function() {
    var id = $('#kategorimbkms').val();
    if(id == 1) {
      $('#title_upload_1').css("display","block");
      $('#title_upload_2').css("display","none");
    } else {
      $('#title_upload_1').css("display","none");
      $('#title_upload_2').css("display","block");
    }
    // return alert(id);
     //clear select
    $('#programmbkms_id').empty();
     //set id
    let kategorimbkms_id = $(this).val();
    if (kategorimbkms_id) {
        $('#programmbkms_id').select2({
           allowClear: true,
           ajax: {
              url: "/programmbkm-search?kategorimbkms_id=" + kategorimbkms_id,
              dataType: 'json',
              delay: 250,
              processResults: function(data) {
                 return {
                    results: $.map(data, function(item) {
                       return {
                          text: item.nama_programmbkm,
                          id: item.id
                       }
                    })
                 };
              }
           }
        });
     } else {
        $('#programmbkms_id').empty();
     }
  });
  // $('#tahunajarans_id').click(function() {
  //
  //   <?php
  //     Use App\Models\Tahunajaran;
  //     $data = Tahunajaran::
  //   ?>
  // })

  //  Event on change select province:end
});
</script>
@endsection
