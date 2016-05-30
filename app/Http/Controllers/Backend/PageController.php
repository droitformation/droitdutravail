<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Droit\Page\Worker\PageWorker;
use App\Droit\Page\Repo\PageInterface;
use App\Http\Requests\PageCreateRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    protected $page;
    protected $worker;

    public function __construct(PageInterface $page, PageWorker $worker)
    {
        $this->page   = $page;
        $this->worker = $worker;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $pages = $this->page->getAll();
        $root  = $this->page->getRoot();

        return view('backend.pages.index')->with(['pages' => $pages, 'root' => $root]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('backend.pages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(PageCreateRequest $request)
    {
        $page = $this->page->create($request->all());

        return redirect('admin/page/'.$page->id)->with(array('status' => 'success' , 'message' => 'La page a été crée' ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $page  = $this->page->find($id);

        return view('backend.pages.show')->with(array( 'page' => $page));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        $page = $this->page->update($request->all());

        return redirect('admin/page/'.$page->id)->with( array('status' => 'success' , 'message' => 'La page a été mise à jour' ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $this->page->delete($id);

        return redirect('admin/page')->with(array('status' => 'success' , 'message' => 'La page a été supprimé' ));
    }

    public function sorting(Request $request)
    {
        $data = $request->all();

        $pages = $this->page->updateSorting($data['page_rang']);
        echo 'ok';die();
    }

    public function hierarchy(Request $request)
    {
        $data = $request->input('data');

        $tree = $this->worker->prepareTree($data);
        echo 'ok';die();
    }
}
