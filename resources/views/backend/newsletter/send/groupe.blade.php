@if(isset($bloc->arrets) && !$bloc->arrets->isEmpty())

    <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
        <tr bgcolor="ffffff">
            <td colspan="3" height="35"> </td>
        </tr><!-- space -->
        <tr bgcolor="ffffff" class="blocBorder">
            <td width="400" align="left" class="resetMarge contentForm" valign="top">
                <h3 style="text-align: left;font-family: sans-serif;">{{ $categories[$bloc->categorie] }}</h3>
            </td>
            <td width="160" align="center" valign="top" class="resetMarge">
                <img width="130" border="0" src="{{ asset('newsletter/pictos/'.$bloc->image) }}" alt="{{ $categories[$bloc->categorie] }}" />
            </td>
        </tr><!-- space -->
    </table>

    <!-- Bloc content-->

    @foreach($bloc->arrets as $arret)

        <!-- Bloc content-->
        <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
            <tr bgcolor="ffffff"><td colspan="3" height="35"></td></tr><!-- space -->
            <tr>
                <td valign="top" width="375" class="resetMarge contentForm">
                    <div>
                        <?php setlocale(LC_ALL, 'fr_FR.UTF-8');?>
                        <h3 style="text-align: left;font-family: sans-serif;">{{ $arret->reference }} du {{ $arret->pub_date->formatLocalized('%d %B %Y') }}</h3>
                        <p class="abstract">{!! $arret->abstract !!}</p>
                        <div>{!! $arret->pub_text !!}</div>
                        <p><a href="{{ asset('files/arrets/'.$arret->file) }}">Télécharger en pdf</a></p>
                    </div>
                </td>
                <td width="25" height="1" class="resetMarge" valign="top" style="font-size: 1px; line-height: 1px;margin: 0;padding: 0;"></td><!-- space -->
                <td align="center" valign="top" width="160" class="resetMarge">
                    <!-- Categories -->
                    <div class="resetMarge">
                        @if(!$arret->arrets_categories->isEmpty() )
                            @include('backend.newsletter.partials.categories',['categories' => $arret->arrets_categories])
                        @endif
                    </div>
                </td>
            </tr>
            <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
        </table>
        <!-- Bloc content-->

    @endforeach
@endif