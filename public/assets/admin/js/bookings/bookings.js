var Bookings = function () {

    var handleTables = function(){
        $('#bookings-datatable').DataTable({
            responsive : true,
            paginate:true,
            pageLength:10
        });
    };

    var handleStatus = function() {
        $('.statusChange').on('change', function () {
            $this = $(this);
            var status  = $this.val();
            var id = $this.attr('id').split('_')[1];
            $.post("/admin/booking/status", { orderid: id, status: status }, function (data) {
                if(data.mes=='done'){
                    toastr['success']('Status updated', "Success");
                    window.setTimeout('location.reload()', 1000);
                }
                else{
                    toastr['error'](data.mes, "Error");
                }
            },'json');
            return false;
        });
    };

    return {
        //main function to initiate the module
        init: function () {
            handleTables();
            handleStatus();
        }
    };

}();

jQuery(document).ready(function() {
    Bookings.init();
});