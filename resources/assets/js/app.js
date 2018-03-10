"use strict"

require('./bootstrap');


$(() => {
    let $body = $(document).find('body');

    if ($body.length == 0) {
        return;
    }

    let module = $body.data('module');

    if (module) {
        require(`./modules/${module}.js`);
    }

    require('./utils/categories');
});

