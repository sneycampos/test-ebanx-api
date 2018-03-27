@extends('master')

@push('header')
    <link rel="stylesheet" href="{{asset('css/style.css')}}" />
@endpush

@section('content')
    <div class="row">
        <div class="col mt-3 mb-3">
            <h3 class="text-center">Escolha um plano</h3>
        </div>
    </div>

    @foreach($plans as $plan)
        <div class="row mb-1">
            <div class="col-md-6 offset-3">
                <div class="card">
                    <a href="{{url('checkout',$plan->id)}}">
                        <div class="card-header">
                            {{$plan->name}} - R$ {{number_format($plan->price,2,',','.')}}
                        </div>
                    </a>
                    {{--<div class="card-body"></div>--}}
                </div>
            </div>
        </div>
    @endforeach

@endsection
