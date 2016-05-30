
@extends('layouts.master')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="page-header text-align-left">

            <div class="row">
                <div class="col-md-8">
                    <h1 class="title uppercase">Nouveautés dans le domaine du droit du travail</h1>
                </div>
                <div class="col-md-4 text-right">
                    @include('partials.soutien')
                </div>
            </div>

        </div><!--END PAGE-HEADER-->
    </div>
</div>

<div class="row">
    <div id="inner-content" class="col-md-8">

        @include('partials.message')

        <div id="about"><img width="100%" alt="Droit du travail" src="{{ asset('images/header.jpg') }}" /></div><!--END SECTION-->

        @if(!empty($homepage))
            @foreach($homepage as $index => $contenu)
                <div class="row"><!-- Start row -->
                    @foreach($contenu['blocs'] as $bloc)
                        <div class="col-md-<?php echo 12/$contenu['count']; ?>">
                            @if($index == 1)
                                <h3 class="title">{{ $bloc->titre }}</h3>
                            @else
                                <h4 class="title <?php echo ( $contenu['count'] > 1 ? 'home-bloc' : ''); ?>">{{ $bloc->titre }}</h4>
                            @endif
                            <p>{!! $bloc->contenu !!}</p>
                        </div>
                    @endforeach
                </div><!-- end row -->
                <div class="divider-<?php echo (count($homepage) == $index ? 'noborder' : 'border' ); ?>"></div>
            @endforeach
        @endif

    </div>

    <!-- Sidebar  -->
    <div id="sidebar" class="col-md-4 col-xs-12">
        @include('partials.subscribe')
        @include('partials.pub')
        @include('partials.latest')
    </div>
    <!-- END Sidebar  -->

</div><!--END CONTENT-->

@stop