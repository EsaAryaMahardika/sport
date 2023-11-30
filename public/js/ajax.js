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
});
