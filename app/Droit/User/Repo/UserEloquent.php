<?php namespace App\Droit\User\Repo;

use App\Droit\User\Repo\UserInterface;
use App\Droit\User\Entities\User as M;

class UserEloquent implements UserInterface{

    protected $user;

    public function __construct(M $user)
    {
        $this->user = $user;
    }

    public function getAll(){

        return $this->user->all();
    }

    public function find($id){

        return $this->user->with(['roles'])->findOrFail($id);
    }

    public function search($term){

        return $this->user->where('email', 'like', '%'.$term.'%')
            ->orWhere('prenom', 'like', '%'.$term.'%')
            ->orWhere('nom', 'like', '%'.$term.'%')
            ->get();
    }

    public function create(array $data){

        $user = $this->user->create(array(
            'prenom'         => $data['prenom'],
            'nom'            => $data['nom'],
            'email'          => $data['email'],
            'password'       => bcrypt($data['password']),
            'created_at'     => date('Y-m-d G:i:s'),
            'updated_at'     => date('Y-m-d G:i:s')
        ));

        if( ! $user )
        {
            return false;
        }

        return $user;

    }

    public function update(array $data){

        $user = $this->user->findOrFail($data['id']);

        if( ! $user )
        {
            return false;
        }

        $user->fill($data);

        $user->updated_at = date('Y-m-d G:i:s');

        $user->save();

        return $user;
    }

    public function delete($id){

        $user = $this->user->find($id);

        return $user->delete($id);
    }

}
