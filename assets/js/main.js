var $ = require('jquery')
// any CSS you require will output into a single css file (app.css in this case)
require('../css/app.css');


$(function () {
    var options = {
        valueNames: ['name', 'category', 'price', 'code', 'date']
    };
    var hackerList = new List('users', options);

    $('#alert').hide()
    var spc_nom;
    //$("input[type^='checkbox']").first().hide();

    /*------------- AJOUTER UNE SPECIALITE STATIQUE  ---------------*/
    $('#btn_spcl').click(function () {
        spc_nom = $('#nomspecialite').val()

        $.ajax({
            url: "/admin/specialite_ajout_ajax",
            type: "POST",
            dataType: "json",
            data: {
                "specialite_static": spc_nom,
            },
            async: true,
            success: function (data) {
                $('#alert').append('<p>' + data.message + '</p>') /* location.reload(true);*/
                $('#alert').show()
                setTimeout(function () {
                    $("#alert").hide()
                }, 2000);
            },
            error: function (xhr, textStatus, errorThrown) {
                alert('Ajax request failed.');
            }
        })

    })
    /*----------------------------------------------------------------*/


    $("#submitButton").click(function () {
        var selected = [];
        $('input:checked').each(function () {
            selected.push($(this).val());
        });
        console.log(selected);
    });

    /* AJOUTER UNE FORAMTION AVEC LES SPECIALITES SELECIONEES  */
    $('#ajout').click(function () {

        var spc = $("#formation_name").val()
        var disc = $("#formation_discription").val()
        var selected = [];
        $('#formation_Specialite option:selected').each(function () {

            selected.push($(this).val());
        });
        selected.getValue
        $.ajax({
            url: "/admin/formation/formation_ajax",
            type: "POST",
            dataType: "json",
            data: {
                "spc": spc,
                "disc": disc,
                "specialite_formation": selected,
            },
            async: true,
            success: function (data) {
                if (data.message === 1) {
                    location.reload(true);
                } else {
                    window.alert("faut avoir des specialites sur cette formation")
                }

            },
            error: function (xhr, textStatus, errorThrown) {
                alert('Ajax request failed.');
            }
        })

    });
    /*---------------------------------------------------*/

    $('.bdg').each(function (index) {
        $('#module_nom').tagsinput('add', $(this).text());
    });

    $("span[data-role='remove']").click(function () {
        console.log($(this).parent().text());
    })
    /*---------------------- AJOUTER LES MODULES POUR LA SPECIALITE SELECTIONEE -----*/
    $('#module_nom').on('itemAdded', function (event) {
        console.log(event.item);
        console.log($('#nomspecialite').html());

        $.ajax({
            url: "/admin/specialite/module_add_ajax",
            type: "POST",
            dataType: "json",
            data: {
                "add": event.item,
                "id": $('#nomspecialite').html()
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
    /*------------------------------------------------------------------------------*/

    /*-------------------- SUPPRIMER LE MODULE -----------------*/
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
    /*-------------------------------------------------*/
    $('.delete').each(function () {
        $(this).on('click', function () {
            var specialite_formation_selected = $(this).siblings().html()
            console.log(specialite_formation_selected)
            $.ajax({
                url: "/admin/specialite_formation_delete",
                type: "POST",
                dataType: "json",
                data: {
                    "specialite": specialite_formation_selected,
                },
                async: true,
                success: function (data) {
                    location.reload();
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('Ajax request failed.');
                }
            })
        })
    })

    $('#ajouter_specialite_edit').click(function () {

        var formation_id = $("#formation_id").html()
        var selected = [];
        $('#formation_Specialite option:selected').each(function () {

            selected.push($(this).val());
        });
        selected.getValue
        $.ajax({
            url: "/admin/specialite_formation_add",
            type: "POST",
            dataType: "json",
            data: {
                "formation_id": formation_id,
                "specialite_formation": selected,
            },
            async: true,
            success: function (data) {
                if (data.message == null) {
                    location.reload(true);
                } else {
                    window.alert(data.message)
                }
            },
            error: function (xhr, textStatus, errorThrown) {
                alert('Ajax request failed.');
            }
        })

    });
    /*-----------------------------------------------*/
    /*$('.bdg').each(function (index) {
        $('#specialite_name').tagsinput('add', $(this).text());
    });
    var id_spc = $(".id_spc").text()
    $("span[data-role='remove']").click(function () {
        console.log($(this).parent().text());
    })
    $('#specialite_name').on('itemAdded', function (event) {
        console.log(event.item);

        $.ajax({
            url: "/admin/formation/specialite_add_ajax",
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
    $('#specialite.name').on('itemRemoved', function (event) {
        $.ajax({
            url: "/admin/formation/specialite_delete_ajax",
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
    });*/

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
    }, 2000);
});