<?php namespace App\Droit\Arret\Worker;

use App\Droit\Categorie\Repo\CategorieInterface;
use App\Droit\Arret\Repo\ArretInterface;
use App\Droit\Analyse\Repo\AnalyseInterface;
use App\Droit\Newsletter\Worker\CampagneInterface;
use App\Droit\Helper\Helper;

class JurisprudenceWorker{

    protected $categories;
    protected $arret;
    protected $analyse;
    protected $custom;
    protected $campagne;

    /* Inject dependencies */
    public function __construct(CategorieInterface $categories, ArretInterface $arret, AnalyseInterface $analyse, CampagneInterface $campagne)
    {
        $this->categories = $categories;
        $this->campagne   = $campagne;
        $this->arret      = $arret;
        $this->analyse    = $analyse;
        $this->custom     = new \App\Droit\Helper\Helper();
    }

    /**
     * Return collection arrets prepared for filtered
     *
     * @return collection
     */
    public function preparedAnnees()
    {
        $years = [];

        $exclude  = $this->showArrets();
        $arrets   = $this->arret->getAllActives($exclude);

        $prepared = $arrets->lists('pub_date');

        foreach($prepared as $arret)
        {
            $years[] = $arret->year;
        }

        asort($years);

        return array_reverse(array_unique(array_values($years)));
    }

    public function showArrets(){

        $arrets = $this->campagne->getSentCampagneArrets();

        return ($arrets ? $arrets : []);
    }

    public function showAnalyses(){

        $arrets = $this->showArrets();
        $analyses = false;

        if(!empty($arrets))
        {
            $analyses = \DB::table('analyses_arret')->whereIn('arret_id', $arrets)->lists('analyse_id');
        }

        return ($analyses ? $analyses : []);
    }

    /**
     * Return response arrets prepared for filtered
     *
     * @return collection
     */
    public function preparedArrets()
    {

        $include  = $this->showArrets();
        $arrets   = $this->arret->getAllActives($include);

        $prepared = $arrets->filter(function($arret)
        {
            // format the title with the date
            setlocale(LC_ALL, 'fr_FR.UTF-8');

            $arret->setAttribute('humanTitle',$arret->reference.' du '.$arret->pub_date->formatLocalized('%d %B %Y'));
            $arret->setAttribute('parsedText',$arret->pub_text);

            // categories for isotope
            if(!$arret->arrets_categories->isEmpty())
            {
                foreach($arret->arrets_categories as $cat){ $cats[] = 'c'.$cat->id; }

                $cats[]  = 'y'.$arret->pub_date->year;
                $arret->setAttribute('allcats',$cats);

                return $arret;
            }
            else
            {
                $cats[]  = 'y'.$arret->pub_date->year;
                $arret->setAttribute('allcats',$cats);

                return $arret;
            }

        });

        $prepared->sortByDesc('pub_date');
        $prepared->values();

        return $prepared;
    }

    /**
     * Return collection analyses prepared for filtered
     *
     * @return collection
     */
    public function preparedAnalyses()
    {

        $include  = $this->showAnalyses();
        $analyses = $this->analyse->getAll($include);

        $prepared = $analyses->filter(function($analyse)
        {
            // format the title with the date
            setlocale(LC_ALL, 'fr_FR.UTF-8');

            // categories for isotope
            if(!$analyse->analyses_categories->isEmpty())
            {
                foreach($analyse->analyses_categories as $cat){ $cats[] = 'c'.$cat->id; }

                $cats[]  = 'y'.$analyse->pub_date->year;
                $analyse->setAttribute('allcats',$cats);

                return $analyse;
            }
            else
            {
                $cats[]  = 'y'.$analyse->pub_date->year;
                $analyse->setAttribute('allcats',$cats);

                return $analyse;
            }

        });

        $prepared->sortByDesc('pub_date');
        $prepared->values();

        return $prepared;
    }

}