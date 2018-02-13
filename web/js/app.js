$(document).ready(function () {
    //MARCAR/DESMARCAR TODOS LOS CHECKBOX
    $('input#check-all').change(function () {
        $('input:checkbox').prop('checked', $(this).prop("checked"));
    });

    $('.ckbox label').on('click', function () {
        if($(this).prop('checked', false)){
            $('input#check-all').prop('checked', false);
            $(this).parents('tr').removeClass('selected');
        }else{
            $(this).parents('tr').addClass('selected');
        }
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

    /* MARCAR/DESMARCAR UN SOLO FAVORITO */
    $('.star').on('click', function () {
        $(this).toggleClass('star-checked');
        if(!$(this).hasClass('star-checked')){              //Cuando todos los favoritos esten marcados
            $('#todos-star').removeClass('star-checked');   // Si un favorito es desmarcado, se desmarca favorito de la cabecera
        }
    });

    /* MARCAR/DESMARCAR VISUALMENTE TODOS LOS FAVORITOS */
    $('#todos-star').click(function () {
        $(this).toggleClass('star-checked');
        var todos_fav = true;
        $('.star').each(function () {                       //Se recorre el array
            if(!$(this).hasClass('star-checked')){          //Y si no lo están
                $(this).addClass('star-checked');           //Se marcan las estrellas que no lo estén
                todos_fav = false
            }
        });

        if(todos_fav){
            $('.star').each(function () {
                $(this).removeClass('star-checked');
                todos_fav = true
            });
        }
    });
});
