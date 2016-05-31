<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\SendMessageRequest;
use App\Http\Controllers\Controller;

use App\Droit\Author\Repo\AuthorInterface;
use App\Droit\Newsletter\Repo\NewsletterInterface;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;
use App\Droit\Content\Repo\ContentInterface;
use App\Droit\Page\Repo\PageInterface;
use App\Droit\Arret\Worker\JurisprudenceWorker;
use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Service\ColloqueWorker;

class HomeController extends Controller
{
    protected $author;
    protected $newsletter;
    protected $campagne;
    protected $helper;
    protected $content;
    protected $page;
    protected $jurisprudence;
    protected $arret;
    protected $worker;

    public function __construct(
        AuthorInterface $author,
        ContentInterface $content,
        PageInterface $page,
        NewsletterInterface $newsletter,
        NewsletterCampagneInterface $campagne,
        JurisprudenceWorker $jurisprudence,
        ArretInterface $arret,
        ColloqueWorker $worker
    )
    {
        setlocale(LC_ALL, 'fr_FR.UTF-8');

        $this->author        = $author;
        $this->newsletter    = $newsletter;
        $this->campagne      = $campagne;
        $this->content       = $content;
        $this->page          = $page;
        $this->jurisprudence = $jurisprudence;
        $this->arret         = $arret;
        $this->worker        = $worker;

        $this->helper        = new \App\Droit\Helper\Helper();

        $sidebar = $this->content->findyByPosition(array('sidebar'));
        $pub     = $this->content->findyByType('pub');
        $sidebar = $sidebar->groupBy('type');
        $pages   = $this->page->getAll();

        $include = $this->jurisprudence->showArrets();
        $latest  = $this->arret->getLatest($include);
        
        view()->share('pages', $pages);
        view()->share('sidebar', $sidebar);
        view()->share('latest', $latest);
        view()->share('pub', $pub);
    }

    /**
     * Homepage
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $homepage = $this->content->findyByPosition(array('home-bloc','home-colonne'));
        $homepage = $this->helper->prepareBlocsHomepage($homepage);

        return view('frontend.index')->with(['homepage' => $homepage]);
    }

    /**
     * Authors page
     *
     * @return \Illuminate\Http\Response
     */
    public function auteur()
    {
        $auteurs = $this->author->getAll();

        return view('frontend.auteur')->with(['auteurs' => $auteurs]);
    }

    /**
     * Pages
     *
     * @return \Illuminate\Http\Response
     */
    public function page($id)
    {
        $page = $this->page->find($id);

        return view('frontend.page')->with(['page' => $page]);
    }

    public function colloque()
    {
        $colloques = $this->worker->getColloques();
        $archives  = $this->worker->getArchives();

        return view('frontend.colloque')->with(array('colloques' => $colloques, 'archives' => $archives ));
    }

    /**
     * Contact form
     *
     * @return \Illuminate\Http\Response
     */
    public function contact()
    {
        return view('frontend.contact');
    }

    /**
     * Unsubcribe page newsletter
     * @return Response
     */
    public function unsubscribe($id)
    {
        $newsletter = $this->newsletter->find($id);

        if(!$newsletter)
        {
            return redirect('/')->with(['status' => 'warning', 'message' => 'Cette newsletter n\'existe pas']);
        }

        return view('frontend.unsubscribe')->with(['id' => $id]);
    }

    /**
     * Send contact message
     *
     * @return Response
     */
    public function sendMessage(SendMessageRequest $request)
    {

        $data = ['email' => $request->input('email'), 'nom' => $request->input('nom'), 'remarque' => $request->input('remarque')];

        \Mail::send('emails.contact', $data , function($message)
        {
            $message->to('info@droitdutravail.ch', 'Droit du travail')->subject('Message depuis le site www.droitdutravail.ch');
        });
        
        return redirect()->back()->with(['status' => 'success', 'message' => '<strong>Merci pour votre message</strong><br/>Nous vous contacterons dès que possible.']);

    }

}
