<div class="widget">
    <h3 class="title"><i class="icon-envelope"></i> &nbsp;Newsletter</h3>
    <ul class="bra_recent_entries">

        @if(isset($year_news) && !$year_news->isEmpty())
            @foreach($year_news as $campagnes)
                <li>
                    <span class="date">{{ $campagnes->created_at->formatLocalized('%d %B %Y') }}</span>
                    <a href="{{ url('newsletter/campagne/'.$campagnes->id )}}">{{ $campagnes->sujet }}</a>
                    <p>{{ $campagnes->auteurs }}</p>
                </li>
            @endforeach
        @else
            <p>Aucune newsletter pour le moment</p>
        @endif

        <h5><a class="text-primary" href="{{ url('archive') }}"><i class="fa fa-archive" aria-hidden="true"></i> &nbsp;Archives</a></h5>

    </ul><!--END UL-->
</div><!--END WIDGET-->

<p class="divider-border"></p>
