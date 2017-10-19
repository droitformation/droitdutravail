@if(isset($pub) && !$pub->isEmpty())

    <div class="widget">
        <h3 class="title"><i class="glyphicon glyphicon-pushpin"></i> &nbsp;New</h3>

        @foreach($pub as $ad)

            @if( !empty($ad->titre) && !empty($ad->url) && !empty($ad->image))
                <div class="media">
                    <div class="media-body">
                        <a class="media-left pull-left" style="margin-right: 10px; margin-bottom: 5px;" target="_blank" href="{{ $ad->url }}">
                            <img style="max-width: 130px;" src="{{ url('files').'/'.$ad->image }}" alt="{{{ $ad->titre or 'image' }}}" />
                        </a>
                        <h4 class="media-heading">{{ $ad->titre }}</h4>
                        
                        <div style="text-align: justify; margin-bottom: 5px;">{!! $ad->contenu or '' !!}</div>
                        <a class="button small grey" target="_blank" href="{{ $ad->url }}">En savoir plus</a>
                    </div>
                </div>
            @elseif(!empty($ad->url) && !empty($ad->image))
                <div class="media">
                    <a class="pub-image-simple" target="_blank" href="{{ $ad->url }}">
                        <img style="max-width:100%;" src="{{ url('files').'/'.$ad->image }}" alt="{{{ $ad->titre or 'image' }}}" />
                    </a>
                </div>
            @elseif(!empty($ad->image))
                <div class="media">
                    <img src="{{ url('files').'/'.$ad->image }}" alt="{{{ $ad->titre or 'image' }}}" />
                </div>
            @endif

        @endforeach

    </div><!--END WIDGET-->

    <p class="divider-border"></p>
@endif