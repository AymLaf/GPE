import toastr from 'toastr'
import {i18n} from "@core/Services/i18n.service";

toastr.options.closeButton = true;

const ToastrService = {
    success: function (message) {
        toastr.success(i18n.tc(message))
    },
    error: function (message) {
        toastr.error(i18n.tc(message))
    }
};

export default ToastrService;