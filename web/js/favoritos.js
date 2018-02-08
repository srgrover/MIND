$(document).ready(function () {
    $(".star").unbind("click").click(function () {
        var idObjeto = $(this).attr("id");
        var id = idObjeto.split("-")[1];

       $.ajax({
           url: URL+'/objeto/'+id+'/favorito',
           type: 'POST',
           success: function () {
               $(this).addClass("star-checked")
           }
       });
    });
});