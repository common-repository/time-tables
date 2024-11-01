jQuery(document).ready(function($){
    $(document).on('focus',".codott_timetables_date", function(){
        $(this).timepicker();
    });
});
jQuery(document).ready(function($) {
    $('.codott_timetable_data_submit').click(function(e) {
        e.preventDefault();
        $('#publish').click();
    });

    $('#add-codott-timeslot-row').on('click', function() {
        var row = $('.empty-codott-timeslot-row.screen-reader-text').clone(true);
        row.removeClass('empty-codott-timeslot-row screen-reader-text');
        row.insertBefore('#repeatable-fieldset-codott-timeslot tbody>tr:last');
        return false;
    });
    $('.remove-row-codott-timeslot').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
    $('#repeatable-fieldset-codott-timeslot tbody').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.sort'
    });

    $('#add-codott-dayslot-row').on('click', function() {
        var row = $('.empty-codott-dayslot-row.screen-reader-text').clone(true);
        row.removeClass('empty-codott-dayslot-row screen-reader-text');
        row.insertBefore('#repeatable-fieldset-codott-dayslot tbody>tr:last');
        return false;
    });
    $('.remove-row-codott-dayslot').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
    $('#repeatable-fieldset-codott-dayslot tbody').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.sort'
    });

    $('#add-codott-roomslot-row').on('click', function() {
        var row = $('.empty-codott-roomslot-row.screen-reader-text').clone(true);
        row.removeClass('empty-codott-roomslot-row screen-reader-text');
        row.insertBefore('#repeatable-fieldset-codott-roomslot tbody>tr:last');
        return false;
    });
    $('.remove-row-codott-roomslot').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
    $('#repeatable-fieldset-codott-roomslot tbody').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.sort'
    });

    $('#add-codott-class-row').on('click', function() {
        var row = $('.empty-codott-class-row.screen-reader-text').clone(true);
        row.removeClass('empty-codott-class-row screen-reader-text');
        row.insertBefore('#repeatable-fieldset-codott-class tbody>tr:last');
        return false;
    });
    $('.remove-row-codott-class').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
    $('#repeatable-fieldset-codott-class tbody').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.sort'
    });

    $('#add-codott-courseslot-row').on('click', function() {
        var row = $('.empty-codott-courseslot-row.screen-reader-text').clone(true);
        row.removeClass('empty-codott-courseslot-row screen-reader-text');
        row.insertBefore('#repeatable-fieldset-codott-courseslot tbody>tr:last');
        return false;
    });
    $('.remove-row-codott-courseslot').on('click', function() {
        $(this).parents('tr').remove();
        return false;
    });
    $('#repeatable-fieldset-codott-courseslot tbody').sortable({
        opacity: 0.6,
        revert: true,
        cursor: 'move',
        handle: '.sort'
    });
});

jQuery(document).ready(function($){
    $('.codott_timetables_colorpick').wpColorPicker();
});
