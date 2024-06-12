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
                    <h5 class="card-title fw-semibold mb-4">Data pegawai</h5>

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
                    <form action="{{ route('pegawai.update', $pegawai->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <fieldset disabled>
                            <div class="mb-3"><label for="kodepegawailabel">Kode pegawai</label>
                                <input class="form-control form-control-solid" id="kode_pegawai_tampil"
                                    name="kode_pegawai_tampil" type="text" placeholder="Contoh: PL-001"
                                    value="{{ $pegawai->kode_pegawai }}" readonly>
                            </div>
                        </fieldset>
                        <input type="hidden" id="kode_pegawai" name="kode_pegawai" value="{{ $pegawai->kode_pegawai }}">

                        <div class="mb-3">
                            <label for="namapegawailabel">Nama Pegawai</label>
                            <input class="form-control form-control-solid" id="nama_pegawai" name="nama_pegawai"
                                type="text" placeholder="Contoh: Budi"
                                value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}">
                        </div>

                        <div class="mb-3">
                            <label for="alamatlabel">Alamat Pegawai</label>
                            <input class="form-control form-control-solid" id="alamat" name="alamat" type="text"
                                placeholder="Contoh: Bojongsoang" value="{{ old('alamat', $pegawai->alamat) }}">
                        </div>

                        <div class="mb-3">
                            <label for="no_hplabel">Nomor Telepon</label>
                            <input class="form-control form-control-solid" id="no_hp" name="no_hp" type="text"
                                placeholder="Contoh: 081234567890" value="{{ old('no_hp', $pegawai->no_hp) }}">
                        </div>

                        <div class="mb-3">
                            <label for="jabatanlabel">Jabatan</label>
                            <select class="form-control form-control-solid" id="jabatan" name="jabatan">
                                <option value="Manager"
                                    {{ old('jabatan', $pegawai->jabatan) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                <option value="Kasir"
                                    {{ old('jabatan', $pegawai->jabatan) == 'Kasir' ? 'selected' : '' }}>Kasir</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="jenis_kelaminlabel">Jenis Kelamin</label><br>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="jenis_kelamin_laki"
                                    name="jenis_kelamin" value="Laki-laki"
                                    {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jenis_kelamin_laki">Laki-laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="jenis_kelamin_perempuan"
                                    name="jenis_kelamin" value="Perempuan"
                                    {{ old('jenis_kelamin', $pegawai->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                <label class="form-check-label" for="jenis_kelamin_perempuan">Perempuan</label>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="emaillabel">Email</label>
                            <input class="form-control form-control-solid" id="email" name="email" type="email"
                                placeholder="Contoh: email@example.com"
                                value="{{ old('email', $pegawai->user->email) }}">
                        </div>

                        <div class="mb-3">
                            <label for="passwordlabel">Password</label>
                            <input class="form-control form-control-solid" id="password" name="password"
                                type="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation">Konfirmasi Password</label>
                            <input class="form-control form-control-solid" id="password_confirmation"
                                name="password_confirmation" type="password" placeholder="Konfirmasi Password">
                        </div>
                        <br>
                        <!-- untuk tombol simpan -->

                        <input class="col-sm-1 btn btn-success btn-sm" type="submit" value="Ubah">

                        <!-- untuk tombol batal simpan -->
                        <a class="col-sm-1 btn btn-dark  btn-sm" href="{{ url('/pegawai') }}" role="button">Batal</a>

                    </form>
                    <!-- Akhir Dari Input Form -->

                </div>
            </div>
        </div>




    @endsection
