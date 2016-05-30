<?php namespace App\Droit\Arret\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arret extends Model {

    use SoftDeletes;

	protected $fillable = ['user_id','reference','pub_date','abstract','pub_text','file','categories','dumois'];
    protected $dates    = ['pub_date'];

    public function arrets_categories()
    {
        return $this->belongsToMany('\App\Droit\Categorie\Entities\Categorie', 'arret_categories', 'arret_id', 'categories_id')->withPivot('sorting')->orderBy('sorting', 'asc');
    }

    public function arrets_analyses()
    {
        return $this->belongsToMany('\App\Droit\Analyse\Entities\Analyse', 'analyses_arret', 'arret_id', 'analyse_id')->withPivot('sorting')->orderBy('sorting', 'asc');
    }

}
