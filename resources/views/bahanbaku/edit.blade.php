@extends('layoutbootstrap/main')
@extends('layoutbootstrap/sidebar')
@extends('layoutbootstrap/header')
@extends('layoutbootstrap/footer')
@extends('layoutbootstrap')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title fw-semibold mb-4">Ubah Data Bahan Baku</h5>

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
                <form action="/bahanbaku/{{$bahanbaku->id}}" method="post">
                  @method('put')
                    @csrf
                    <fieldset disabled>
                        <div class="mb-3"><label for="kodebahanbakulabel">Kode Bahan Baku</label>
                            <input class="form-control form-control-solid" id="kode_bahan_baku_tampil"
                                name="kode_bahan_baku_tampil" type="text" placeholder="Contoh: PR-001"
                                value="{{ $bahanbaku->kode_bahan_baku }}" readonly>
                        </div>
                    </fieldset>
                    <input type="hidden" id="kode_bahan_baku" name="kode_bahan_baku" value="{{ $bahanbaku->kode_bahan_baku }}">

                    <div class="mb-3"><label for="namabahanbakulabel">Nama Bahan Baku</label>
                        <input class="form-control form-control-solid" id="nama_bahan_baku" name="nama_bahan_baku"
                            type="text" placeholder="Contoh: Bahan Baku Sejuk Menenangkan"
                            value="{{ old('nama_bahan_baku', $bahanbaku->nama_bahan_baku) }}">
                    </div>


                    <div class="mb-0"><label for="stockbahanbakulabel">Stock Bahan Baku</label>
                        <input type="number" value="{{ old('stock_bahan_baku', $bahanbaku->stock_bahan_baku) }}" class="form-control form-control-solid" id="stock_bahan_baku" name="stock_bahan_baku" rows="3"
                            placeholder="Cth: Stock Mie 45"></input>
                    </div>
                    <br>
                    <!-- untuk tombol simpan -->

                    <input class="col-sm-1 btn btn-success btn-sm" type="submit" value="Simpan">

                    <!-- untuk tombol batal simpan -->
                    <a class="col-sm-1 btn btn-dark  btn-sm" href="{{ url('/bahanbaku') }}" role="button">Batal</a>

                </form>
                <!-- Akhir Dari Input Form -->

            </div>
        </div>
    </div>
@endsection
