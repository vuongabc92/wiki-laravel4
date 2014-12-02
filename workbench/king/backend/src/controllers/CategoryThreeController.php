<?php namespace King\Backend;

use \View,
    \Session,
    \Redirect,
    \Validator,
    \Request,
    \Input,
    \File;

class CategoryThreeController extends \BaseController
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
        'category_two_id' => 'required|numeric',
        'name' => 'required|min:3|max:255',
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
        'category_two_id.required' => 'The category two field is required.',
        'category_two_id.numeric' => 'The category two field must be a number.',
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
        $filterCategoryRoot->id = 0;
        $filterCategoryOne = new \stdClass();
        $filterCategoryOne->name = 'All';
        $filterCategoryOne->id = 0;
        $filterCategoryTwo = new \stdClass();
        $filterCategoryTwo->name = 'All';
        $filterCategoryTwo->id = 0;
        $this->layout->content = View::make('backend::category-three.index', array(
            'categories' => CategoryThree::orderBy('order_number')->paginate(15),
            'total' => CategoryThree::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'categoryTwo' => CategoryTwo::where('is_active', '=', 1)->get(),
            'filterRoot' => $filterCategoryRoot,
            'filterOne' => $filterCategoryOne,
            'filterTwo' => $filterCategoryTwo
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::category-three.create', array(
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'categoryTwo' => CategoryTwo::where('is_active', '=', 1)->get()
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
                $categoryThree = CategoryRoot::find((int) Input::get('category_root_id'))->categoryThrees;
                $ruleUnique = _Common::checkUniqueName($categoryThree, Input::get('name'), '|unique:category_three,name');

                if( ! empty($ruleUnique)){
                    if ((int) Input::get('category_one_id') > 0) {
                        $categoryThree = CategoryOne::find((int) Input::get('category_one_id'))->categoryThrees;
                        $ruleUnique = _Common::checkUniqueName($categoryThree, Input::get('name'), '|unique:category_three,name');

                        if( ! empty($ruleUnique)){
                            if ((int) Input::get('category_two_id') > 0) {
                                $categoryThree = CategoryTwo::find((int) Input::get('category_two_id'))->categoryThrees;
                                $ruleUnique = _Common::checkUniqueName($categoryThree, Input::get('name'), '|unique:category_three,name');
                                $this->rules['name'] .= $ruleUnique;
                            }
                        }
                    }
                }
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $category = new CategoryThree();
            $category->category_root_id = Input::get('category_root_id');
            $category->category_one_id = Input::get('category_one_id');
            $category->category_two_id = Input::get('category_two_id');
            $category->name = Input::get('name');
            $category->description = Input::get('description');
            $category->order_number = Input::get('order_number');
            $category->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            //Upload image
            $uploadOk = true;
            if(Input::hasFile('image')){
                $originalExt = Input::file('image')->getClientOriginalExtension();
                $newName = 'category_three_' .  time() . '.' . $originalExt;
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
                return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/category-three');
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success but the file was not uploaded.', '/admin/category-three');
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
        $category = CategoryThree::find($id);
        if(is_null($category)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }

        $this->layout->content = View::make('backend::category-three.show', array(
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
        $category = CategoryThree::find($id);
        if(is_null($category)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }

        $this->layout->content = View::make('backend::category-three.edit', array(
            'category' => $category,
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'categoryTwo' => CategoryTwo::where('is_active', '=', 1)->get()
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

            $category = CategoryThree::find($id);
            if(is_null($category)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
            }

            if( ! _Common::strEqual(Input::get('name'), $category->name)){
                if((int) Input::get('category_root_id') > 0){
                    $categoryThree = CategoryRoot::find((int) Input::get('category_root_id'))->categoryThrees;
                    $ruleUnique = _Common::checkUniqueName($categoryThree, Input::get('name'), '|unique:category_three,name');

                    if( ! empty($ruleUnique)){
                        if ((int) Input::get('category_one_id') > 0) {
                            $categoryThree = CategoryOne::find((int) Input::get('category_one_id'))->categoryThrees;
                            $ruleUnique = _Common::checkUniqueName($categoryThree, Input::get('name'), '|unique:category_three,name');

                            if( ! empty($ruleUnique)){
                                if ((int) Input::get('category_two_id') > 0) {
                                    $categoryThree = CategoryTwo::find((int) Input::get('category_two_id'))->categoryThrees;
                                    $ruleUnique = _Common::checkUniqueName($categoryThree, Input::get('name'), '|unique:category_three,name');
                                    $this->rules['name'] .= $ruleUnique;
                                }
                            }
                        }
                    }
                }
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
                $newName = 'category_three_' .  time() . '.' . $originalExt;
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
                return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/category-three');
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success but the file was not uploaded.', '/admin/category-three');
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
        if(Request::isMethod('DELETE')){
            $category = CategoryThree::find($id);
            if (is_null($category)) {
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
            }

            if( ! empty($category->image)){
                $oldFile = $category->getAbsolutePath() . '/' . $category->image;
                if (file_exists($oldFile)) {
                    File::delete($oldFile);
                }
            }

            try{
                $category->delete();
            } catch (Exception $ex) {
                return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-three');
            }

            return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/category-three');
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

            $category = CategoryThree::find($id);
            if(is_null($category)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
            }

            if( ! empty($category->image)){

                $oldFile = $category->getAbsolutePath() . '/' . $category->image;
                if (file_exists($oldFile)) {

                    $deleteImg = File::delete($oldFile);

                    if($deleteImg){
                        return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/category-three');
                    }else{
                        return _Common::redirectWithMsg('adminWarning', 'Opp! Please try again.', '/admin/category-three');
                    }
                }
            }

            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
    }

    /**
     * Remove all resources
     *
     * @return response
     */
    public function destroyAll(){

        if(Request::isMethod('DELETE')){

            $category = new CategoryThree();
            $emptyFolder = File::cleanDirectory($category->getDestinationPath() . '/');

            if($emptyFolder){
                try{
                    CategoryThree::truncate();
                } catch (Exception $ex) {
                    return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-three');
                }

                return _Common::redirectWithMsg('adminWarning', 'Delete success.', '/admin/category-three');
            }
            return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-three');

        }

        $this->layout->content = View::make('backend::category-three.delete-all-comfirmation', array());
    }

    /**
     * Filter category three via category root.
     *
     * @param string $id Category root id
     *
     * @return Response
     */
    public function filterWithCategoryRoot($id){

        $categoryRoot = CategoryRoot::find($id);
        $filterCategoryOne = new \stdClass();
        $filterCategoryOne->name = 'All';
        $filterCategoryOne->id = 0;
        $filterCategoryTwo = new \stdClass();
        $filterCategoryTwo->name = 'All';
        $filterCategoryTwo->id = 0;

        if (is_null($categoryRoot)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $categories = $categoryRoot->categoryThrees()->paginate(15);
        $this->layout->content = View::make('backend::category-three.index', array(
            'categories' => $categories,
            'total' => CategoryThree::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => $categoryRoot->categoryOnes()->where('is_active', '=', 1)->get(),
            'categoryTwo' => $categoryRoot->categoryTwos()->where('is_active', '=', 1)->get(),
            'filterRoot' => $categoryRoot,
            'filterOne' => $filterCategoryOne,
            'filterTwo' => $filterCategoryTwo
        ));
    }

    /**
     * Filter category three via category one.
     *
     * @param string $id Category one id
     *
     * @return Response
     */
    public function filterWithCategoryOne($id){

        $categoryOne = CategoryOne::find($id);
        $filterCategoryRoot = new \stdClass();
        $filterCategoryRoot->name = 'All';
        $filterCategoryRoot->id = 0;
        $filterCategoryTwo = new \stdClass();
        $filterCategoryTwo->name = 'All';
        $filterCategoryTwo->id = 0;
        if (is_null($categoryOne)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $categories = $categoryOne->categoryThrees()->paginate(15);
        $this->layout->content = View::make('backend::category-three.index', array(
            'categories' => $categories,
            'total' => CategoryTwo::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'categoryTwo' => $categoryOne->categoryTwos()->where('is_active', '=', 1)->get(),
            'filterRoot' => $filterCategoryRoot,
            'filterOne' => $categoryOne,
            'filterTwo' => $filterCategoryTwo
        ));
    }

    /**
     * Filter category three via category one.
     *
     * @param string $id Category one id
     *
     * @return Response
     */
    public function filterWithCategoryTwo($id){

        $categoryTwo = CategoryTwo::find($id);
        $filterCategoryRoot = new \stdClass();
        $filterCategoryRoot->name = 'All';
        $filterCategoryRoot->id = 0;
        $filterCategoryOne = new \stdClass();
        $filterCategoryOne->name = 'All';
        $filterCategoryOne->id = 0;
        if (is_null($categoryTwo)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $categories = $categoryTwo->categoryThrees()->paginate(15);
        $this->layout->content = View::make('backend::category-three.index', array(
            'categories' => $categories,
            'total' => CategoryTwo::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => CategoryOne::where('is_active', '=', 1)->get(),
            'categoryTwo' => CategoryTwo::where('is_active', '=', 1)->get(),
            'filterRoot' => $filterCategoryRoot,
            'filterOne' => $filterCategoryOne,
            'filterTwo' => $categoryTwo
        ));
    }

    /**
     * Filter category three via category one and root.
     *
     * @param string $id Category root id
     * @param string $id Category one id
     *
     * @return Response
     */
    public function filterWithCategoryOneAndRoot($idRoot, $idOne){

        $categoryRoot = CategoryRoot::find($idRoot);
        if (is_null($categoryRoot)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $categoryOne = CategoryOne::find($idOne);
        if (is_null($categoryOne)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $filterCategoryTwo = new \stdClass();
        $filterCategoryTwo->name = 'All';
        $filterCategoryTwo->id = 0;
        $categories = $categoryOne->categoryThrees()->paginate(15);
        $this->layout->content = View::make('backend::category-three.index', array(
            'categories' => $categories,
            'total' => CategoryTwo::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => $categoryRoot->categoryOnes()->where('is_active', '=', 1)->get(),
            'categoryTwo' => $categoryOne->categoryTwos()->where('is_active', '=', 1)->get(),
            'filterRoot' => $categoryRoot,
            'filterOne' => $categoryOne,
            'filterTwo' => $filterCategoryTwo
        ));
    }

    /**
     * Filter category three via category root, one, two.
     *
     * @param string $id Category root id
     * @param string $id Category one id
     *
     * @return Response
     */
    public function filterWithCategoryRootOneTwo($idRoot, $idOne, $idTwo){

        $categoryRoot = CategoryRoot::find($idRoot);
        if (is_null($categoryRoot)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $categoryOne = CategoryOne::find($idOne);
        if (is_null($categoryOne)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $categoryTwo = CategoryTwo::find($idTwo);
        if (is_null($categoryTwo)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-three');
        }
        $categories = $categoryTwo->categoryThrees()->paginate(15);
        $this->layout->content = View::make('backend::category-three.index', array(
            'categories' => $categories,
            'total' => CategoryTwo::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get(),
            'categoryOne' => $categoryRoot->categoryOnes()->where('is_active', '=', 1)->get(),
            'categoryTwo' => $categoryOne->categoryTwos()->where('is_active', '=', 1)->get(),
            'filterRoot' => $categoryRoot,
            'filterOne' => $categoryOne,
            'filterTwo' => $categoryTwo
        ));
    }

    /**
     * Call by ajax to build category one selector filter by category root
     *
     * @param int $id Category root id
     *
     * @return respone category one selector HTML
     */
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
        $result = \Form::select('category_one_id', $listCategoryOne, '',array('class' => 'form-control', 'id' => 'category-one', 'autocomplete' => 'off', 'data-categorytwofilterone' => '', 'data-categorytwoid' => 'category-two', 'data-categorytwofilteroneurl' => url('/admin/category-three/create-filter-one/')));

        return \Response::make($result);
    }

    /**
     * Call by ajax to build category two selector filter by category one
     *
     * @param int $id Category root id
     *
     * @return respone category one selector HTML
     */
    public function _ajaxFilterCategoryOne($id){

        $this->layout = null;

        $id = (int) $id;
        $categoryTwo = CategoryOne::find($id)->categoryTwos;
        $listCategoryTwo = array();

        $listCategoryTwo[''] = 'Please select a category';
        if( ! is_null($categoryTwo)){
            foreach($categoryTwo as $one){
                $listCategoryTwo[$one->id] = $one->name;
            }
        }
        $result = \Form::select('category_two_id', $listCategoryTwo, '',array('class' => 'form-control', 'id' => 'category-two', 'autocomplete' => 'off'));

        return \Response::make($result);
    }
}
