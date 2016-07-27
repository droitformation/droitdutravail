<?php namespace App\Droit\Newsletter\Worker;

use App\Droit\Newsletter\Repo\NewsletterContentInterface;
use App\Droit\Newsletter\Repo\NewsletterCampagneInterface;
use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Arret\Repo\GroupeInterface;
use App\Droit\Categorie\Repo\CategorieInterface;
use \InlineStyle\InlineStyle;
use Illuminate\Support\Collection;

class CampagneWorker implements CampagneInterface{

    protected $content;
    protected $campagne;
    protected $arret;
    protected $categorie;
    protected $worker;
    protected $groupe;

	public function __construct(NewsletterContentInterface $content,NewsletterCampagneInterface $campagne, ArretInterface $arret, CategorieInterface $categorie, GroupeInterface $groupe)
	{
        $this->content   = $content;
        $this->campagne  = $campagne;
        $this->arret     = $arret;
        $this->categorie = $categorie;
        $this->groupe    = $groupe;
        $this->worker    = new \App\Droit\Arret\Worker\ArretWorker();
	}

    public function getSentCampagneArrets(){

        $campagnes = $this->campagne->getAll()->where('status','brouillon');

        return $campagnes->flatMap(function ($campagne) {
            return $campagne->content;
        })->map(function ($content, $key) {

            if($content->arret_id)
                return $content->arret_id ;

            if($content->groupe_id > 0)
                return $content->groupe->arrets_groupes->lists('id')->all();

        })->filter(function ($value, $key) {
            return !empty($value);
        })->flatten()->toArray();

    }

    public function getCampagne($id){

        return $this->campagne->find($id);
    }

    public function getCategoriesArrets()
    {
        return $this->categorie->getAll()->lists('title','id')->all();
    }

    public function getCategoriesImagesArrets()
    {
        return $this->categorie->getAll()->lists('image','id')->all();
    }

	public function prepareCampagne($id){

        $content = $this->content->getByCampagne($id);

        if(!$content->isEmpty()){

            $campagne = $content->map(function($item)
            {
                if ($item->arret_id > 0)
                {
                    $arret = $this->arret->find($item->arret_id);

                    if($arret->dumois)
                    {
                        $analyses = $this->worker->getAnalyseForArret($arret);
                        $arret->setAttribute('analyses',$analyses);
                    }

                    $arret->setAttribute('type',$item->type);
                    $arret->setAttribute('rangItem',$item->rang);
                    $arret->setAttribute('idItem',$item->id);

                    return $arret;
                }
                elseif($item->groupe_id > 0){

                    $groupe       = $this->groupe->find($item->groupe_id);
                    $group_arrets = $groupe->arrets_groupes;

                    if(isset($group_arrets)){
                        foreach($group_arrets as $arretId){
                            $arrets[] =  $this->arret->find($arretId->id);
                        }
                    }

                    $arrets    = new Collection($arrets);
                    $categorie = $groupe->categorie_id;

                    $image = $this->categorie->find($categorie);
                    $image = $image->image;

                    $item->setAttribute('arrets',$arrets);
                    $item->setAttribute('categorie',$categorie);
                    $item->setAttribute('image',$image);
                    $item->setAttribute('rangItem',$item->rang);
                    $item->setAttribute('idItem',$item->id);

                    return $item;
                }
                else
                {
                    $item->setAttribute('rangItem',$item->rang);
                    $item->setAttribute('idItem',$item->id);
                    return $item;
                }
            });

            return $campagne;
        }

        return [];
	}

    public function html($id)
    {
        libxml_use_internal_errors(true);

        $htmldoc = new InlineStyle(file_get_contents( url('campagne/'.$id)));
        $htmldoc->applyStylesheet($htmldoc->extractStylesheets());

        $html = $htmldoc->getHTML();
        $html = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $html);

        return $html;
    }
}
