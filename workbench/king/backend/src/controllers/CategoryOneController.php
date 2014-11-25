<?php namespace King\Backend;

use \View,
    \Session,
    \Redirect,
    \Validator,
    \Request,
    \Input,
    \File;

class CategoryOneController extends \BaseController
{

    /**
     * @var string $layout layout controller
     */
    protected $layout = 'backend::layouts._master';

    /**
     * @var array $rules Insert|update rules
     */
    public $rules = array(
        'category_root_id' => 'required|numeric',
        'name' => 'required|min:2|max:255',
        'image' => 'image|mimes:jpg,png,jpeg,gif',
        'description' => 'max:255',
        'order_number' => 'required|numeric'
    );

    /**
     * @var array $msg Insert|update rules
     */
    public $msg = array(
        'category_root_id.required' => 'The root field is required.',
        'category_root_id.numeric' => 'The root field must be a number.',
        'name.required' => 'The name field is required.',
        'name.min' => 'The name is too short.',
        'name.max' => 'The name is too long.',
        'name.unique' => 'The name has already been taken.',
        'image.image' => 'The image must be an image.',
        'image.mimes' => 'The image must be a file of type: jpg, png, jpeg, gif.',
        'description.max' => 'The description is too long.',
        'order_number.required' => 'The order number field is required.',
        'order_number.numeric' => 'The order number field must be a number.',
    );

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', array('on' => 'post'));
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->layout->content = View::make('backend::category-one.index', array(
            'categories' => CategoryOne::orderBy('order_number')->paginate(15),
            'total' => CategoryOne::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'filter' => 'All'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::category-one.create', array(
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get()
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        if(Request::isMethod('POST')){

            if((int) Input::get('category_root_id') > 0){
                $categoryOne = CategoryRoot::find((int) Input::get('category_root_id'))->categoryOnes;
                $ruleUnique = _Common::checkUniqueName($categoryOne, Input::get('name'), '|unique:category_one,name');
                $this->rules['name'] .= $ruleUnique;
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }
            $category = new CategoryOne();
            $category->category_root_id = Input::get('category_root_id');
            $category->name = Input::get('name');
            $category->description = Input::get('description');
            $category->order_number = Input::get('order_number');
            $category->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            //Upload image
            $uploadOk = true;
            if(Input::hasFile('image')){
                $originalExt = Input::file('image')->getClientOriginalExtension();
                $newName = 'category_one_' .  time() . '.' . $originalExt;
                Input::file('image')->move($category->getAbsolutePath() . '/', $newName);
                if(file_exists($category->getAbsolutePath() . '/' . $newName)){
                    $category->image = $newName;
                }else{
                    $uploadOk = false;
                }
            }

            try{
                $category->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::back()->withInput();
            }

            if($uploadOk){
                return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/category-one');
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success but the file was not uploaded.', '/admin/category-one');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $category = CategoryOne::find($id);
        if(is_null($category)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
        }

        $this->layout->content = View::make('backend::category-one.show', array(
            'category' => $category
        ));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category = CategoryOne::find($id);
        if(is_null($category)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
        }

        $this->layout->content = View::make('backend::category-one.edit', array(
            'category' => $category,
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get()
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        if(Request::isMethod('PUT')){

            $category = CategoryOne::find($id);
            if(is_null($category)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
            }
            if( ! _Common::strEqual(Input::get('name'), $category->name)){
                if((int) Input::get('category_root_id') > 0){
                    $categoryOne = CategoryRoot::find((int) Input::get('category_root_id'))->categoryOnes;
                    $ruleUnique = _Common::checkUniqueName($categoryOne, Input::get('name'), '|unique:category_one,name');
                    $this->rules['name'] .= $ruleUnique;
                }
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $category->name = Input::get('name');
            $category->category_root_id = Input::get('category_root_id');
            $category->description = Input::get('description');
            $category->order_number = Input::get('order_number');
            $category->is_active = !is_null(Input::get('is_active')) ? 1 : 0;

            //Upload image
            $uploadOk = true;
            if(Input::hasFile('image')){
                $originalExt = Input::file('image')->getClientOriginalExtension();
                $newName = 'category_one_' .  time() . '.' . $originalExt;
                Input::file('image')->move($category->getAbsolutePath() . '/', $newName);
                if(file_exists($category->getAbsolutePath() . '/' . $newName)){
                    $category->image = $newName;
                }else{
                    $uploadOk = false;
                }
            }

            try{
                $category->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::back()->withInput();
            }

            if($uploadOk){
                return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/category-one');
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success but the file was not uploaded.', '/admin/category-one');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        $category = CategoryOne::find($id);
        if (is_null($category)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
        }

        $deleteImg = false;
        if (!empty($category->image)) {
            $oldFile = $category->getAbsolutePath() . '/' . $category->image;
            if (file_exists($oldFile)) {
                $deleteImg = File::delete($oldFile);
            }
        }

        try{
            $category->delete();
        } catch (Exception $ex) {
            return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-one');
        }

        if ($deleteImg) {
            return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/category-one');
        } else {
            return _Common::redirectWithMsg('adminWarning', 'Delete success but resource still remains.', '/admin/category-one');
        }
    }

    /**
     * Remove the specified image resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroyImg($id){

        if(Request::isMethod('DELETE')){

            $category = CategoryOne::find($id);
            if(is_null($category)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
            }

            if( ! empty($category->image)){

                $oldFile = $category->getAbsolutePath() . '/' . $category->image;
                if (file_exists($oldFile)) {

                    File::delete($oldFile);

                    return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/category-one');
                }
            }

            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
        }
    }

    /**
     * Remove all resources
     *
     * @return response
     */
    public function destroyAll(){

        if(Request::isMethod('DELETE')){
            $categoryOne = new CategoryOne();
            $emptyFolder = File::cleanDirectory($categoryOne->getDestinationPath() . '/');

            try {
                $categories = CategoryOne::truncate();
            } catch (Exception $ex) {
                return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-one');
            }

            return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/category-one');
        }

        $this->layout->content = View::make('backend::category-one.delete-all-comfirmation', array());
    }

    /**
     * Filter category one via category root.
     *
     * @param string $root Some string like root-{id-root}
     * @return Response
     */
    public function filterRoot($root){
        list($txt, $id) = explode('-', $root);
        $categoryRoot = CategoryRoot::find($id);
        if (is_null($categoryRoot)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
        }
        $categories = CategoryRoot::find($id)->categoryOnes()->paginate(15);
        $this->layout->content = View::make('backend::category-one.index', array(
            'categories' => $categories,
            'total' => CategoryOne::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'filter' => $categoryRoot->name
        ));
    }
}
