<?php namespace App\Droit\Page\Repo;

use App\Droit\Page\Repo\PageInterface;
use App\Droit\Page\Entities\Page as M;

class PageEloquent implements PageInterface{

    protected $page;

    public function __construct(M $page)
    {
        $this->page = $page;
    }

    public function getAll()
    {
        return $this->page->orderBy('pages.rang')->get();
    }

    public function getTree($key = null, $seperator = '  ')
    {
        return $this->page->getNestedList('title', $key, $seperator);
    }

    public function search($term)
    {
        return $this->page->where('content','LIKE', '%'.$term.'%')->get();
    }

    public function getRoot()
    {
        return $this->page->whereNull('parent_id')->orderBy('rang')->get();
    }

    public function find($id){

        return $this->page->find($id);
    }

    public function getBySlug($slug)
    {
        return $this->page->where('slug','=',$slug)->first();
    }

    public function buildTree($data)
    {
        return $this->page->buildTree($data);
    }

    public function create(array $data){

        $page = $this->page->create(array(
            'title'       => (isset($data['title']) ? $data['title'] : null),
            'excerpt'     => (isset($data['excerpt']) ? $data['excerpt'] : null),
            'content'     => (isset($data['content']) ? $data['content'] : null),
            'slug'        => (isset($data['slug']) && !empty($data['slug']) ? $data['slug'] : \Str::slug($data['title'])),
            'rang'        => (isset($data['rang']) ? $data['rang'] : 0),
            'hidden'      => (isset($data['hidden']) ? 1 : null),
            'created_at'  => date('Y-m-d G:i:s'),
            'updated_at'  => date('Y-m-d G:i:s')
        ));

        if( !$page )
        {
            return false;
        }

        if(isset($data['parent_id']))
        {
            $parent = $this->page->findOrFail($data['parent_id']);
            $page->makeChildOf($parent);
        }

        return $page;

    }

    public function update(array $data){

        $page = $this->page->findOrFail($data['id']);

        if( ! $page )
        {
            return false;
        }

        $page->fill($data);

        $page->hidden     = $data['hidden'] ? 1 : null;
        $page->updated_at = date('Y-m-d G:i:s');

        $page->save();

        if(isset($data['parent_id']))
        {
            $parent = $this->page->findOrFail($data['parent_id']);
            $page->makeChildOf($parent);
        }

        return $page;
    }

    public function updateSorting(array $data)
    {
        if(!empty($data))
        {
            foreach($data as $rang => $id)
            {
                $page = $this->find($id);

                if( ! $page )
                {
                    return false;
                }

                $page->rang = $rang;
                $page->save();
            }

            return true;
        }
    }

    public function delete($id){

        $page = $this->page->find($id);

        return $page->delete($id);
    }

}
