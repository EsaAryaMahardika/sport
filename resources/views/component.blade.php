@extends('layout.admin')
@section('title', 'Komposisi')
@section('content')
<div class="some-text">
  <a class="btn btn-input" href="#input">INPUT</a>
</div>
<div class="popup" id="input">
  <div class="popup__content">
    <form action="/component" method="post">
      @csrf
      <div class="row">
        <h2>Tambah Komposisi</h2>
        <div class="input-group" id="productPrice">
            <select name="product_id">
                <option value="">Pilih Produk</option>
                @foreach ($product as $data)
                    <option value="{{ $data->id }}" data-price="{{ $data->harga }}">{{ $data->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="input-group">
          <input type="text" placeholder="Harga" name="harga" class="hargaProduct" />
        </div>
        <div id="inputMaterials">
            <div>
                <div class="col-third">
                    <label>Bahan Baku</label>
                </div>
                <div class="col-third">
                    <label>Jumlah</label>
                </div>
                <div class="col-third">
                    <label>Harga</label>
                </div>
            </div>
            <div id="template" class="input-group">
                <div class="col-third">
                    <select name="materials_id[]">
                        <option value="">Pilih Bahan Baku</option>
                        @foreach ($materials as $material)
                            <option value="{{ $material->id }}" data-harga="{{ $material->harga }}">{{ $material->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-third">
                    <input type="number" name="jumlah[]" step="0.01">
                </div>
                <div class="col-third">
                    <input type="text" class="harga-label" disabled>
                </div>
            </div>
        </div>
        <div class="btn-field">
            <button type="button" class="btn" id="addMaterialInput">+</button>
        </div>
        <div class="input-group">
            <label>Total</label>
            <input type="number" id="totalPriceInput" disabled/>
        </div>
      </div>
      <a href="#" class="btn">Close</a>
      <button type="submit" class="btn">Tambah</button>
    </form>
  </div>
</div>
<table id="component">
  <thead>
    <tr>
      <th>No.</th>
      <th>Produk</th>
      <th>Bahan Baku</th>
      <th>Jumlah</th>
      <th>Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach ($product as $item)
    <tr>
      <td>{{ $loop->iteration }}</td>
      <td>{{ $item->nama }}</td>
      <td>
        @foreach ($item->materials as $data)
            - {{ $data->nama }} <br>
        @endforeach
      </td>
      <td>
        @foreach ($item->materials as $data)
            - {{ $data->pivot->jumlah }} <br>
        @endforeach
      </td>
      <td>
        <a href="#edit{{ $item->id }}" class="btn">Edit</a> | <a href="#delete{{ $item->id }}" class="btn">Hapus</a>
      </td>
    </tr>
    {{-- MODAL EDIT --}}
    <div class="popup" id="edit{{ $item->id }}">
      <div class="popup__content">
        <div class="row">
          <h2>Ubah Komposisi</h2>
          <form action="component/{{ $item->id }}" method="POST">
            @csrf
            @method('PUT')
            <div class="input-group">
                <input type="text" placeholder="Nama" name="nama" value="{{ $item->nama }}"/>
            </div>
            <div class="input-group">
                <input type="text" placeholder="Harga" name="harga" value="{{ $item->harga }}"/>
            </div>
            <a href="#" class="btn">Close</a>
            <button type="submit" class="btn">Ubah</button>
          </form>
        </div>
      </div>
    </div>
    {{-- MODAL DELETE --}}
    <div class="popup" id="delete{{ $item->id }}">
      <div class="popup__content">
        <form action="component/{{ $item->id }}" method="POST">
          @csrf
          @method('DELETE')
          <p class="popup__text">
            Yakin ingin hapus komposisi {{ $item->nama }}?
          </p>
          <a href="#" class="btn">Close</a>
          <button type="submit" class="btn">Hapus</button>
        </form>
      </div>
    </div>
    @endforeach
  </tbody>
</table>
@push('script')
<script>
    document.getElementById('addMaterialInput').addEventListener('click', function() {
        const template = document.getElementById('template');
        const inputMaterials = document.getElementById('inputMaterials');
        const newMaterialInput = template.cloneNode(true);
        newMaterialInput.style.display = 'block';
        const deleteButton = document.createElement('button');
        deleteButton.textContent = 'Hapus';
        deleteButton.addEventListener('click', function() {
            this.parentElement.remove();
        });
        newMaterialInput.appendChild(deleteButton);
        inputMaterials.appendChild(newMaterialInput);
    });
</script>
<script>
    $(document).ready(function() {
        $('#productPrice').on('change input', 'select[name="product_id"]', function() {
            harga($(this));
        });
        $('#inputMaterials').on('change input', 'select[name="materials_id[]"], input[name="jumlah[]"]', function() {
            updatePrice($(this));
            updateTotalPrice();
        });
        function updatePrice(element) {
            const selectedMaterial = element.closest('.input-group').find('select[name="materials_id[]"] option:selected');
            const hargaPerUnit = selectedMaterial.data('harga');
            const jumlah = element.closest('.input-group').find('input[name="jumlah[]"]').val();
            const totalPrice = parseFloat(hargaPerUnit) * parseFloat(jumlah);
            element.closest('.input-group').find('.harga-label').val(totalPrice);
        }
        function updateTotalPrice() {
            let total = 0;
            $('#inputMaterials > div').each(function() {
                const selectedMaterial = $(this).find('select[name="materials_id[]"] option:selected');
                const hargaPerUnit = parseFloat(selectedMaterial.data('harga'));
                const jumlah = parseFloat($(this).find('input[name="jumlah[]"]').val());
                const subtotal = hargaPerUnit * jumlah;
                if (!isNaN(subtotal)) {
                    total += subtotal;
                }
            });
            $('#totalPriceInput').val(total);
        }
        function harga(element) {
            const selectedPrice = element.find('option:selected').data('price');
            element.closest('.row').find('input[name="harga"]').val(selectedPrice);
        }
    });
</script>
@endpush
@endsection