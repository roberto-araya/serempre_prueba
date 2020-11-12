(function ($) {
  Drupal.behaviors.validadorRegistroUsuario = {
    attach: function (context, settings) {
      $.validator.addMethod("accept", function (value, element, param) {
        return value.match(new RegExp("^" + param + "$"));
      })

      $( "#usuario_registro_form" ).validate();
    }
  };

}(jQuery));
