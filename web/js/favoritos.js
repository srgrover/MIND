$(document).ready(function () {
    $(".btn-star").unbind("click").click(function () {
        $.ajax({
            url: URL+'/favorito',
            type: 'POST',
            data: {fav: $(this).attr("data-fav")}
        });
    });

    $("#todos-star").unbind("click").click(function () {
        $.ajax({
            url: URL+'/favoritos',
            type: 'POST'
        });
    });
});