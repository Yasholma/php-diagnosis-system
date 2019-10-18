$(function () {

    // Getting states according to country id
    $('#country').on('change', () => {
        let country_id = $("#country option:selected").val();
        $.ajax({
           url: '/assets/ajax/states.ajax.php',
            method: 'post',
            data: {'country_id': country_id},
            cache: false,
            success: function (res) {
                $("#state").html(res);
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    // Getting states according to country id
    $('#state').on('change', () => {
        let state_id = $("#state option:selected").val();
        $.ajax({
            url: '/assets/ajax/cities.ajax.php',
            method: 'post',
            data: {'state_id': state_id},
            cache: false,
            success: function (res) {
                $("#city").html(res);
            },
            error: function (err) {
                console.log(err);
            }
        });
    });

    // Terms and condition button
    $('#terms input:checked').removeClass('is-invalid');


});
