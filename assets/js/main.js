var $ = require('jquery')
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');


$(function () {
    /*--------------------ajax ---------------*/
    $('#ajout').click(function () {
        var spc = $("#specialite_name").val()
        $.ajax({
            url: "/admin/specialite_ajax",
            type: "POST",
            dataType: "json",
            data: {
                "spc": spc
            },
            async: true,
            success: function (data) {
                location.reload(true);

            },
            error: function (xhr, textStatus, errorThrown) {
                alert('Ajax request failed.');
            }
        })

    });
    /*-----------------------------------------------*/
    $('.bdg').each(function (index) {
        $('#module_nom').tagsinput('add', $(this).text());
    });
    var id_spc = $(".id_spc").text()
    $("span[data-role='remove']").click(function () {
        console.log($(this).parent().text());
    })
    $('#module_nom').on('itemAdded', function (event) {
        console.log(event.item);

        $.ajax({
            url: "/admin/specialite/module_add_ajax",
            type: "POST",
            dataType: "json",
            data: {
                "add": event.item,
                "id": id_spc
            },
            async: true,
            success: function (data) {
                console.log(data);

            },
            error: function (xhr, textStatus, errorThrown) {
                alert('Ajax request failed.');
            }
        })
    });
    $('#module_nom').on('itemRemoved', function (event) {
        $.ajax({
            url: "/admin/specialite/module_delete_ajax",
            type: "POST",
            dataType: "json",
            data: {
                "module": event.item,
            },
            async: true,
            success: function (data) {
                console.log(data);

            },
            error: function (xhr, textStatus, errorThrown) {
                alert('Ajax request failed.');
            }
        })
    });
    $('#hide').hide();
    $('#button-add').click(function () {
        $('#hide').slideToggle();
        if ($("#btn-slide").hasClass('fa-chevron-down')) {
            $("#btn-slide").removeClass("fa-chevron-down").addClass("fa-chevron-up")
        } else {
            $("#btn-slide").removeClass("fa-chevron-up").addClass("fa-chevron-down")
        };

    });
    // setTimeout() function will be fired after page is loaded
    // it will wait for 5 sec. and then will fire
    // $("#successMessage").hide() function
    setTimeout(function () {
        $("#successMessage").hide()
    }, 5000);
});