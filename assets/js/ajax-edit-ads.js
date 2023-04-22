$('.btn-primary').click(function (e) {

    e.preventDefault();

    let name = $('input[name="name"]').val(),
        description = $('textarea[name="description"]').val(),
        price = $('input[name="price"]').val();

    let category = $('.form-select option:selected').val(),
        status = $('.status-select option:selected').val()


    $.ajax({
        url: '../app/edit-ads.php',
        type: 'POST',
        dataType: 'json',
        data: {
            name: name,
            category: category,
            price: price,
            description: description,
            status: status
        },
        // success: function (data) {
        //     if(data.status) {
        //
        //
        //     } else {
        //
        //         $('.invalid-validation').text('error');
        //
        //     }
        // }
    })
});
