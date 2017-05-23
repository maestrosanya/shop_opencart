$(document).ready(function () {

    /* start Login popup */
    function loginPopup() {

        var btn_loginPopup = $('header ul li.dropdown a').filter("[href='#form_login']");

        $(btn_loginPopup).magnificPopup({
            type: 'inline',
            preloader: false
        });

        $(document).on('click', '.popup-modal-dismiss', function (e) {
            e.preventDefault();
            $.magnificPopup.close();
        });
    }
    loginPopup();

    /* end Login popup */

    $('form#form_login').submit(function (e) {

        e.preventDefault();

        var formData = {
            "email": $('.form_login__login').val(),
            "password": $('.form_login__password').val()
        };
        console.log(formData);

        $.ajax({
            url: 'index.php?route=account/login',
            type: 'post',
            data: formData,
            dataType: 'html',
            beforeSend: function () {

            },
            success: function (html) {
                var htmlData = $(html);
                var alertDanger = $(htmlData).find('div.alert-danger').text();

                if ( ! alertDanger ){
                    window.location.href="index.php?route=account/account";
                } else {
                    $('div.alert-danger').html( '<i class="fa fa-exclamation-circle"></i>' + alertDanger);
                }
            }
        });
    });

});
