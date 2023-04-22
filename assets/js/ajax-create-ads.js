$('.btn-primary').click(function (e) {

    e.preventDefault();

    let name = $('input[name="name"]').val(),
        description = $('textarea[name="description"]').val(),
        price = $('input[name="price"]').val();
    let category = $('.form-select option:selected').val();

    $.ajax({
        url: '../app/create-ads.php',
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            description: description,
            price: price,
            category: category
        },
        success: function (data) {
            if(data.status) {

                document.location.href = '../index.php';

            } else {

                $('.invalid-validation').text(data.message);

            }
        }
    })
});
