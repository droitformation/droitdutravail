<?php namespace App\Droit\Arret\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Arret extends Model {

    use SoftDeletes;

	protected $fillable = ['user_id','reference','pub_date','abstract','pub_text','file','dumois'];
    protected $dates    = ['pub_date'];

    public function getDocumentAttribute()
    {
        return !empty($this->file) && \File::exists(public_path('files/arrets/'.$this->file)) ? $this->file : null;
    }

    public function getFilterAttribute()
    {
        return $this->categories->map(function ($categorie, $key) {
            return 'c'.$categorie->id;
        })->implode(' ');
    }
    
    public function categories()
    {
        return $this->belongsToMany('\App\Droit\Categorie\Entities\Categorie', 'arret_categories', 'arret_id', 'categories_id')->withPivot('sorting')->orderBy('sorting', 'asc');
    }

    public function analyses()
    {
        return $this->belongsToMany('\App\Droit\Analyse\Entities\Analyse', 'analyses_arret', 'arret_id', 'analyse_id')->withPivot('sorting')->orderBy('sorting', 'asc');
    }

}
