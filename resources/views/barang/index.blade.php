@extends('template.layout')
@section('title', 'Data Barang eToko')

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <btn class="btn btn-success btnTambahBarang" data-bs-target='#modalForm' data-bs-toggle='modal' attr-href='{{route('barang.tambah')}}'><i class="bib bi-plus">Tambah</i></btn>
            </div>
            <div class="card-body">
                <table class="table DataTable table-hovered table-bordered">
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Stok</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                
            </div>
        </div>
        {{-- modal --}}
        <div class="modal fade" id="modalForm" data-bs-backdrop='static' data-bs-keyboard='false' tabindex="-1" aria-labelledby="staticBackdropLarge">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss='modal' aria-label="close"></button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <btn class="btn btn-success btnSimpanBarang"><i class="bi bi-save"></i>Simpan</btn> 
                        <btm class="btn btn-primary" data-bs-dismiss="modal">Batal</btm>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script type="module">
        const modalInstance = document.querySelector('#modalForm')
        const modal = bootstrap.Modal.getOrCreateInstance(modalInstance);
        var table = $('.DataTable').DataTable({
            processing : true,
            serverSide : true,
            ajax : "{!!route('barang.data')!!}",
            columns : [
                {
                    data: 'kode',
                    name: 'kode'
                },
                {
                    data: 'nama_barang',
                    name: 'nama_barang'
                },
                {
                    render: function(data,type,row){
                            return row.stok.jumlah;
                    }
                },
                {
                    render: function(data,type,row){
                        return "<btn class='btn btn-primary btnEdit' data-bs-toggle='modal' data-bs-target='#modalForm' attr-href='{!!url('/barang/edit/"+row.id_barang+"')!!}'><i class='bi bi-pencil'></i> Edit </btn> <btn class='btn btn-danger'><i class='bi bi-trash'></i> Hapus </btn>";
                    }
                },
            ]
        });
        //Tambah
        $('.btnTambahBarang').on('click',function(a){
        a.preventDefault()
        const modalForm = document.getElementById('modalForm')
        modalForm.addEventListener('shown.bs.modal',function(event){
            event.preventDefault()
            event.stopImmediatePropagation()
            const link = event.relatedTarget.getAttribute('attr-href')
            const modalData = document.querySelector('#modal .modal-body')

            $('.modal-header .modal-title').html('Tambah Data Barang Baru')
            axios.get(link).then(response =>{
                $('.modal .modal-body').html(response.data)
            })

            //event simpan saat tombol simpan di klik
            $('.btnSimpanBarang').on('click',function(simpanEvent){
                // modal.hide()
                simpanEvent.preventDefault()
                simpanEvent.stopImmediatePropagation()
                let data = {
                    'nama_barang' : $('#namaBarang').val(),
                    'kode_barang' : $('#kodeBarang').val(),
                    'harga' : $('#hargaBarang').val(),
                    '_token' : '{{csrf_token()}}'
                }
                if(data.nama_barang !== '' && data.kode_barang !== '' && data.harga !== ''){
                    //* input data
                    axios.post('{{url("barang/simpan")}}',data).then(response =>{
                        if(response.data.status == 'success'){
                                    Swal.fire({
                                'title' : 'Berhasil!',
                                'text' : response.data.pesan,
                                'icon' : 'success'
                            }).then(() => {
                                modal.hide()
                                table.ajax.reload()
                            })
                        } else {
                            Swal.fire({
                                'title' : 'Data gagal ditambahkan!',
                                'text' : response.data.pesan,
                                'icon' : 'error'
                            })
                        }
                    })
                } else {
                    Swal.fire({
                        'title' : 'ops gagal !',
                        'text' : 'Form Harus diisi',
                        'icon' : 'error'
                    })
                }
            })
        })
    })
    //edit
        $('.DataTable tbody').on('click','editBtn',function(event){
            let modalForm = document.getElementById('modalForm');
            modalForm.addEventListener('show.bs.modal',function(event){
                event.preventDefault();
                event.stopImmediatePropagation();
                let link = event.relatedTarget.getAttribute('attr-href');
                axios.get(link).then(respone => {
                    $('#modalForm .modal-body').html(respone.data);
                    $('.modalForm .modal-title').html('Edit data barang');
                });
            });
        });

                // $.ajax({
                //     url: link,
                //     method: 'GET',
                //     success: function(response){
                //         $('#modalForm .modal.body').html(response);
                //     };
                // });
    </script>
@endsection