<?php
namespace App\Http\Controllers\Backend;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CategorieRequest;

use App\Droit\Categorie\Repo\CategorieInterface;
use App\Droit\Categorie\Repo\ParentInterface;
use App\Droit\Service\UploadInterface;

class CategorieController extends Controller {

    protected $categorie;
	protected $parent;
    protected $upload;

    public function __construct( CategorieInterface $categorie, ParentInterface $parent, UploadInterface $upload )
    {
        $this->categorie = $categorie;
		$this->parent    = $parent;
        $this->upload    = $upload;

		$parents = $this->parent->getAll();

		view()->share('parents', $parents);
    }

    /**
     * Show the form for creating a new resource.
     * GET /admin/categorie/create
     *
     * @return Response
     */
    public function index()
    {
        $categories = $this->categorie->getAll();

		return view('backend.categories.index')->with(['categories' => $categories]);
    }

	/**
	 * Show the form for creating a new resource.
	 * GET /categorie/create
	 *
	 * @return Response
	 */
	public function create()
	{
        return view('backend.categories.create');
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /categorie
	 *
	 * @return Response
	 */
	public function store(CategorieRequest $request)
	{
        $data = $request->except('file');
        $file = $this->upload->upload( $request->file('file') , 'newsletter/pictos' , 'categorie');

        $data['image'] = $file['name'];

        $categorie = $this->categorie->create( $data );

        return redirect('admin/categorie/'.$categorie->id)->with(['status' => 'success' , 'message' => 'Catégorie crée']);
	}

	/**
	 * Display the specified resource.
	 * GET /categorie/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        $categorie = $this->categorie->find($id);

        return view('backend.categories.show')->with(['categorie' => $categorie]);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /categorie/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id,Request $request)
	{
        $data  = $request->except('file');
        $_file = $request->file('file',null);

        if($_file)
        {
            $file = $this->upload->upload( $_file , 'newsletter/pictos' , 'categorie');
            $data['image'] = $file['name'];
        }

        $this->categorie->update( $data );

        return redirect('admin/categorie/'.$id)->with(['status' => 'success' , 'message' => 'Catégorie mise à jour']);
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /categorie/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        $this->categorie->delete($id);

        return redirect()->back()->with(['status' => 'success', 'message' => 'Catégorie supprimée']);
	}

    /**
     * For AJAX
     * Return response categories
     *
     * @return response
     */
    public function categories()
    {
        $categories = $this->categorie->getAll();

        return response()->json( $categories, 200 );
    }

    public function arrets(Request $request){

        $categorie = $this->categorie->find($request->input('id'));

        $references = (!$categorie->categorie_arrets->isEmpty() ? $categorie->categorie_arrets->lists('reference') : null);

        return response()->json( $references, 200 );
    }

}