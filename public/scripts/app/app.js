if (view.fileJsExist) {
    action = `/${view.file}.js`;
} else {
    action = `/scripts/app/action/Base.js`;
}

const mainAction = action;
// console.log(mainAction);

requirejs(
    [
        '/scripts/lib/Pig/App.js'
    ],
    function (App) {
        var app = new App();
        app.run();
    },
    function (err) {
        console.log(err);
    }
);