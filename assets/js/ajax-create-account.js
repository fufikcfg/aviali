$('.btn-success').click(function (e) {

    e.preventDefault();

    let name = $('input[name="name"]').val(),
        surname = $('input[name="surname"]').val(),
        middleName = $('input[name="middleName"]').val(),
        phoneNumber = $('input[name="phoneNumber"]').val(),
        email = $('input[name="email"]').val(),
        password = $('input[name="password"]').val();

    $.ajax({
        url: '../app/create-account.php',
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            surname: surname,
            middleName: middleName,
            phoneNumber: phoneNumber,
            email: email,
            password: password

        },
        success: function (data) {
            if(data.status) {

                document.location.href = "index.php";

            } else {

                $('.invalid-validation').text(data.message);

            }
        }
    })
});
