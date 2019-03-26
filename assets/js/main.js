var $ = require('jquery')
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');



$(function () {
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function () {
        $("#successMessage").hide()
    }, 5000);
});