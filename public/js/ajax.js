$(document).ready(function () {
    $('.gejala').select2();
    $(".close").click(function () {
        $(this)
            .parent(".alert")
            .fadeOut();
    });
    $('.prov').on('change', function() {
        var id_prov = $(this).val();
        if (id_prov) {
            $.ajax({
                url: 'kab/' + id_prov,
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
});
