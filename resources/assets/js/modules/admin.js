"use strict"

class Admin {
    constructor() {
        this.confirmModal();
    }

    confirmModal() {
        $('#confirm-delete').on('show.bs.modal', function (event) {
            let $eventRaiser = $(event.relatedTarget);
            let target = $eventRaiser.data('href');
            
            let $modal = $(this);
            $modal.find('form[name=delete-form]').attr('action', target);
        });
    }
}



module.exports = new Admin();