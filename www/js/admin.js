$(document).ready(function () {
    
    $('.container-ajax-form-admin-edit').on('submit', '#admin-quizz-edit',function(e) {
        e.preventDefault();
        
        var $this =  $(this); // form object
        $.ajax({
            url: $this.attr('action'),
            type: $this.attr('method'),
            data: $this.serialize(),
            success: function(html) {
                $('.container-ajax-form-admin-edit').html(html);
                $('.container-ajax-form-admin-edit .alert').delay(3000).fadeOut();
            }
        });
    });
    
});