@extends('master')

@section('title', 'Checkout')

@section('content')
    <div class="row mt-3 mb-3">
        <div class="col-md-4 order-md-2 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                Plano Escolhido
            </h4>
            <ul class="list-group mb-3">
                <li class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{$plan->name}}</h6>
                    </div>
                    <span class="text-muted">{{$plan->price}}</span>
                </li>
            </ul>

            <div class="row">
                <div class="col-12">
                    <h3 style="background-color:#000;color:#fff;padding:2px 4px;">Feedback</h3>
                    <span id="response">

                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-8 order-md-1">
            <h4 class="mb-3">Dados Pessoais</h4>

            <form method="post" id="form-checkout" action="{{route('checkout')}}" onSubmit="processCheckout()" novalidate>
                {{ csrf_field() }}

                <input type="hidden" id="plan_id" name="plan_id" value="{{$plan->id}}"/>

                <div class="mb-3">
                    <label for="name">Nome Completo</label>
                    <input type="text" class="form-control" name="name" id="name" placeholder="" value="" required>
                </div>


                <div class="form-row">

                    <div class="mb-3 col-md-4">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="phone_number">Telefone/Celular</label>
                        <input type="tel" class="form-control" name="phone_number" id="phone_number" placeholder="99 99999-9999">
                    </div>

                    <div class="mb-3 col-md-4">
                        <label for="document">CPF</label>
                        <input type="text" class="form-control" name="document" id="document">
                    </div>

                </div>

                <div class="form-row">
                    <div class="col-md-10">
                        <label for="address">Endereço</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Av. ABCDEF" required>
                    </div>

                    <div class="col-md-2">
                        <label for="street_number">Número</label>
                        <input type="text" class="form-control" id="street_number" name="street_number" placeholder="" required>
                    </div>
                </div>

                <div class="row">

                    <div class="col-md-4 mb-3">
                        <label for="state">Estado</label>
                        <select class="custom-select d-block w-100" id="state" name="state" required>
                            <option value="">- Escolha -</option>
                            <option value="CE">Ceará</option>
                            <option value="ES">Espirito Santo</option>
                            <option value="PI">Piauí</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="city">Cidade</label>
                        <input type="text" class="form-control" id="city" name="city" placeholder="" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="zipcode">CEP</label>
                        <input type="text" class="form-control" id="zipcode" name="zipcode" placeholder="" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5 mb-3">
                        <label for="country">País</label>
                        <select class="custom-select d-block w-100" id="country" name="country" required>
                            <option value="BR">Brasil</option>
                        </select>
                    </div>
                </div>
                <hr>
                <div class="row">

                    <div class="col-md-12">
                        <h4 class="mb-3">Pagamento</h4>
                    </div>

                    <div class="col mb-3">
                        <label for="">Forma de Pagamento</label>
                        <select class='custom-select d-block' name="payment_method" id="paymentMethod">
                            <option value="">- escolha -</option>
                            <option value="boleto">Boleto Bancário</option>
                            <option value="credit">Cartão de Crédito</option>
                        </select>
                    </div>
                </div>

                <div id="ShowOnlyIfIsCard" style="display:none;">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cc-name">Nome Impresso no Cartão</label>
                            <input type="text" class="form-control" name="card_holder_name" id="card_holder_name" placeholder="ADAM N GHOST" required>
                            <small class="text-muted">Exatamente como está impresso no cartão</small>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="cc-number">Número</label>
                            <input type="text" class="form-control" id="card_number" name="card_number"  placeholder="0000 0000 0000 0000" required>
                            <span class="text-muted small">Cartão de teste: 4111 1111 1111 1111</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">Data de Validade</label>
                            <input type="text" class="form-control" id="card_due_date" name="card_due_date" placeholder="MM/YYYY" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="cc-expiration">CVV</label>
                            <input type="text" class="form-control" id="card_cvv" name="card_cvv" placeholder="" required>
                            <small class="text-muted">Código de Segurança</small>
                        </div>
                    </div>
                </div>
                <hr class="mb-4">
                <button class="btn btn-primary btn-lg btn-block" id="btn-submit" type="submit">Efetuar Pagamento</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script>
        $(function(){
            $('#paymentMethod').on('change', function(){
                var paymentMethod = $(this).val();

                if(paymentMethod === 'credit')
                {
                    $('#ShowOnlyIfIsCard').slideDown(500, function(){
                        $('#card_holder_name').focus();
                    });
                }else{
                    $('#ShowOnlyIfIsCard').slideUp(500);
                }
            })
        });

        var btnSubmit = document.getElementById('btn-submit');

        function processCheckout(){
            event.preventDefault();
            showPreloader();

            let responseDiv = document.getElementById('response');

            axios.post('{{route('checkout')}}',
                {
                    'name' : document.getElementById('name').value,
                    'email' : document.getElementById('email').value,
                    'document' : document.getElementById('document').value,
                    'address' : document.getElementById('address').value,
                    'street_number' : document.getElementById('street_number').value,
                    'city' : document.getElementById('city').value,
                    'state' : document.getElementById('state').value,
                    'zipcode' : document.getElementById('zipcode').value,
                    'country' : document.getElementById('country').value,
                    'phone_number' : document.getElementById('phone_number').value,
                    'payment_type_code' : document.getElementById('paymentMethod').value,

                    'creditcard' : {
                        'card_name': document.getElementById('card_holder_name').value,
                        'card_due_date': document.getElementById('card_due_date').value,
                        'card_number': document.getElementById("card_number").value,
                        'card_cvv': document.getElementById('card_cvv').value,
                        'auto_capture': true
                    },

                    'plan_id' : document.getElementById('plan_id').value
                })
                .then(response => {
                    if(response.data.error === true)
                    {
                        console.log('Houve um problema: ' + response.data.error)
                        responseDiv.innerHTML =  response.data.message
                        alert(response.data.message);
                    }else{
                        //limpa formulario
                        document.getElementById('form-checkout').reset();

                        if(response.data.boleto_url)
                        {
                            console.log('Boleto gerado com sucesso!')
                            responseDiv.innerHTML = 'Boleto gerado com sucesso: ' + response.data.boleto_url
                            window.open(response.data.boleto_url, '_blank')
                        }else{
                            console.log(response.data.message)
                            responseDiv.innerHTML = response.data.message
                            alert(response.data.message);
                        }


                    }
                })
                .catch(error => {
                    console.log(error)
                }).finally(
                    () => hidePreloader()
                )
        }

        function showPreloader(){
            console.log('Preloader iniciado...');
            btnSubmit.classList.add('disabled');
            btnSubmit.innerHTML = 'Carregando...';
        }

        function hidePreloader() {
            console.log('Parando preloader...');
            btnSubmit.classList.remove('disabled');
            btnSubmit.innerHTML = 'Realizar Pagamento';
        }
    </script>
@endpush