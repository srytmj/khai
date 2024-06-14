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
                            class="btn btn-primary">Download Free</a>
                        <li class="nav-item dropdown">
                            <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="{{ asset('images/profile/user-1.jpg') }}" alt="" width="35"
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
                                    <a href="{{ url('logout') }}"
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
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title fw-semibold mb-4">Data Penggajian</h5>

                    <!-- Display Error jika ada error -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Akhir Display Error -->

                    <!-- Awal Dari Input Form -->
                    <form action="/gaji" method="post">
                        @csrf

                        <!-- Radio Button untuk Status Kehadiran -->
                        <div class="mb-3">
                            <label class="form-label">Status Kehadiran:</label>
                            <div>
                                <input type="radio" name="status_kehadiran" value="hadir" id="hadir"
                                    onclick="handleStatusChange()" checked> Hadir
                                <input type="radio" name="status_kehadiran" value="sakit" id="sakit"
                                    onclick="handleStatusChange()"> Sakit
                                <input type="radio" name="status_kehadiran" value="alpa" id="alpa"
                                    onclick="handleStatusChange()"> Alpa
                            </div>
                        </div>

                        <!-- Nama Pegawai -->
                        <div class="mb-3">
                            <label for="namapegawailabel" class="form-label">Nama Pegawai</label>
                            <select class="form-select" name="kode_pegawai" aria-label="Default select example">
                                @foreach ($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_pegawai }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Upah per Jam -->
                        <div class="mb-3" id="upahPerJam">
                            <label for="basic-url" class="form-label">Upah per/Jam</label>
                            <div class="input-group">
                                <span class="input-group-text" id="basic-addon3">Rp.</span>
                                <input type="number" name="perjam" class="form-control" placeholder="Contoh: 8000"
                                    id="basic-url" aria-describedby="basic-addon3 basic-addon4">
                                <span class="input-group-text" id="basic-addon3">/Jam</span>
                            </div>
                        </div>

                        <!-- Jam Kerja -->
                        <div class="mb-3" id="jamKerja">
                            <label for="basic-url" class="form-label">Jam Kerja</label>
                            <div class="input-group">
                                <input type="number" name="jam_kerja" class="form-control" placeholder="Contoh: 8 Jam"
                                    id="basic-url" aria-describedby="basic-addon3 basic-addon4">
                                <span class="input-group-text" id="basic-addon3">Jam</span>
                            </div>
                        </div>

                        <!-- Keterangan Sakit -->
                        <div class="mb-3" id="keterangan" style="display: none;">
                            <label for="keterangan" class="form-label">Keterangan Sakit</label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="3"></textarea>
                        </div>

                        <br>
                        <!-- untuk tombol simpan -->
                        <input class="col-sm-1 btn btn-success btn-sm" type="submit" value="Simpan">

                        <!-- untuk tombol batal simpan -->
                        <a class="col-sm-1 btn btn-dark btn-sm" href="{{ url('/gaji') }}" role="button">Batal</a>

                    </form>
                    <!-- Akhir Dari Input Form -->

                </div>
            </div>
        </div>

        <script>
            function handleStatusChange() {
                var status = document.querySelector('input[name="status_kehadiran"]:checked').value;
                document.getElementById('upahPerJam').style.display = (status === 'hadir') ? 'block' : 'none';
                document.getElementById('jamKerja').style.display = (status === 'hadir') ? 'block' : 'none';
                document.getElementById('keterangan').style.display = (status === 'sakit') ? 'block' : 'none';
            }
        </script>


    @endsection
