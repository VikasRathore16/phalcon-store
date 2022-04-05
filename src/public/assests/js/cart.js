$(".products").on("click", ".add-to-cart", function (e) {
    e.preventDefault();
    product_id = ($(this).data("product_id"));

    $.ajax({
        method: "POST",
        url: "http://localhost:8080/cart/add",
        data: { product_id: product_id },
        // dataType: "Array",
    }).done(function (data) {
        console.log("success");
        console.log(data);


    });
});


$(".table").on("click", "#Remove", function (e) {
    e.preventDefault();
    product_id = $(this).data("product_id");
    $.ajax({
        method: "POST",
        url: "http://localhost:8080/cart/remove",
        data: { product_id: product_id, action: "Remove" },
        // dataType: "JSON",
    }).done(function (data) {
        console.log("success");
        console.log(data);
        // location.reload();

    });
});

$(".table").on("click", "#update", function (e) {
    e.preventDefault();

    id = $(this).data('product_id')
    val = ($("#update" + id).val());
    $.ajax({
        method: "POST",
        url: "http://localhost:8080/cart/update",
        data: { product_id: id, action: "update", quantity: val },
        // dataType: "JSON",
    }).done(function (data) {
        console.log('hello');
        console.log(data);
        // window.location.reload();
        // location.reload();

    });
});