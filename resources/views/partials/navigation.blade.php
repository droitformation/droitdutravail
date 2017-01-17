<!-- Original -->
<div id="primary-menu">
    <ul class="menu">
        <li><a class="{{ Request::is( '/') ? 'active' : '' }}" href="{{ url('/') }}">Accueil</a></li>
        <li><a class="{{ Request::is( 'jurisprudence') ? 'active' : '' }}" href="{{ url('jurisprudence') }}">Jurisprudence</a></li>
        <li><a href="{{ url('newsletter/campagne/'.$newsletters->campagnes->sortByDesc('id')->where('status','envoyé')->first()->id) }}">Newsletter</a></li>
        <li><a class="{{ Request::is( 'auteur') ? 'active' : '' }}" href="{{ url('auteur') }}">Auteurs</a></li>
        <li><a class="{{ Request::is( 'colloque') ? 'active' : '' }}" href="{{ url('colloque') }}">Colloques</a></li>
        <li><a class="{{ Request::is( 'contact') ? 'active' : '' }}" href="{{ url('contact') }}">Contact</a></li>
    </ul>
</div>

 <!-- END Container -->


