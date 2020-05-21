var Script = function() {

    $().ready(function() {
        // validate the comment form when it is submitted
        //$("#feedback_form").validate();

        // validate signup form on keyup and submit
        $("#register_form").validate({
            rules: {
                nombres: {
                    required: true,
                    minlength: 4
                },
                apellidos: {
                    required: true,
                    minlength: 4
                },
                username: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: true,
                    minlength: 5
                },
                confirm_password: {
                    required: true,
                    minlength: 5,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    minlength: 10
                },
                topic: {
                    required: "#newsletter:checked",
                    minlength: 2
                },
                apikey: {
                    required: true,
                    minlength: 40
                },
                agree: "required"
            },
            messages: {
                nombres: {
                    required: "Introduzca Nombre",
                    minlength: "Your name must consist of at least 4 characters long."
                },
                apellidos: {
                    required: "Introduzca Apellidos",
                    minlength: "Your Full Name must consist of at least 4 characters long."
                },
                email: {
                    required: "Introduzca Correo Electrónico",
                    minlength: "Your Email must consist of at least 10 characters long."
                },
                username: {
                    required: "Introduzca nombre de Usuario",
                    minlength: "Your username must consist of at least 5 characters long."
                },
                password: {
                    required: "Introduzca Contraseña",
                    minlength: "Your password must be at least 5 characters long."
                },
                confirm_password: {
                    required: "Por favor confirme la Contraseña",
                    minlength: "Your password must be at least 5 characters long.",
                    equalTo: "Please enter the same password as above."
                },
                apikey: {
                    required: "Debe Generar un Api-Key",
                    minlength: "Your Api-Key must be at least 40 characters long."
                },
                //email: "Please enter a valid email address.",
                agree: "Acepta los Términos & Condiciones"
            }
        });

        // propose username by combining first- and lastname
        $("#username").focus(function() {
            var firstname = $("#firstname").val();
            var lastname = $("#lastname").val();
            if (firstname && lastname && !this.value) {
                this.value = firstname + "." + lastname;
            }
        });
        //code to hide topic selection, disable for demo
        var newsletter = $("#newsletter");
        // newsletter topics are optional, hide at first
        var inital = newsletter.is(":checked");
        var topics = $("#newsletter_topics")[inital ? "removeClass" : "addClass"]("gray");
        var topicInputs = topics.find("input").attr("disabled", !inital);
        // show when newsletter is checked
        newsletter.click(function() {
            topics[this.checked ? "removeClass" : "addClass"]("gray");
            topicInputs.attr("disabled", !this.checked);
        });
    });
}();