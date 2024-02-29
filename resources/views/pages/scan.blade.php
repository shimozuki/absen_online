@extends('layouts/main')

@section('breadcrumb')
<li class="breadcrumb-item"><a href="/beranda">Beranda</a> / Scan QR</li>
@endsection

@section('content')
<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <!-- /.col-md-6 -->
            <div class="col-lg-12">
                <!-- Pesan Berhasil / Error saat proses scan QR -->

                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">Menu Scan QR</h5>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Silahkan Scand ID card siswa untuk melakukan absen</p>
                        <form id="absensiForm" method="post">
                            @csrf
                            <div class="md-form mb-0">
                                <input type="text" id="nis" class="form-control validate" name="nis" placeholder="Scan ID Card Siswa" required>
                            </div>
                            <br>
                            <button type="button" id="submitAbsensi" class="btn btn-primary">Submit Absensi</button>
                            <a href="#" class="btn btn-warning">Perlu bantuan ?</a>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-lg-12">
                <!-- Pesan Berhasil / Error saat proses scan QR -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="m-0">Data Siswa</h5>
                    </div>
                    <div class="card-body">
                        <div class="card-body table-responsive p-0">
                            <table id="daftarTahun" class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>NIS</th>
                                        <th>Kelas</th>
                                        <th>Absen</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
$(document).ready(function () {
    $("#submitAbsensi").on("click", function () {
        var nis = $("#nis").val();

        $.ajax({
            type: "POST",
            url: "/scan-qr",
            data: {
                _token: "{{ csrf_token() }}",
                nis: nis
            },
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "Success!",
                        text: `{{ session('success') }}`
                    });
                    fetchData(); // Fetch data after successful submission
                } else if (response.error) {
                    Swal.fire({
                        icon: "error",
                        title: "Error!",
                        text: 'siswa telah melakukan absen'
                    });
                }
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.responseJSON.message;
            }
        });
    });

    function updateTable(data) {
        $('#daftarTahun tbody').empty();

        $.each(data, function (index, item) {
            $('#daftarTahun tbody').append(`
                <tr>
                    <td>${item.murid.nama}</td>
                    <td>${item.murid.nis}</td>
                    <td>${item.kelas.kelas}</td>
                    <td>${item.status === 1 ? '<span class="text-success">Masuk</span>' :
                          item.status === 2 ? '<span class="text-danger">Terlambat</span>' :
                          item.status === 3 ? '<span class="text-info">Pulang</span>' : ''}
                    </td>
                    <td>${item.hari}, ${item.tanggal} ${item.bulan} 2024</td>
                </tr>
            `);
        });
    }

    function fetchData() {
        $.ajax({
            type: 'GET',
            url: '/fetch-data',
            success: function (response) {
                updateTable(response);

                countResult(); // Pass rowCount to countResult
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            },
        });
    }
    function countResult() {
        $.ajax({
            url: '/countresult',
            method: 'GET',
            success: function (response) {
                console.log(response.status)
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message
                    });
                } else if (response.status === 'warning') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan',
                        text: response.message
                    });
                }
            },
        });
    }

    fetchData();
});
</script>



<!-- /.content -->
@endsection