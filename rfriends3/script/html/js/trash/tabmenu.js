jQuery(function($) {
    $('#tabcontent > div').hide();
    $('#tabnavi a').click(function() {
        $('#tabcontent > div').hide().filter(this.hash).fadeIn();
        $('#tabnavi a').removeClass('active');
        $(this).addClass('active');
        return false;
    }).filter(':eq(0)').click();
});