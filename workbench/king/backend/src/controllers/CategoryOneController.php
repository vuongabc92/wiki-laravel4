<?php namespace King\Backend;

use \View,
    \Session,
    \Redirect,
    \Validator,
    \Request,
    \Input;

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
        'root_id' => 'required|numeric',
        'name' => 'required|min:3|max:255|unique:category_one,name',
        'image' => 'image|mimes:jpg,png,jpeg,gif',
        'description' => 'max:255',
    );

    /**
     * @var array $msg Insert|update rules
     */
    public $msg = array(
        'root_id.required' => 'The root field is required.',
        'root_id.numeric' => 'The root field must be a number.',
        'name.required' => 'The name field is required.',
        'name.min' => 'The name is too short.',
        'name.max' => 'The name is too long.',
        'name.unique' => 'The name has already been taken.',
        'image.image' => 'The image must be an image.',
        'image.mimes' => 'The image must be a file of type: jpg, png, jpeg, gif.',
        'description.max' => 'The description is too long.',
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
            'categories' => CategoryOne::all(),
            'total' => CategoryOne::count(),
            'categoryRoot' => CategoryRoot::where('is_active', '=', 1)->get()
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
            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $category = new CategoryOne();
            $category->root_id = Input::get('root_id');
            $category->name = Input::get('name');
            $category->description = Input::get('description');
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        $category = CategoryRoot::find($id);
        if(is_null($category)){
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-root');
        }

        $this->layout->content = View::make('backend::category-root.edit', array(
            'category' => $category
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

            $category = CategoryRoot::find($id);
            if(is_null($category)){
                return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-root');
            }

            if(strtolower(Input::get('name')) === strtolower($category->name)){
                $this->rules['name'] = 'required|min:3|max:255';
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $category->name = Input::get('name');
            $category->is_active = !is_null(Input::get('is_active')) ? 1 : 0;

            try{
                $category->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::back()->withInput();
            }

            return _Common::redirectWithMsg('adminSuccess', 'Save success.', '/admin/category-root');
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
        $category = CategoryRoot::find($id);
        if (is_null($category)) {
            return _Common::redirectWithMsg('adminErrors', 'Resource does not exist.', '/admin/category-root');
        }

        try{
            $category->delete();
        } catch (Exception $ex) {
            return _Common::redirectWithMsg('adminErrors', 'Opp! Please try again.', '/admin/category-root');
        }

        return _Common::redirectWithMsg('adminWarning', 'Delete Success.', '/admin/category-root');
    }

}
