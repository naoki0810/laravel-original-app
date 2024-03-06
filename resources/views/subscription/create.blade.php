@extends('layouts.app')

@section('content')
<div class="container pt-4">
    <div class="row justify-content-center">
        <div class="card col-md-8 subscription-form">
            <form action="{{ route('subscription.store') }}" method="post" id="payment-form" class="subscription-form">
              @csrf

              {{-- カード情報 --}}
              <div class="form-group">
                  <label for="card-holder-name">支払い方法の登録</label>
                  <div>
                      <input id="card-holder-name" class="form-control subscription-form" type="text" placeholder="カード名義人">
                  </div>
                  <div id="card-element" class="w-100">
                  <!-- A Stripe Element will be inserted here. -->
                  </div>

                  <!-- Used to display form errors. -->
                  <div id="card-errors" role="alert"></div>
              </div>
              <input type="hidden" id="stripeToken" name="stripeToken">

              <div id="card-button" class="btn btn-warning mt-5" data-secret="{{ $intent->client_secret }}">登録</div>
            </form>
        </div>
    </div>
</div>
@endsection

{{-- jquery --}}
<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>

{{-- stripe.js --}}
<script src="https://js.stripe.com/v3/"></script>
<script>
    $(function() {
        console.log('hello1');
        // Create a Stripe client.
        const stripe = Stripe('{{ env('STRIPE_KEY') }}');
        console.log('hello2');

        

        // Create an instance of Elements.
        const elements = stripe.elements();
        console.log('hello3');


        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        const style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
            color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
        };
        console.log('hello4');


        // Create an instance of the card Element.
        const cardElement = elements.create('card', {style: style});
        console.log('hello5');


        // Add an instance of the card Element into the `card-element` <div>.
        cardElement.mount('#card-element');
        console.log('hello6');


        const cardHolderName = $("#card-holder-name");
        const cardButton     = $("#card-button");
        const clientSecret   = cardButton.data('secret');
        console.log('hello7');


        cardButton.on('click', async (e) => {
            cardButton.prop('disabled', true);
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: { name: cardHolderName.value }
                    }
                }
            );
        console.log('hello9');


            if (error) {
                // ユーザーに"error.message"を表示する…
                cardButton.prop('disabled', false);
        console.log('hello10');  

            } else {
                // カードの検証に成功した…
                cardButton.prop('disabled', false);
        console.log('hello11');


                // 支払い方法識別子
                const form = $('#payment-form');
                const hiddenInput = $("#stripeToken");
                hiddenInput.attr('value', setupIntent.payment_method);

                form.submit();
            }
            
        });
    })
</script>
