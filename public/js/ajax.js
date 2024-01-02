$(document).ready(function () {
    $(".close").click(function () {
        $(this)
            .parent(".alert")
            .fadeOut();
    });
    $('.prov').on('change', function() {
        var prov_id = $(this).val();
        if (prov_id) {
            $.ajax({
                url: 'kab/' + prov_id,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    $('.kab').empty();
                    $.each(data, function(key, value) {
                        $('.kab').append('<option value="' + key + '">' + value + '</option>');
                    });
                }
            });
        } else {
            $('.kab').empty();
        }
    });
    $('#productPrice').on('change input', 'select[name="product_id"]', function() {
        harga($(this));
    });
    $('#inputMaterials').on('change input', 'select[name="materials_id[]"], input[name="jumlah[]"]', function() {
        updatePrice($(this));
        updateTotalPrice();
    });
    $('#inputProduct').on('change input', 'select[name="product_id[]"], input[name="jumlah[]"]', function() {
        updatePriceSales($(this));
        updateTotalPriceSales();
    });
    function updatePrice(element) {
        const selectedMaterial = element.closest('.input-group').find('select[name="materials_id[]"] option:selected');
        const hargaPerUnit = selectedMaterial.data('harga');
        const jumlah = element.closest('.input-group').find('input[name="jumlah[]"]').val();
        const totalPrice = parseFloat(hargaPerUnit) * parseFloat(jumlah);
        element.closest('.input-group').find('.harga-label').val(totalPrice);
    }
    function updatePriceSales(element) {
        const selectedMaterial = element.closest('.input-group').find('select[name="product_id[]"] option:selected');
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
    function updateTotalPriceSales() {
        let total = 0;
        $('#inputProduct > div').each(function() {
            const selectedMaterial = $(this).find('select[name="product_id[]"] option:selected');
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
    function addInputHandler(addButtonId, inputContainerId) {
        $('#' + addButtonId).on('click', function() {
            const template = $('#template').get(0);
            const inputContainer = $('#' + inputContainerId);
            const newInput = $(template).clone().css('display', 'block');
            const deleteButton = $('<button>').text('Hapus').on('click', function() {
                $(this).parent().remove();
            });
            newInput.append(deleteButton);
            inputContainer.append(newInput);
        });
    }
    // Memanggil fungsi addInputHandler dengan ID yang berbeda untuk masing-masing tombol
    addInputHandler('addMaterialInput', 'inputMaterials');
    addInputHandler('addProductInput', 'inputProduct');
    
});
