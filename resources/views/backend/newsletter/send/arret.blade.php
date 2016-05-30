<!-- Bloc -->
<table border="0" width="600" align="center" cellpadding="0" cellspacing="0" class="tableReset">
    <tr bgcolor="ffffff">
        <td colspan="3" height="35"></td>
    </tr><!-- space -->
    <tr align="center" class="resetMarge">
        <td class="resetMarge">
            <!-- Bloc content-->
            <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="tableReset contentForm">
                <tr>
                    <td valign="top" width="375" class="resetMarge">
                        <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                        <h3 style="text-align: left;font-family: sans-serif;">{{ $bloc->reference }} du {{ $bloc->pub_date->formatLocalized('%d %B %Y') }}</h3>
                        <p class="abstract">{!! $bloc->abstract !!}</p>
                        <div>{!! $bloc->pub_text !!}</div>
                        <p><a href="{{ asset('files/arrets/'.$bloc->file) }}">Télécharger en pdf</a></p>
                    </td>
                    <td width="25" height="1" class="resetMarge" valign="top" style="font-size: 1px; line-height: 1px;margin: 0;padding: 0;"></td><!-- space -->
                    <td align="center" valign="top" width="160" class="resetMarge">
                       @if(!$bloc->arrets_categories->isEmpty() )
                            @include('backend.newsletter.partials.categories',['categories' => $bloc->arrets_categories])
                        @endif
                    </td>
                </tr>
            </table>
            <!-- Bloc content-->
        </td>
    </tr>
    <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
</table>
<!-- End bloc -->

@if(!$bloc->arrets_analyses->isEmpty())
    <!-- Bloc content-->
    <table border="0" width="560" align="center" cellpadding="0" cellspacing="0" class="resetTable">
        <tr bgcolor="ffffff">
            <td colspan="3" height="35"></td>
        </tr><!-- space -->
        <tr>
            <td valign="top" width="375" class="resetMarge contentForm">
                <?php $i = 1; ?>
                @foreach($bloc->arrets_analyses as $analyse)
                    <table border="0" width="375" align="left" cellpadding="0" cellspacing="0" class="resetTable">
                        <tr>
                            <td valign="top" width="375" class="resetMarge contentForm">
                                <?php setlocale(LC_ALL, 'fr_FR.UTF-8');  ?>
                                <h3 style="text-align: left;font-family: sans-serif;">Analyse de l'arrêt {{ $bloc->reference }}</h3>

                                    @if(!$analyse->analyse_authors->isEmpty())
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

                                    <p class="abstract">{!! $analyse->abstract !!}</p>
                                <p><a href="{{ asset('files/analyses/'.$analyse->file) }}">Télécharger en pdf</a></p>
                            </td>
                        </tr>

                        @if( $bloc->arrets_analyses->count() > 1 && $bloc->arrets_analyses->count() > $i)
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
                    <a target="_blank" href="{{ url('jurisprudence') }}">
                        <img border="0" alt="Analyses" src="<?php echo asset('newsletter/pictos/analyse.png') ?>">
                    </a>
                </div>
            </td>
        </tr>
        <tr bgcolor="ffffff"><td colspan="3" height="35" class="blocBorder"></td></tr><!-- space -->
    </table>
    <!-- Bloc content-->
@endif