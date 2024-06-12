@extends('layoutbootstrap')

@section('konten')

<!-- Sweet Alert -->
@if(isset($status_hapus))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: 'Hapus Data Berhasil',
                icon: 'success',
                confirmButtonText: 'Ok'
            });
        </script>
@endif

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
              <a href="https://adminmart.com/product/modernize-free-bootstrap-admin-dashboard/" target="_blank" class="btn btn-primary">Download Free</a>
              <li class="nav-item dropdown">
                <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
                  aria-expanded="false">
                  <img src="{{asset('images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
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
                    <a href="./authentication-login.html" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
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
                  <h5 class="card-title fw-semibold mb-4">Bahan Baku</h5>
                  <div class="card">

                        <!-- Card Header - Dropdown -->
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-primary">Master Data Bahan Baku</h6>
                            
                            <!-- Tombol Tambah Data -->
                            <a href="#" class="btn btn-primary btn-icon-split btn-sm tampilmodaltambah" data-toogle="modal" data-target="#ubahModal">
                                <span class="icon text-white-50">
                                    <i class="ti ti-plus"></i>
                                </span>
                                <span class="text">Tambah Data</span>
                            </a>
                            <!-- Akghir Tombol Tambah Data -->

                        </div>

                    <div class="card-body" id="show_all_coas">
                      
                    </div>

                  </div>
                </div>
                
                
              </div>
            </div>
          </div>
        </div>

        <!-- Script untuk menampilkan modals -->
        <script>
            function deleteConfirm(e){
                var tomboldelete = document.getElementById('btn-delete')  
                id = e.getAttribute('data-id');

                // const str = 'Hello' + id + 'World';
                var url3 = "{{url('bahanbaku/destroy/')}}";
                var url4 = url3.concat("/",id);
                // console.log(url4);

                // console.log(id);
                // var url = "{{url('perusahaan/destroy/"+id+"')}}";
                
                // url = JSON.parse(rul.replace(/"/g,'"'));
                tomboldelete.setAttribute("href", url4); //akan meload kontroller delete

                var pesan = "Data dengan ID <b>"
                var pesan2 = " </b>akan dihapus"
                var res = id;
                document.getElementById("xid").innerHTML = pesan.concat(res,pesan2);

                var myModal = new bootstrap.Modal(document.getElementById('deleteModal'), {  keyboard: false });
                
                myModal.show();
            
            }
        </script>

        <!-- Awal Delete Confirmation-->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Apakah anda yakin?</h5>
                </div>
                <div class="modal-body" id="xid"></div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
                    <a id="btn-delete" class="btn btn-danger" href="#">Hapus</a>
                    
                </div>
                </div>
            </div>
        </div> 
        <!-- Akhir Delete Confirmation -->

<!-- Awal Modal Ubah dan Tambah -->
<div class="modal fade" id="ubahModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="labelmodalubah">Ubah Data Bahan Baku</h5>
        </div>
        
        <div class="modal-body">
            <!-- Form untuk input -->
            <form action="#" class="formubahbahanbaku" method="post">
            @csrf
            <input type="hidden" id="idcoahidden" name="idcoahidden" value="">
            <input type="hidden" id="tipeproses" name="tipeproses" value="">
                <div class="mb-3 row">
                    <label for="nomerlabel" class="col-sm-4 col-form-label">Bahan Baku</label>
                        <div class="col-sm-8">
                            <select class="form-control" aria-label="Default select example" id="kode_bahan_baku" name="kode_bahan_baku">
                                @foreach ($bb as $p)
                                    <option value="{{$p->id}}">{{$p->nama_bahanbaku}}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback errorid_bahanbaku"></div>
                        </div>    
                </div>

                <div class="mb-3 row">
                    <label for="nomerlabel" class="col-sm-4 col-form-label">Kode Bahan Baku</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="kode_bahan_baku" name="kode_bahan_baku" placeholder="Masukkan Kode Bahan Baku, cth: 111">
                        <div class="invalid-feedback errorkode_bahan_baku"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="lantailabel" class="col-sm-4 col-form-label">Nama Bahan Baku</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="nama_bahanbaku" name="nama_bahanbaku" placeholder="Masukkan Nama Bahan Baku, cth: Kas">
                        <div class="invalid-feedback errornama_bahan_baku"></div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="hargalabel" class="col-sm-4 col-form-label">Stock bahan bakuu</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" id="stock_bahan_baku" name="stock_bahan_baku" placeholder="Masukkan Header Akun, cth: 1">
                        <div class="invalid-feedback errorstock_bahan_baku"></div>
                    </div>
                </div>
            </div>    

            <div class="modal-footer">
            <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success btnsimpan">Simpan</button>
            
            </div>
        </div>
    </div>
</div>   
<!-- Akhir Ubah dan Tambah Data Menggunakan Modal -->

<!-- Jquery Proses Ubah / Tambah Data -->
<!-- Modal Tambah Pop Up versi 2 -->

<!-- Ketika tombol dengan elemen id tampilmodaltambah ditekan -->
<script>
      $(function(){
            $('.tampilmodaltambah').on('click', function(){
              // merubah label menjadi Tambah Data Kamar
              $('#labelmodalubah').html('Tambah Data Bahan Baku');
              url = "{{url('bahanbaku')}}";
              $('.formubahbahanbaku').attr('action',url);
            //   $('#idbahanbaku').val(12);

              // kosongkan isi dari input form
              $('#kode_bahan_baku').val('');
              $('#nama_bahanbaku').val('');
              $('#stock_bahan_baku').val('');
              $('#idbahanbakuhidden').val('');
              $('#tipeproses').val('tambah'); //untuk identifikasi di controller apakah tambah atau update


                var data = {
                    'kode_bahan_baku': $('.kode_bahan_baku').val(),
                    'nama_bahanbaku': $('.nama_bahanbaku').val(),
                    'stock_bahan_baku': $('.stock_bahan_baku').val(),
                }  

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

              $('#ubahModal').modal('show');
              
            //   const id = $(this).data('id');
              $.ajax(
                {
                  
                    type: "post", //isinya put untuk update dan post untuk insert
                    url: "{{url('bahanbaku')}}",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 400) {
                            if(response.errors.kode_bahan_baku){
                                $('#kode_bahan_baku').removeClass('is-valid').addClass('is-invalid');
                                $('.errorkode_bahan_baku').html(response.errors.kode_bahan_baku);
                            }else{
                                $('#kode_bahan_baku').removeClass('is-invalid').addClass('is-valid');
                                $('.errorkode_bahan_baku').html();
                            }

                            if(response.errors.nama_bahanbaku){
                                $('#nama_bahanbaku').removeClass('is-valid').addClass('is-invalid');
                                $('.errornama_bahan_baku').html(response.errors.nama_bahanbaku);
                            }else{
                                $('#nama_bahanbaku').removeClass('is-valid').removeClass('is-invalid').addClass('is-valid');
                                $('.errornama_bahan_baku').html();
                            }

                            if(response.errors.stock_bahan_baku){
                                $('#stock_bahan_baku').removeClass('is-valid').addClass('is-invalid');
                                $('.errorstock_bahan_baku').html(response.errors.header_akun);
                            }else{
                                $('#stock_bahan_baku').removeClass('is-invalid').addClass('is-valid');
                                $('.errorstock_bahan_baku').html();
                            }

                        } else {
                            
                            // munculkan pesan sukses
                            Swal.fire({
                                title: 'Berhasil!',
                                text: response.sukses,
                                icon: 'success',
                                confirmButtonText: 'Ok'
                            });
                            
                            // kosongkan form
                            $('#ubahModal').modal('hide');

                            
                            databahanbaku(); //refresh data coa
                            
                        }
                    }

                }
              ); 

            });
          }); 
</script>
<!-- Akhir Jquery Proses Ubah / Tambah Data -->

<!-- Ketika tombol dengan elemen class bernama  editbtn ditekan -->
<script>
      function updateConfirm(e){
        id = e.getAttribute('data-id');

        $('#labelmodalubah').html('Ubah Data Bahan Baku');
        url = "{{url('bahanbaku')}}";
        $('.formubahbahanbaku').attr('action',url);
        $('#idbahanbakuhidden').val(id);
        $('#tipeproses').val('ubah'); 
        $('#ubahModal').modal('show');

        var url3 = "{{url('bahanbaku/edit/')}}";
        var url4 = url3.concat("/",id);

        $.ajax({
            type: "GET",
            url: url4,
            success: function (response) {
                if (response.status == 404) {
                    // beri alert kalau gagal
                    Swal.fire({
                        title: 'Gagal!',
                        text: response.message,
                        icon: 'warning',
                        confirmButtonText: 'Ok'
                    });

                    $('#ubahModal').modal('hide');
                } else {
                    // console.log(response.coa.kode_akun);
                    $('#kode_bahan_baku').val(response.bahanbaku.kode_bahan_baku);
                    $('#nama_bahanbaku').val(response.bahanbaku.nama_bahanbaku);
                    $('#stock_bahan_baku').val(response.bahanbaku.stock_bahan_baku);
                    $('#idbahanbakuhidden').val(id)

                    // pastikan form is-invalid dikembalikan ke valid
                    $('#kode_bahan_baku').removeClass('is-invalid').addClass('is-valid');;
                    $('.errorkode_bahan_baku').html();
                    $('#nama_bahanbaku').removeClass('is-invalid').addClass('is-valid');;
                    $('.errornama_bahan_baku').html();
                    $('.#stock_bahan_bakuu').removeClass('is-invalid').addClass('is-valid');;
                    $('.errorstock_bahan_baku').html();
                }
            }
        });
      } 
</script>
<!-- Akhir Ketika tombol dengan elemen class bernama  editbtn ditekan -->

<!-- Proses mengisi data pada tabel -->
<script>
        function databahanbaku(){
            $.ajax({
                url: '{{ url('bahanbaku/fetchAll') }}',
                method: 'get',
                success: function(response) {
                    $("#show_all_bahanbakus").html(response);
                    $("table").DataTable({
                    order: [0, 'desc']
                    });
                }
            });
        }
        
    </script>
    <script>
        // $.noConflict();
        $(document).ready(function(){
                databahanbaku();
            }
        );
    </script>
<!-- Akhir mengisi data pada tabel -->

<!-- Ketika tombol submit di form ditekan -->
<script>

        // definisikan tipe method yang berbeda 
        // untuk update=>put (pembedanga adalah inner html pada labelmodalubah berisi Ubah Data Coa)
        // sedangkan untuk input=>post nilai inner html pada labelmodalubah berisi Tambah Data Coa

        
        $(document).ready(function()
            {   		
                $('.formubahbahanbaku').submit(function(e)
                    {
                        e.preventDefault();
                            $.ajax(
                                {
                                    type: "post", //isinya post untuk insert dan put untuk delete
                                    url: $(this).attr('action'),
                                    data: $(this).serialize(),
                                    dataType: "json",
                                    success: function (response){
                                        // console.log('kssss');
                                        // jika responsenya adalah error
                                        if (response.status == 400) {
                                            if(response.errors.kode_bahan_baku){
                                                $('#kode_bahan_baku').removeClass('is-valid').addClass('is-invalid');
                                                $('.errorkode_bahan_baku').html(response.errors.kode_bahan_baku);
                                            }else{
                                                $('#kode_bahan_baku').removeClass('is-invalid').addClass('is-valid');;
                                                $('.errorkode_bahan_baku').html();
                                            }

                                            if(response.errors.nama_bahanbaku){
                                                $('#nama_bahanbaku').removeClass('is-valid').addClass('is-invalid');
                                                $('.errornama_bahan_baku').html(response.errors.nama_bahanbaku);
                                            }else{
                                                $('#nama_bahanbaku').removeClass('is-invalid').addClass('is-valid');;
                                                $('.errornama_bahan_baku').html();
                                            }

                                            if(response.errors.stock_bahan_baku){
                                                $('#stock_bahan-baku').removeClass('is-valid').addClass('is-invalid');
                                                $('.errorstock_bahan_baku').html(response.errors.stock_bahan_baku);
                                            }else{
                                                $('#stock_bahan_baku').removeClass('is-invalid').addClass('is-valid');;
                                                $('.errorstock_bahan_baku').html();
                                            }

                                        }
                                        else{
                                            // munculkan pesan sukses
                                            Swal.fire({
                                                title: 'Berhasil!',
                                                text: response.sukses,
                                                icon: 'success',
                                                confirmButtonText: 'Ok'
                                            });
                                            
                                            // kosongkan form
                                            $('#ubahModal').modal('hide');

                                            
                                            databahanbaku(); //refresh data coa
                                            

                                        }
                                    },
                                    error: function(xhr, ajaxOptions, thrownError){
                                        alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                                    } 
                                } 
                            );
                            return false;
                    }
                );
            }
        );
</script>
<!-- Akhir ketika tombol submit di form ditekan -->

@endsection