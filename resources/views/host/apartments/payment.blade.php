@extends('layouts.dashboard')
@section('title', 'Concludi il pagamento')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h1 class="font-weight-bold">Concludi il pagamento</h1>
            
            <form action="{{route('host.apartments.advertise.checkout', ['id'=>$apartment->id, 'advertise_id'=>$advertise->id])}}" id="payment-form" method="POST">
            @csrf
            @method('POST')
            <div id="dropin-container"></div>
            <button type="submit" class="btn btn-primary">Paga</button>
            <input type="hidden" name="payment_method_nonce" id="nonce" />
            </form>
            
            <div id="clientToken" class="d-none">
                @php
                    echo $clientToken;
                @endphp
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    let form = document.getElementById('payment-form');
    let token = document.getElementById('clientToken').innerHTML;
    braintree.dropin.create({
        authorization: token,
        container: document.getElementById('dropin-container')
    }, (err, instance)=>{
        if(err) console.log(err);

        form.addEventListener('submit', (event) =>{
            event.preventDefault();
            instance.requestPaymentMethod((err, payload)=>{
                if(err) console.log(err);
                document.getElementById('nonce').value = payload.nonce;
                form.submit();
            })
        })
    })
</script>
@endsection