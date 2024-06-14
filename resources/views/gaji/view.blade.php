@extends('layoutbootstrap')

@section('konten')
    <!--  Main wrapper -->
    <div class="body-wrapper">
        <!--  Header Start -->
        <header class="app-header">
            <nav class="navbar navbar-expand-lg navbar-light">
                <ul class="navbar-nav">
                    <li class="nav-item d-block d-xl-none">
                        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
                            <i class="ti ti-menu-2"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
                            <i class="ti ti-bell-ringing"></i>
                            <div class="notification bg-primary rounded-circle"></div>
                        </a>
                    </li>
                </ul>
                <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
                    <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
                        <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank"
                            class="btn btn-warning">Happy Angeliani</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/logos/wellgrow.png') }}" alt="" width="35"
                                    height="35" class="rounded-circle">
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
                                <div class="message-body">
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-user fs-6"></i>
                                        <p class="mb-0 fs-3">My Profile</p>
                                    </a>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-mail fs-6"></i>
                                        <p class="mb-0 fs-3">My Account</p>
                                    </a>
                                    <a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
                                        <i class="ti ti-list-check fs-6"></i>
                                        <p class="mb-0 fs-3">My Task</p>
                                    </a>
                                    <a href="./authentication-login.html"
                                        class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--  Header End -->
        <div class="container-fluid">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5 class="card-title fw-semibold mb-4">Penggajian</h5>
                                <div class="card">

                                    <!-- Card Header - Dropdown -->
                                    <div
                                        class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Master Data Penggajian</h6>

                                        <!-- Tombol Tambah Data -->
                                        <a href="{{ url('/gaji/create') }}" class="btn btn-primary btn-icon-split btn-sm">
                                            <span class="icon text-white-50">
                                                <i class="ti ti-plus"></i>
                                            </span>
                                            <span class="text">Tambah Data</span>
                                        </a>
                                        <!-- Akghir Tombol Tambah Data -->

                                    </div>

                                    <div class="card-body">
                                        <!-- Awal Dari Tabel -->
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%"
                                                cellspacing="0">
                                                <thead class="thead-dark">
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Nama Pegawai</th>
                                                        <th>Jabatan Pegawai</th>
                                                        <th>Tgl Masuk</th>
                                                        <th>Status Kehadiran</th>
                                                        <th>Keterangan</th>
                                                        <th>Upah per/Jam</th>
                                                        <th>Jam Kerja</th>
                                                        <th>Total Upah</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tfoot class="thead-dark">
                                                    <tr>
                                                        <th>Kode</th>
                                                        <th>Nama Pegawai</th>
                                                        <th>Jabatan Pegawai</th>
                                                        <th>Tgl Masuk</th>
                                                        <th>Status Kehadiran</th>
                                                        <th>Keterangan</th>
                                                        <th>Upah per/Jam</th>
                                                        <th>Jam Kerja</th>
                                                        <th>Total Upah</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                    @foreach ($gaji as $p)
                                                        <tr>
                                                            <td>{{ $p->pegawai->kode_pegawai }}</td>
                                                            <td>{{ $p->pegawai->nama_pegawai }}</td>
                                                            <td>{{ $p->pegawai->jabatan }}</td>
                                                            <td>{{ $p->created_at }}</td>
                                                            <td><span class="badge 
                                                                @if($p->status_kehadiran === "alpa")
                                                                    text-bg-danger
                                                                @elseif($p->status_kehadiran === "hadir")
                                                                    text-bg-success
                                                                @elseif($p->status_kehadiran === "sakit")
                                                                    text-bg-warning
                                                                @endif
                                                                ">{{ $p->status_kehadiran }}</span></td>
                                                            <td>{{ $p->keterangan }}</td>
                                                            <td>Rp. {{ number_format($p->perjam, 0, ',', '.') }}</td>
                                                            <td>{{ $p->jam_kerja }}</td>
                                                            <td>Rp.
                                                                {{ number_format($p->perjam * $p->jam_kerja, 0, ',', '.') }}
                                                            </td>
                                                            <td>
                                                                <a href="{{ route('gaji.edit', $p->id) }}"
                                                                    class="btn btn-success btn-icon-split btn-sm">
                                                                    <span class="icon text-white-50">
                                                                        <i class="ti ti-check"></i>
                                                                    </span>
                                                                    <span class="text">Ubah</span>
                                                                </a>

                                                                <a href="#"
                                                                    onclick="deleteConfirm(this); return true;"
                                                                    nama_pegawai="{{ $p->pegawai->nama_pegawai }}"
                                                                    data-id="{{ $p->id }}"
                                                                    class="btn btn-danger btn-icon-split btn-sm">
                                                                    <span class="icon text-white-50">
                                                                        <i class="ti ti-minus"></i>
                                                                    </span>
                                                                    <span class="text">Hapus</span>
                                                                </a>

                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <!-- Akhir Dari Tabel -->
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


            <script>
                function deleteConfirm(e) {
                    var tomboldelete = document.getElementById('btn-delete')
                    id = e.getAttribute('data-id');
                    nama = e.getAttribute('nama_pegawai');

                    // const str = 'Hello' + id + 'World';
                    var url3 = "{{ url('gaji/destroy/') }}";
                    var url4 = url3.concat("/", id);
                    // console.log(url4);

                    // console.log(id);
                    // var url = "{{ url('pegawai/destroy/"+id+"') }}";

                    // url = JSON.parse(rul.replace(/"/g,'"'));
                    tomboldelete.setAttribute("href", url4); //akan meload kontroller delete

                    var pesan = "Data dengan nama <b>"
                    var pesan2 = " </b>akan dihapus"
                    var res = nama;
                    document.getElementById("xid").innerHTML = pesan.concat(res, pesan2);

                    var myModal = new bootstrap.Modal(document.getElementById('deleteModal'), {
                        keyboard: false
                    });

                    myModal.show();

                }
            </script>

            <!-- Logout Delete Confirmation-->
            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                            {{-- <button class="close" type="button" data-bs-dismiss="modal" aria-label="Close">
                                x
                            </button> --}}
                        </div>
                        <div class="modal-body" id="xid"></div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                            <a id="btn-delete" class="btn btn-danger" href="#">Hapus</a>

                        </div>
                    </div>
                </div>
            </div>
        @endsection
