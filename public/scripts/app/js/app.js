if (view.fileJsExist) {
    action = `/${view.file}.js`;
} else {
    action = `/scripts/app/js/action/Base.js`;
}

const mainAction = action;

requirejs(
    [
        '/scripts/lib/PigFrameworkJS/App.js'
    ],
    function (App) {
        var app = new App();
        app.run();
    },
    function (err) {
        console.log(err);
    }
);