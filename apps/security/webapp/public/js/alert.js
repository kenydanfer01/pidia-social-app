//== Class definition

let Alert = function () {

    let e = Swal.mixin({
        buttonsStyling: false,
        target: "#page-container",
        confirmButtonText: "Aceptar",
        customClass: {
            confirmButton: "btn btn-success m-1",
            cancelButton: "btn btn-danger m-1",
            input: "form-control"
        }
    });

    //== Private functions
    let basic = function (message, state, title=false, icon=false) {
        e.fire(title, message, state)
    }

    return {
        info: function(message, title=false) {
            basic(message, 'info',title,'fa fa-check-square-o');
        },
        success: function(message, title=false) {
            basic(message, 'success',title,'fa fa-check-square-o');
        },
        warning: function(message, title=false) {
            basic(message, 'warning',title,'fa fa-exclamation-circle');
        },
        danger: function(message, title=false) {
            basic(message, 'error',title,'fa fa-times-circle');
        },
    };
}();