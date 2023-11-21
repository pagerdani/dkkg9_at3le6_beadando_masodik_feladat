const maxDate = new Date($('#datum').attr('data-max'));

$(document).ready(function () {
       $('#datum').pickadate({
        format: 'yyyy-mm-dd',
        clear: '',
        max: maxDate
    });
});
