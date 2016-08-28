var FormValidation = function () {

    // incoming Invoice form validation
    var handleValidation = function() {

        var form = $('#incomingInvoiceFrm');

        form.validate({
            errorElement: 'span', //default input error message container
            errorClass: 'help-block help-block-error', // default input error message class
            focusInvalid: false, // do not focus the last invalid input
            ignore: "",  // validate all fields including form hidden input
            rules: {
                total: {
                    required: true,
                    number: true
                },
                freetext : {
                    required : true
                },
            },

            highlight: function (element) { // hightlight error inputs
                $(element)
                    .closest('.form-group').addClass('has-danger'); // set danger class to the control group
            },

            unhighlight: function (element) { // revert the change done by hightlight
                $(element)
                    .closest('.form-group').removeClass('has-danger'); // set danger class to the control group
            },
            errorPlacement: function (error, element) {
                if (element.parent('.input-group').length || element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
                    error.insertAfter(element.parent());
                } else {
                    error.insertAfter(element);
                }
            },
            success: function (label) {
                label
                    .closest('.form-group').removeClass('has-danger'); // set success class to the control group
            },
        });

    };


    return {
        //main function to initiate the module
        init: function () {
            handleValidation();
        }
    };

}();

jQuery(document).ready(function() {
    FormValidation.init();
});