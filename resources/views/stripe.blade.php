<!DOCTYPE html>
  <html>
  <head>    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
        <form id="payment-form">
             <input type="text" value="{{ $data['name'] }}"  id="name" name="name" required>
             <br>
            <input type="email" value="{{ $data['email'] }}" id="email" name="email" required>
            <br>
            <input type="text" value="&#8377; {{ $data['amount'] }}"  id="amount" name="amount" required>
             
             <div id="card-element">

             </div>

             <button id="submit" class="paynow">Pay Now</button>

             <div id="card-errors" style="color: red;"></div>
             <div id="card-thank" style="color: green;"></div>
             <div id="card-message" style="color: green;"></div>
             <div id="card-success" style="color: green;font-weight:bolder"></div>
        </form>

    <script type="text/javascript">
        
        $('#card-success').text('');
        $('#card-errors').text('');
        var stripe = Stripe('pk_test_51QOKd1Jqq0GlErgSftxvp13t2G5AS4LSzOoUw8uXw9TxNKhyNBzUs9sSBz3wQGZGolJjvqesnrhGPW5BDk2O6fxF00mD4s1qCb');
        var elements = stripe.elements();
        $('#submit').prop('disabled', true);
        // Set up Stripe.js and Elements to use in checkout form
        var style = {
          base: {
            color: "#32325d",
          }
        };

        var card = elements.create("card", { style: style });
        card.mount("#card-element");


        card.addEventListener('change', ({error}) => {
          const displayError = document.getElementById('card-errors');
          if (error) {
            displayError.textContent = error.message;
            $('#submit').prop('disabled', true);

          } else {
            displayError.textContent = '';
            $('#submit').prop('disabled', false);

          }
        });

        var form = document.getElementById('payment-form');
        
        form.addEventListener('submit', function(ev) {
        $('.loading').css('display','block');

          ev.preventDefault();
          //cardnumber,exp-date,cvc
          stripe.confirmCardPayment('{{ $data["client_secret"] }}', {
            payment_method: {
              card: card,
              billing_details: {
                name: '{{ $data["name"] }}',
                email: '{{ $data["email"] }}'
              }
            },
            setup_future_usage: 'off_session'
          }).then(function(result) {
            $('.loading').css('display','none');
           
            if (result.error) {
            
              $('#card-errors').text(result.error.message);
            
            } else {
              if (result.paymentIntent.status === 'succeeded') {

            
                $('#card-success').text("payment successfully completed.");
              console.log(card);
                // setTimeout(
                //   function(){ window.location.href = "{{url('/success')}}"; 
                // }, 2000);
              }
              return false;
            }
          });
        });
    </script>

</body>
</html>