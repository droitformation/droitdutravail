@extends('layouts.master')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="page-header text-align-left">
                <div class="row">
                    <div class="col-md-8">
                        <h1 class="title uppercase">{{ $campagne->sujet }}</h1>
                        <h2 class="subtitle">{{ $campagne->auteurs }}</h2>
                    </div>
                    <div class="col-md-4 text-right">
                        @include('partials.soutien')
                    </div>
                </div>
            </div><!--END PAGE-HEADER-->
        </div>
    </div>

    <div class="row">
        <div id="inner-content" class="col-md-8 col-xs-12">

            @if(!empty($content))
                @foreach($content as $bloc)
                    {!! view('frontend/content/'.$bloc->type->partial)->with( ['bloc' => $bloc ,'categories' => $categories, 'imgcategories' => $imgcategories ])->__toString()  !!}
                @endforeach
            @endif
        </div>

        <!-- Sidebar  -->
        <div id="sidebar" class="col-md-4 col-xs-12">
            @include('partials.liste')
            @include('partials.pub')
        </div>
        <!-- END Sidebar  -->

    </div><!--END CONTENT-->

@stop
