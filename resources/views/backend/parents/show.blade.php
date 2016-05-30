@extends('backend.layouts.master')
@section('content')

<div class="row"><!-- row -->
    <div class="col-md-12"><!-- col -->
        <p><a class="btn btn-default" href="{!! url('admin/parent') !!}"><i class="fa fa-reply"></i> &nbsp;Retour à la liste</a></p>
    </div>
</div>
<!-- start row -->
<div class="row">

    @if (!empty($parent))

    <div class="col-md-12">
        <div class="panel panel-midnightblue">

            <!-- form start -->
            <form action="{!! url('admin/parent/'.$parent->id) !!}" enctype="multipart/form-data" method="POST" class="validate-form form-horizontal" data-validate="parsley">
                <input type="hidden" name="_method" value="PUT">{!! csrf_field() !!}
                <div class="panel-heading">
                    <h4>&Eacute;diter {!! $parent->title !!}</h4>
                </div>
                <div class="panel-body event-info">
                    <div class="form-group">
                        <label for="message" class="col-sm-3 control-label">Titre</label>
                        <div class="col-sm-3">
                            {!! Form::text('title', $parent->title , array('class' => 'form-control') ) !!}
                        </div>
                    </div>
                    @if(!empty($parent->image ))
                        <div class="form-group">
                            <label for="file" class="col-sm-3 control-label">Fichier</label>
                            <div class="col-sm-3">
                                <div class="list-group">
                                    <div class="list-group-item text-center">
                                        <a href="#"><img height="120" src="{!! asset('newsletter/pictos/'.$parent->image) !!}" alt="{{ $parent->title }}" /></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="form-group">
                        <label for="file" class="col-sm-3 control-label">Changer l'image</label>
                        <div class="col-sm-7">
                            <div class="list-group">
                                <div class="list-group-item">
                                    {!! Form::file('file') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-footer mini-footer ">
                    <div class="col-sm-3">{!! Form::hidden('id', $parent->id )!!}</div>
                    <div class="col-sm-6">
                        <button class="btn btn-primary" type="submit">Envoyer </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @endif

</div>
<!-- end row -->

@stop