$(document).ready(function () {
    
    if ( $('body').outerHeight() <= $(window).height() ) {
        $('.footer').css({
            'position' : 'fixed',
            'bottom' : '0px'
        });
    }
    
    $(window).resize(function(){
        if ( $('body').outerHeight() <= $(window).height() ) { 
            $('.footer').css({
                'position' : 'fixed',
                'bottom' : '0px'
            });
        } else {
            $('.footer').css({
                'position' : 'static'
            });
        }
    });
    
    // Matrice case value
    $('.table-matrice').on('keyup', 'input.matrice-case', function(){
        $.ajax({
            context: this,
            type: 'POST',
            url: $(this).attr('data-url'),
            data: '&value=' + $(this).val()
        });
    });
    
    // Matrice taxa name value
    $('.table-matrice').on('keyup', 'input.matrice-taxa-name', function(){
        $.ajax({
            context: this,
            type: 'POST',
            url: $(this).attr('data-url'),
            data: '&value=' + $(this).val()
        });
    });
    
    $('.matrice-button-action').on('click', function(e){
        e.preventDefault();
        $.ajax({
            context: this,
            type: 'POST',
            url: $(this).attr('href')
        }).done(function(data){
            $('.container-matrice').html(data);
        });
    });
    
});