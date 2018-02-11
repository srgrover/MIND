$(document).ready(function () {

    $('.star').on('click', function () {
        $(this).toggleClass('star-checked');
        if(!$(this).hasClass('star-checked')){
            $("#todos-star").removeClass('star-checked');
        }
    });

    //MARCAR/DESMARCAR TODOS LOS CHECKBOX
    $("#check-all").change(function () {
        $("input:checkbox").prop('checked', $(this).prop("checked"));
    });

    $("#todos-star").click(function () {
        $(this).toggleClass('star-checked');
        var todos_fav = true;
        $(".star").each(function () {
            if(!$(this).hasClass('star-checked')){
                $(this).addClass('star-checked');
                todos_fav = false
            }
        });

        if(todos_fav){
            $(".star").each(function () {
                $(this).removeClass('star-checked');
                todos_fav = true
            });
        }
    });



    // $todos_fav = true;
    // foreach($objetos as $objeto) {
    //     if(!$objeto->isFavorito()){
    //         $objeto->setFavorito(1);
    //         $todos_fav = false;
    //     }
    // }
    // if($todos_fav){
    //     foreach($objetos as $objeto) {
    //         $objeto->setFavorito(0);
    //         $todos_fav = true;
    //     }
    // }



    $('.ckbox label').on('click', function () {
        $(this).parents('tr').toggleClass('selected');
    });

    $('.btn-filter').on('click', function () {
        var $target = $(this).data('target');
        if ($target != 'all') {
            $('.table tr').css('display', 'none');
            $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
        } else {
            $('.table tr').css('display', 'none').fadeIn('slow');
        }
    });
});