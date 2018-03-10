"use strict"

class Categories {
    constructor() {
        let $categories = $("select#categories");
        if ($categories.length > 0) {
            require('select2');
            $.fn.select2.defaults.set( "theme", "bootstrap4" );

            $categories.select2({
                createTag: function(params) {
                    return undefined;
                },
                tags: true
            });
        }

    }
}

module.exports = new Categories();