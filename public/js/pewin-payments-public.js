(function( $ ) {

	'use strict';

    $(window).load(function() {

        var $form = $('#payment-form');
        var $errors = $form.find('.payment-errors');
        var $submit = $form.find('.submit');

        $form.submit(function(event) {
            if (!$form.find("input[name=token]").val()) {
                $errors.text("No token");
                return false;
            }
            return true;
        })

        $submit.click(function(event) {

            // Prevent the form from being submitted:
            event.preventDefault();

            // Disable the submit button to prevent repeated clicks:
            $submit.prop('disabled', true);

            // Request a token from Stripe:
            Stripe.card.createToken($form, function(status, response) {

                if (response.error) { // Problem!
                    // Show the errors on the form:
                    $errors.text(response.error.message);
                    $submit.prop('disabled', false); // Re-enable submission
                    return;
                }

                // Insert the token ID into the form so it gets submitted to the server:
                $form.find('input[name=token]').val(response.id);

                // Submit the form:
                $form.submit();

            });

            return false;

        });


    });

})( jQuery );
