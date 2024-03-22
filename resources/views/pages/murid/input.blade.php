@extends('layouts/main')

<!-- DataTables -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/beranda">Beranda</a> / Murid / Input Murid</li>
@endsection

@section('content')

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <div class="row">
      <!-- left column -->
      <div class="col-lg-6">
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
          Data Murid Berhasil di Tambahkan.
        </div>
        @endif
        @error('nis')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
        @error('nama')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Halaman untuk menambahkan data murid</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form action="/input-murid-proses" method="post">
            @csrf
            <div class="card-body">
              <div class="form-group col-md-12">
                <label for="nis">NIS</label>
                <input type="text" name="nis" class="form-control @error('nis') is-invalid @enderror" id="nis" placeholder="Masukkan NIS" value="{{ old('nis') }}">
              </div>
              <div class="form-group col-md-12">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" id="nama" placeholder="Masukkan Nama" value="{{ old('nama') }}">
              </div>
              <div class="form-group col-md-12">
                <label>Kelas</label>
                @if($kelas->count() > 0)
                <select class="form-control" id="kelas" name="kelas">
                  @foreach ($kelas as $k)
                  @if(old('kelas') == $k->kelas)
                  <option value="{{ $k->kelas }}" selected>{{ $k->kelas }}</option>
                  @else
                  <option value="{{ $k->kelas }}">{{ $k->kelas }}</option>
                  @endif
                  @endforeach
                </select>
                @else
                <input type="text" class="form-control" placeholder="Harap masukkan data Kelas terlebih dahulu!" disabled>
                <span><a href="/kelas">Klik disini untuk menambah Kelas</a></span>
                @endif
              </div>
              <div class="form-group col-md-12">
                <label>Tahun</label>
                @if($tahun->count() > 0)
                <select class="form-control" id="tahun" name="tahun">
                  @foreach ($tahun as $t)
                  @if(old('tahun') == $t->tahun)
                  <option value="{{ $t->tahun }}" selected>{{ $t->tahun }}</option>
                  @else
                  <option value="{{ $t->tahun }}">{{ $t->tahun }}</option>
                  @endif
                  @endforeach
                </select>
                @else
                <input type="text" class="form-control" placeholder="Harap masukkan data Tahun terlebih dahulu!" disabled>
                <span><a href="/tahun">Klik disini untuk menambah Tahun</a></span>
                @endif
              </div>
              <div class="form-check">
                <input type="checkbox" class="form-check-input" id="verifikasi" required>
                <label class="form-check-label" for="verifikasi">Data di atas sudah benar</label>
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              @if($tahun->count() > 0 && $kelas->count() > 0)
              <button type="submit" class="btn btn-primary">Submit</button>
              @else
              <button type="" class="btn btn-primary" disabled>Submit</button>
              @endif
            </div>
          </form>
        </div>

        <!-- /.card -->
      </div>
      <div class="col-lg-6">
        @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
          Data Murid Berhasil di Tambahkan.
        </div>
        @endif
        @error('nis')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
        @error('nama')
        <div class="alert alert-danger" role="alert">
          {{ $message }}
        </div>
        @enderror
        <!-- general form elements -->
        <div class="card card-primary">
          <div class="card-header">
            <h3 class="card-title">Halaman untuk Upload Excel data murid</h3>
          </div>
          <!-- /.card-header -->
          <!-- form start -->
          <form id="uploadForm" action="{{ route('upload.excel') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
              <div class="form-group col-md-12">
                <label for="excelFile">Upload Excel</label>
                <input type="file" name="excelFile" class="form-control-file @error('excelFile') is-invalid @enderror" id="excelFile" accept=".xlsx, .xls">
                @error('excelFile')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <!-- /.card-body -->
            <div class="card-footer">
              <button type="button" class="btn btn-primary" onclick="submitForm()">Submit</button>
            </div>
          </form>

        </div>

        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
    <div class="row">
      <!-- left column -->

    </div>
  </div><!-- /.container-fluid -->
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<!-- Include axios -->
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>



<script>
  function submitForm() {
    let form = document.getElementById('uploadForm');
    let formData = new FormData(form);

    axios.post(form.action, formData)
      .then(response => {
        // Success
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Data imported successfully!',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        }).then(() => {
          window.location.href = "{{ url('input-murid') }}";
        });
      })
      .catch(error => {
        // Error
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Error importing data. ' + error.response.data.message,
          confirmButtonColor: '#d33',
          confirmButtonText: 'OK'
        });
      });
  }
</script>
<!-- /.content -->
<!-- Configure a few settings and attach camera -->

@endsection