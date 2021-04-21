$(document).ready(function () {
    $('#myFormName').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'GET',
            url: 'https://wt35.fei.stuba.sk/cv6/api/',
            data: $('#myFormName').serialize(),
            success: function (msg) {
                var div = $("#myDiv");
                console.log(msg)
                div.html("")
                var i = 0;
                for (i = 0; i < msg.length; i++) {
                    for (const [key, value] of Object.entries(msg[i])) {
                        // console.log(`${key}: ${value}`);
                        div.html(div.html() + `${value}` + ", ")
                        // div.html(div.html()  + `${key}: ${value}`+ ", ")
                    }
                    div.html(div.html() + "<br>")
                }
            },
            error: function (msg) {
                console.log("chyba" + msg)
            }
        });
    });

    $('#myFormDate').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'GET',
            url: 'https://wt35.fei.stuba.sk/cv6/api/',
            data: $('#myFormDate').serialize(),
            success: function (msg) {
                var div = $("#myDiv");
                console.log(msg)
                div.html("")
                for (i = 0; i < msg.length; i++) {
                    for (const [key, value] of Object.entries(msg[i])) {
                        // console.log(`${key}: ${value}`);
                        div.html(div.html() + `${value}` + ", ")
                        // div.html(div.html()  + `${key}: ${value}`+ ", ")
                    }
                    div.html(div.html() + "<br>")
                }
            },
            error: function (msg) {
                console.log("chyba" + msg)
            }
        });
    });

    $('#mySpecialDay').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'GET',
            url: 'https://wt35.fei.stuba.sk/cv6/api/',
            data: $('#mySpecialDay').serialize(),
            success: function (msg) {
                var div = $("#myDiv");
                console.log(msg)
                div.html("")
                for (i = 0; i < msg.length; i++) {
                    for (const [key, value] of Object.entries(msg[i])) {
                        // console.log(`${key}: ${value}`);
                        div.html(div.html() + `${value}` + ", ")
                        // div.html(div.html()  + `${key}: ${value}`+ ", ")
                    }
                    div.html(div.html() + "<br>")
                }

            },
            error: function (msg) {
                console.log("chyba" + msg)
            }
        });
    });

    $('#myInsertForm').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'https://wt35.fei.stuba.sk/cv6/api/',
            data: $('#myInsertForm').serialize(),
            success: function (msg) {
                var div = $("#myDiv");
                console.log(msg)
                div.html("")
                for (i = 0; i < msg.length; i++) {
                    for (const [key, value] of Object.entries(msg[i])) {
                        // console.log(`${key}: ${value}`);
                        div.html(div.html() + `${value}` + ", ")
                        // div.html(div.html()  + `${key}: ${value}`+ ", ")
                    }
                    div.html(div.html() + "<br>")
                }
            },
            error: function (msg) {
                var div = $("#myDiv")
                div.html("CHYBA <br>")
                console.log("chyba" + msg[0])
            }
        });
    });
    $('#myPut').submit(function (e) {
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: 'https://wt35.fei.stuba.sk/cv6/api/',
            data: $('#myInsertForm').serialize(),
            success: function (msg) {
                var div = $("#myDiv");
                console.log(msg)
                div.html("")
                for (i = 0; i < msg.length; i++) {
                    for (const [key, value] of Object.entries(msg[i])) {
                        // console.log(`${key}: ${value}`);
                        div.html(div.html() + `${value}` + ", ")
                        // div.html(div.html()  + `${key}: ${value}`+ ", ")
                    }
                    div.html(div.html() + "<br>")
                }
            },
            error: function (msg) {
                var div = $("#myDiv")
                div.html("CHYBA <br>")
                console.log("chyba" + msg[0])
            }
        });
    });

    $("#myDELETE").click(function () {
        $.ajax({
            type: 'DELETE',
            url: 'https://wt35.fei.stuba.sk/cv6/api/',
            success: function (msg) {
                $("#myDiv").html(msg);
            }
        });
    });
    $("#myPUT").click(function () {
        $.ajax({
            type: 'PUT',
            url: 'https://wt35.fei.stuba.sk/cv6/api/',
            success: function (msg) {
                $("#myDiv").html(msg);
            }
        });
    });
});