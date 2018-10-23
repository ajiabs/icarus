/************* Stripe initialization ***********/

Stripe.setPublishableKey(stripe_publishable_key);
  
function stripeResponseHandler(status, response) {
           
        console.log(response.error);
    if (response.error) {
        // re-enable the submit button
        $('#error_message_pay').hide();
        // show the errors on the form
        //$('#year').closest('.form-group').addClass('has-error has-danger');
        //$('#year').closest(".form-group").find(".help-block").append('<ul class="list-unstyled"><li>'+response.error.message+'</li></ul>')
        
        $('#error_message_pay').append('<ul class="list-unstyled"><li>'+response.error.message+'</li></ul>');
        $('#error_message_pay').show();
        $('#loading_div').hide();
        
    } else if($("#txtcardcode").val() == ""){
        $('#submit-button').removeAttr("disabled");
        $('#submit-button').button('reset');
        $('#submit-button').css("background-color", "rgb(148, 152, 150)");
        $(".alert").show();
        $(".alert").html("Please enter the security code");
        $(".alert").removeClass("hidden");
        $(".alert").addClass("alert-danger");

            //return false;
    }else {
        
        //return false;
        var form$ = $("#payment-form");
        // token contains id, last4, and card type
        var token = response['id'];
        // insert the token into the form so it gets submitted to the server
        form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");

        // and submit
       // form$.get(0).submit();

             $.ajax({
            url: 'subscribeplan',
            type: "POST",
            dataType: 'json',
            data: $("#payment-form").serialize(),
            success: function (result) {                
                if(result.status==1){
                    console.log("ASds");
                    $('#success_message').show();
                    //document.getElementById("submit-button").prop('disabled', true);
                    $('#success_message').append(result.message);
                    document.getElementById("payment-form").reset();
                    //setTimeout(function(){ location.reload(); }, 3000);
                    $('#loading_div').hide();
                    window.location.href = 'dashboard';
                    
                    //$('#paymentForm').show();
                }
                if(result.status==0){
                    $.each(result.errors, function( index, value ) {
                        $('#'+index).closest('.form-group').addClass('errorsec');
                        $('#'+index).closest(".form-group").find(".errortext").text(value);
                    });
                }
            //$('.mini-cart').empty().html(result.html);
            }
        });
    }
}

/************* Stripe initialization end *********/



/************ Payment form submit **************/
    //$("#submit-button").click(function(event) {
      /*  $("#payment-form").submit(function(event) {
        event.preventDefault();
    	
        
        $('#loading_div').show();
        //$('#loader').html('<img id="loader-img" alt="" src="http://adrian-design.com/images/loading.gif" width="100" height="100" align="center" />');
        // disable the submit button to prevent repeated clicks
        //$('#submit-button').attr("disabled", "disabled");
        //$('.submit-button').attr("disabled", "disabled");
        //$('#submit-button').button('loading');
        //$('.submit-button').css("background-color", "grey");
        var chargeAmount = 0; //amount you want to charge, in cents. 1000 = $10.00, 2000 = $20.00 ...
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $( "#date option:selected" ).val(),
            exp_year: $('.card-expiry-year').val()
        }, chargeAmount, stripeResponseHandler);
        return false; // submit from callback

       

    });*/

        $('#payment-form').validator().on('submit', function (e) {
            $('#loading_div').show();
            $('#error_message_pay').hide();
        if (e.isDefaultPrevented()) {
            e.preventDefault();

            $('#loading_div').hide();
        } else {
            var chargeAmount = 0; //amount you want to charge, in cents. 1000 = $10.00, 2000 = $20.00 ...
        // createToken returns immediately - the supplied callback submits the form if there are no errors
        e.preventDefault();
        if (confirm('Are you sure you want to proceed ?')) {
        Stripe.createToken({
            number: $('.card-number').val(),
            cvc: $('.card-cvc').val(),
            exp_month: $( "#date option:selected" ).val(),
            exp_year: $('.card-expiry-year').val()
        }, chargeAmount, stripeResponseHandler);
        return false; // submit from callback
    }
          
        // your ajax
        }
    });

  /************ Payment form submit End **************/
	

