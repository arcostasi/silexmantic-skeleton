
$(document).ready(function() {

    var
    changeSides = function () {
        $('.ui.shape').eq(0).shape('flip over').end().eq(1).shape('flip over').end().eq(2).
            shape('flip back').end().eq(3).shape('flip back').end();
    },
    validationRules = {
        firstName: {
            identifier: 'email',
            rules: [
                {
                    type: 'empty',
                    prompt: 'Por favor, entre com o e-mail'
                },
                {
                    type: 'email',
                    prompt: 'Por favor, entre com um e-mail válido'
                }
            ]
        }
    };

    $('.ui.dropdown').dropdown({
        on: 'hover'
    });

    $('.ui.form').form(validationRules, {
        on: 'blur'
    });

    $('.masthead .information').transition('scale in', 1000);

    setInterval(changeSides, 3000);

});