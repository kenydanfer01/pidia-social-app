let CRUDList = function () {
    let generateRoute = function (route) {
        route = route + "?" + 'limit=' + $('#filter_size option:selected').val();
        route = route + "&" + 'b=' + $('#filter_text').val();

        return route
    }

    let execute = function (route) {
        $(document).on('change', '#filter_size', function () {
            window.location = generateRoute(route);
        });

        $(document).on('keyup', '#filter_text', function (e) {
            let code = e.key;
            if(code==="Enter"){
                window.location = generateRoute(route);
            }
        });

        $(document).on('click', '.btn-send, #filter_text_icon', function () {
            window.location = generateRoute(route);
        });

        $(document).on('click', '.btn-clean', function () {
            window.location.href = route;
        });
    };

    return {
        init: function (route) {
            execute(route);
        },
    };
}();
