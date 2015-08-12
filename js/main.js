$('form').submit(function(e){
    $("input, textarea", $(this)).each(function (){
       var el = $(this);
       el.get(0).checkValidity();
       if (!el.get(0).validity.valid) {
           el.closest('div').addClass('has-error');
           e.preventDefault();
       } else {
           el.closest('div').removeClass('has-error');
       }
    });
});
