var Memberships = function () {

    var handleTables = function(){
        $('#memberships-datatable').DataTable({
            responsive : true,
            paginate:true,
            pageLength:10
        });
    };

    var handleRenew = function() {
        $('#renewBtn').click( function () {
            $this = $(this);
            var l = Ladda.create(this);
            notie.confirm('Really send?', 'Yes!', 'Cancel', function () {
                l.start();
                $.post("/admin/membership/renewal", function (data) {
                    if (data.mes == 'done') {
                        l.stop();
                        toastr['success'](data.description, "Success");
                        window.setTimeout('location.reload()', 1000);
                    }
                    else {
                        toastr['error'](data.mes, "Error");
                        l.stop();
                    }
                }, 'json');
            });
            return false;
        })
    };

    return {
        //main function to initiate the module
        init: function () {
            handleTables();
            handleRenew();
        }
    };

}();

jQuery(document).ready(function() {
    Memberships.init();
});