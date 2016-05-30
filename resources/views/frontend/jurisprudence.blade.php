@extends('layouts.master')
@section('content')
@include ('partials.small-banner')
<?php $custom = new \App\Droit\Helper\Helper(); ?>

<div class="page-header text-align-left">
    <div class="row">
        <div class="col-md-8">
            <h1 class="title uppercase">Jurisprudence</h1>
        </div>
        <div class="col-md-4 text-right">
            @include('partials.soutien')
        </div>
    </div>
</div><!--END PAGE-HEADER-->

<div class="row">
    <div id="filteringApp" ng-app="filtering">
        <div id="inner-content" class="col-md-8 col-xs-12">
            <div id="filtering">
                <div class="arrets">

                    @include('frontend.content.analyse')

                    @if(!empty($arrets))

                        <h4 class="title-section-top"><i class="fa fa-university"></i> &nbsp;&nbsp;Jurisprudence</h4>

                        @foreach($arrets as $post)
                            @include('frontend.content.post')
                        @endforeach
                    @endif

                </div>
            </div>
        </div>

        <!-- Sidebar  -->
        <div class="col-md-4 col-xs-12">
            <div class="fixed">
                @include('partials.filter')
            </div>
        </div>
        <!-- END Sidebar  -->

    </div><!--END CONTENT-->
</div><!--END CONTENT-->

@stop
