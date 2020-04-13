import toastr from 'toastr'

toastr.options.closeButton = true;

const ToastrService = {
    success: function (message) {
        toastr.success(message)
    },
    error: function (message) {
        toastr.error(message)
    }
};

export default ToastrService;