<?php namespace King\Backend;

use \View,
    \Session,
    \Redirect,
    \Validator,
    \Request,
    \Input,
    \File;

class CategoryTwoController extends \BaseController
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
        'category_one_id' => 'required|numeric',
        'name' => 'required|min:3|max:255|unique:category_two,name',
        'image' => 'image|mimes:jpg,png,jpeg,gif',
        'description' => 'max:255',
        'order_number' => 'required|numeric'
    );

    /**
     * @var array $msg Insert|update rules
     */
    public $msg = array(
        'category_root_id.required' => 'The category root field is required.',
        'category_root_id.numeric' => 'The category root field must be a number.',
        'category_one_id.required' => 'The category one field is required.',
        'category_one_id.numeric' => 'The category one field must be a number.',
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
        $filterCategoryRoot = new \stdClass();
        $filterCategoryRoot->name = 'All';
        $filterCategoryOne = new \stdClass();
        $filterCategoryOne->name = 'All';
        $this->layout->content = View::make('backend::category-two.index', array(
            'categories' => CategoryTwo::orderBy('order_number')->paginate(15),
            'total' => CategoryTwo::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'filterRoot' => $filterCategoryRoot,
            'filterOne' => $filterCategoryOne
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::category-two.create', array(
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get()
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
            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $category = new CategoryTwo();
            $category->category_root_id = Input::get('category_root_id');
            $category->category_one_id = Input::get('category_one_id');
            $category->name = Input::get('name');
            $category->description = Input::get('description');
            $category->order_number = Input::get('order_number');
            $category->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            //Upload image
            $uploadOk = true;
            if(Input::hasFile('image')){
                $originalExt = Input::file('image')->getClientOriginalExtension();
                $newName = 'category_two_' .  time() . '.' . $originalExt;
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
                return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/category-two');
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success but the file was not uploaded.', '/admin/category-two');
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
        $category = CategoryTwo::find($id);
        if(is_null($category)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-two');
        }

        $this->layout->content = View::make('backend::category-two.show', array(
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
        $category = CategoryTwo::find($id);
        if(is_null($category)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-one');
        }

        $this->layout->content = View::make('backend::category-two.edit', array(
            'category' => $category,
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get()
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

            $category = CategoryTwo::find($id);
            if(is_null($category)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-two');
            }

            if(strtolower(Input::get('name')) === strtolower($category->name)){
                $this->rules['name'] = 'required|min:3|max:255';
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $category->name = Input::get('name');
            $category->category_root_id = Input::get('category_root_id');
            $category->category_one_id = Input::get('category_one_id');
            $category->description = Input::get('description');
            $category->order_number = Input::get('order_number');
            $category->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            //Upload image
            $uploadOk = true;
            if(Input::hasFile('image')){
                $originalExt = Input::file('image')->getClientOriginalExtension();
                $newName = 'category_two_' .  time() . '.' . $originalExt;
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
                return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/category-two');
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success but the file was not uploaded.', '/admin/category-two');
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

        try{
            $category->delete();
        } catch (Exception $ex) {
            return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-one');
        }

        return _Common::redirectWithMsg('adminWarning', 'Delete Success.', '/admin/category-one');
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

            if($emptyFolder){
                try{
                    $categories = CategoryOne::truncate();
                } catch (Exception $ex) {
                    return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-one');
                }

                return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/category-one');
            }
            return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-one');

        }

        $this->layout->content = View::make('backend::category-one.delete-all-comfirmation', array());
    }

    /**
     * Filter category one via category root.
     *
     * @param string $id Category root id
     * @return Response
     */
    public function filterWithCategoryRoot($id){

        $categoryRoot = CategoryRoot::find($id);
        $filterCategoryOne = new \stdClass();
        $filterCategoryOne->name = 'All';
        if (is_null($categoryRoot)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-two');
        }
        $categories = $categoryRoot->categoryTwos()->paginate(15);
        $this->layout->content = View::make('backend::category-two.index', array(
            'categories' => $categories,
            'total' => CategoryTwo::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'filterRoot' => $categoryRoot,
            'filterOne' => $filterCategoryOne
        ));
    }

    /**
     * Filter category one via category one.
     *
     * @param string $id Category one id
     * @return Response
     */
    public function filterWithCategoryOne($id){

        $categoryOne = CategoryOne::find($id);
        $filterCategoryRoot = new \stdClass();
        $filterCategoryRoot->name = 'All';
        if (is_null($categoryOne)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-two');
        }
        $categories = $categoryOne->categoryTwos()->paginate(15);
        $this->layout->content = View::make('backend::category-two.index', array(
            'categories' => $categories,
            'total' => CategoryTwo::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'filterRoot' => $filterCategoryRoot,
            'filterOne' => $categoryOne
        ));
    }

    public function _ajaxFilterCategoryRoot($id){

        $this->layout = null;

        $id = (int) $id;
        $categoryOne = CategoryRoot::find($id)->categoryOnes;


        $listCategoryOne = array();
        $listCategoryOne[''] = 'Please select a category';
        if( ! is_null($categoryOne)){
            foreach($categoryOne as $one){
                $listCategoryOne[$one->id] = $one->name;
            }
        }
        $result = \Form::select('category_one_id', $listCategoryOne, '',array('class' => 'form-control', 'id' => 'category-one', 'autocomplete' => 'off'));
        return \Response::make($result);
    }
}
