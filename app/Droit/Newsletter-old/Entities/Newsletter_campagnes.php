<?php namespace App\Droit\Newsletter\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter_campagnes extends Model {

	protected $fillable = ['sujet','auteurs','newsletter_id'];

    use SoftDeletes;

    protected $dates = ['deleted_at'];

    public function newsletter(){

        return $this->belongsTo('App\Droit\Newsletter\Entities\Newsletter', 'newsletter_id', 'id');
    }

    public function content(){

        return $this->hasMany('App\Droit\Newsletter\Entities\Newsletter_contents', 'newsletter_campagne_id');
    }
}