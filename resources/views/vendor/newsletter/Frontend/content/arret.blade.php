<div class="row" style="margin-top: 20px;">
    <div class="col-md-9">
        <h2>{{ $bloc->arret->reference }} du {{ $bloc->arret->pub_date->formatLocalized('%d %B %Y') }}</h2>
        <p>{!! $bloc->arret->abstract !!}</p>

        {!! $bloc->arret->pub_text !!}
        @if(isset($bloc->arret->file))
            <p><a target="_blank" href="{{ asset(config('newsletter.path.arret').$bloc->arret->file) }}">Télécharger en pdf</a></p>
        @endif
    </div>
    <div class="col-md-3">
        @if(!$bloc->arret->categories->isEmpty() )
            @foreach($bloc->arret->categories as $categorie)
                <a target="_blank" href="{{ url(config('newsletter.link.arret')) }}#{{ $bloc->reference }}">
                    <img style="max-width: 130px;" border="0"  alt="{{ $categorie->title }}" src="{{ asset(config('newsletter.path.categorie').$categorie->image) }}">
                </a>
            @endforeach
        @endif
    </div>
    <div class="clear"></div>
</div>

@if(!$bloc->arret->analyses->isEmpty())
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-9">

            @foreach($bloc->arret->analyses as $analyse)
                @include('vendor.newsletter.Frontend.content.analyse', ['analyse' => $analyse, 'arret' => $bloc->arret])
            @endforeach

        </div>
        <div class="col-md-3">
            <a href="{{ url('jurisprudence') }}">
                <img border="0" alt="Analyses" src="<?php echo asset('files/pictos/analyse.png') ?>">
            </a>
        </div>
    </div>
@endif
