$('.btn-primary').click(function (e) {

    e.preventDefault();

    let email = $('input[name="email"]').val(),
        password = $('input[name="password"]').val();

    $.ajax({
        url: '../app/user-authorization.php',
        type: 'POST',
        dataType: 'json',
        data: {
            email: email,
            password: password

        },
        success: function (data) {
            if(data.status) {

                document.location.href = "index.php";

            } else {

                $('.error-message').text(data.message);

            }
        }
    })
});