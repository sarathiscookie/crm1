var LaraspaceForms = function () {

    var handleSelect2 = function(){
        $(".ls-select2").select2();
    };

    var handleBootstrapSelect = function(){
        $(".ls-bootstrap-select").selectpicker({
            iconBase: 'fa',
            tickIcon: 'fa-check',
            container: 'body'
        });
    };

    var handleSwitchToggles = function(){
        var elems = $('.ls-switch');

        elems.each(function(index,element) {
            var color = $(this).data('color') ? $(this).data('color') : '#ffde00';
            var size = $(this).data('size') ? $(this).data('size') : 'default';

            var switchery = new Switchery(this, {
                color : color,
                size : size
            });
        });
    };

    var handleTimePickers = function(){
        $('.ls-clockpicker').clockpicker({
            donetext: 'Done'
        });


        var elems = $('.ls-timepicker');

        elems.each(function(index,element) {
            var timeFormat = $(this).data('format') ? $(this).data('format') : 'g:ia';
            var showDuration = $(this).data('duration') ? $(this).data('duration') : false;

            $(this).timepicker({
                timeFormat : timeFormat,
                showDuration : showDuration,
                minTime: '2:00pm',
                maxTime: '11:30pm'
            });
        });


    };

    var handleMultiSelect = function(){
        $('.ls-multi-select').multiSelect()
    };

    var handleDatePicker = function(){
        $('.ls-datepicker').datepicker();
    };

    var handleEditors = function(){
        $('.ls-summernote').summernote();

        var editor = $('.ls-simplemde')[0];

        if(editor){
            var simplemde = new SimpleMDE({ element: editor });
        }

    };



    return {
        //main function to initiate the module
        init: function () {
            handleSelect2();
            handleBootstrapSelect();
            handleSwitchToggles();
            handleTimePickers();
            handleDatePicker();
            handleMultiSelect();
            handleEditors();
        }
    };

}();

jQuery(document).ready(function() {
    LaraspaceForms.init();
});

