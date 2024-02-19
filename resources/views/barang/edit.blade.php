<div class="row">
    <div class="col-lg-12">
        <div class="form-group">
            <label for="">Kode Barang</label>
            <input type="hidden" name="id_barang" value="{{ $barangDetil->id_barang }}"/>
            <input  class="form-control" 
                    type="text" name="kode_barang"
                    id="kodeBarang" value="{{ $barangDetil->kode_barang }}">
        </div>
        <div class="form-group">
            <label for="">Nama Barang</label>
            <input 
                type="text" 
                name="nama_barang" id="namaBarang" 
                class="form-control" value="{{ $barangDetil->nama_barang }}" />
        </div>
        <div class="form-group">
            <label for="">Harga Barang</label>
            <input 
                type="number" 
                class="form-control"name="harga"
                id="harga" value="{{ $barangDetil->harga }}">
        </div>
    </div>
</div>