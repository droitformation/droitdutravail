<!-- Bloc content-->
<table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
    <tr bgcolor="ffffff"><td colspan="3" height="35"></td></tr><!-- space -->
    <tr>
        <td valign="top" width="375" class="resetMarge contentForm">
            <?php $i = 1; ?>
            @foreach($arret->arrets_analyses as $analyse)
                <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
                    <tr>
                        <td valign="top" width="375" class="resetMarge contentForm">
                            <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>

                            <!-- overwrite analyse title if any -->
                            @if(!empty($analyse->title))
                                <h3 style="text-align: left;font-family: sans-serif;">{{ $analyse->title }}</h3>
                            @else
                                <h3 style="text-align: left;font-family: sans-serif;">Analyse de l'arrêt {{ $arret->reference }}</h3>
                            @endif
                            <!-- overwrite analyse title if any -->

                            <?php $analyse->load('analyse_authors'); ?>

                            @if(isset($analyse->analyse_authors))

                                @foreach($analyse->analyse_authors as $analyse_authors)
                                    <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
                                        <tr>
                                            <td valign="top" width="60" class="resetMarge">
                                                <img style="width: 60px;" width="60" border="0" alt="{{ $analyse_authors->name }}" src="{{ asset('authors/'.$analyse_authors->photo) }}">
                                            </td>
                                            <td valign="top" width="10" class="resetMarge"></td>
                                            <td valign="top" width="305" class="resetMarge">
                                                <h3 style="text-align: left;font-family: sans-serif;">{{ $analyse_authors->name }}</h3>
                                                <p style="text-align: left;font-family: sans-serif;">{{  $analyse_authors->occupation }}</p>
                                            </td>
                                        </tr>
                                        <tr bgcolor="ffffff"><td colspan="3" height="15" class=""></td></tr><!-- space -->
                                    </table>
                                @endforeach
                            @endif

                            <p class="abstract">{{ $analyse->abstract }}</p>
                            <p><a href="{{ asset('files/analyses/'.$analyse->file) }}">Télécharger en pdf</a></p>
                        </td>
                    </tr>

                    @if( $arret->arrets_analyses->count() > 1 && $arret->arrets_analyses->count() > $i)
                        <tr bgcolor="ffffff"><td colspan="3" height="35" class=""></td></tr><!-- space -->
                    @endif

                    <?php $i++; ?>
                </table>
            @endforeach

        </td>
        <td width="25" class="resetMarge"></td><!-- space -->
        <td align="center" valign="top" width="160" class="resetMarge">
            <!-- Categories -->
            <div class="resetMarge">
                <a target="_blank" href="{{ url('jurisprudence') }}"><img width="130" border="0" alt="Analyse" src="{{ asset('images/analyse.png') }}"></a>
            </div>
        </td>
    </tr>
</table>
