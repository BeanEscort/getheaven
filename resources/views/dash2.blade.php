@extends('layouts.template')
@section('content')

<div id="content" class="main-content">
    <div class="row mt-4">
        <div class="col-lg-8 col-md-8 col-sm-12">
            <div class="layout-px">
                <div class="widget-content-area">
                    <div class="widget-one">

                        {!! $chartMortesxMes->container() !!}

                        <script src="{{ asset('vendor/larapex-charts/apexcharts.js') }}"></script>
                        
                        {{ $chartMortesxMes->script() }}
                         
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12">
            <div class="layout-px">
                <div class="widget-content-area">
                    <div class="widget-one">

                        {!! $chartMortesxSemana->container() !!}

                        {{ $chartMortesxSemana->script() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 mt-2">
            <div class="layout-px">
                <div class="widget-content-area">
                    <div class="widget-one">
                    {!! $chartFalecidosxMes->container() !!}

                    {{ $chartFalecidosxMes->script() }}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection