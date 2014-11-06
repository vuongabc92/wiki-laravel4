<?php

namespace King\Backend;

use \View,
    \Request,
    \Validator,
    \Input,
    \Redirect,
    \Auth,
    \Session,
    \File;

class PostController extends \BaseController
{
    /**
     * @var string $layout layout controller
     */
    protected $layout = 'backend::layouts._master';

    /**
     * @var array $rules Insert|update rules
     */
    public $rules = array(
        'name' => 'required|min:3|max:255|alpha_dash|unique:post,name',
        'image' => 'image|mimes:jpg,png,jpeg,gif',
        'description' => 'max:255',
        'content' => 'required|min:100',
    );

    /**
     * @var array $msg Insert|update rules
     */
    public $msg = array(
        'name.required' => 'The name field is required.',
        'name.min' => 'The name is too short.',
        'name.max' => 'The name is too long.',
        'name.alpha_dash' => 'The name may only contain letters, numbers, and dashes, such as: about_us, page_contact.',
        'name.unique' => 'The name has already been taken.',
        'image.image' => 'The image must be an image.',
        'image.mimes' => 'The image must be a file of type: jpg, png, jpeg, gif.',
        'description.max' => 'The description is too long.',
        'content.required' => 'The content field is required.',
        'content.min' => 'The content is too short.',
    );


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->layout->content = View::make('backend::post.index', array(
            'posts' => Post::all(),
            'total' => Post::count()
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->layout->content = View::make('backend::post.create', array(
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

            $post = new Post();
            $post->name = Input::get('name');
            $post->description = Input::get('description');
            $post->content = Input::get('content');
            $post->is_active = ! is_null(Input::get('is_active')) ? 1 : 0;

            //Upload image
            $uploadOk = true;
            if(Input::hasFile('image')){
                $originalExt = Input::file('image')->getClientOriginalExtension();
                $newName = Input::get('name') . '_' .  time() . '.' . $originalExt;
                Input::file('image')->move($post->getAbsolutePath() . '/', $newName);
                if(file_exists($post->getAbsolutePath() . '/' . $newName)){
                    $post->image = $newName;
                }else{
                    $uploadOk = false;
                }
            }

            try{
                $post->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::to('/admin/post');
            }

            if($uploadOk){
                Session::flash('adminSuccess', 'Add new post successful!');
                return Redirect::to('/admin/post');
            }

            Session::flash('adminWarning', 'Add new post successful but the file was not uploaded!');
            return Redirect::to('/admin/post');
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
        $post = Post::find($id);

        if (is_null($post)) {
            Session::flash('adminWarning', 'Resource does not exist!');
            return Redirect::to('/admin/post');
        }

        $this->layout->content = View::make('backend::post.show', array(
            'post' => $post
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

        $post = Post::find($id);
        if(is_null($post)){
            Session::flash('adminWarning', 'Resource does not exist!');
            return Redirect::to('/admin/post');
        }

        $this->layout->content = View::make('backend::post.edit', array(
            'post' => $post
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

            $post = Post::find($id);

            if(is_null($post)){
                Session::flash('adminErrors', 'Resource does not exist!');
                return Redirect::to('/admin/post');
            }

            if(strtolower(Input::get('name')) === strtolower($post->name)){
                $this->rules['name'] = 'required|min:3|max:255|alpha_dash';
            }

            $validator = Validator::make(Input::all(), $this->rules, $this->msg);
            if($validator->fails()){
                return Redirect::back()->withInput()->withErrors($validator);
            }

            $post->name = Input::get('name');
            $post->description = Input::get('description');
            $post->content = Input::get('content');
            $post->is_active = !is_null(Input::get('is_active')) ? 1 : 0;

            //Upload image
            $uploadOk = true;
            if(Input::hasFile('image')){
                $originalExt = Input::file('image')->getClientOriginalExtension();
                $newName = Input::get('name') . '_' .  time() . '.' . $originalExt;
                $oldFile = $post->getAbsolutePath() . '/' . $post->image;
                if(file_exists($oldFile)){
                    File::delete($oldFile);
                }
                Input::file('image')->move($post->getAbsolutePath() . '/', $newName);
                if(is_file($post->getAbsolutePath() . '/' . $newName)){
                    $post->image = $newName;
                }else{
                    $uploadOk = false;
                }
            }

            try{
                $post->save();
            } catch (Exception $ex) {
                Session::flash('adminErrors', 'Opp! please try again.');
                return Redirect::to('/admin/post');
            }

            if($uploadOk){
                Session::flash('adminSuccess', 'Save success');
                return Redirect::to('/admin/post');
            }

            Session::flash('adminWarning', 'Save successful but the file was not uploaded.');
            return Redirect::to('/admin/post');
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
            $post = Post::find($id);

            if(is_null($post)){
                Session::flash('adminErrors', 'Resource does not exist.');
                return Redirect::to('/admin/post');
            }

            $oldFile = $post->getAbsolutePath() . '/' . $post->image;
            if (file_exists($oldFile)) {
                File::delete($oldFile);
            }

            $post->delete();

            Session::flash('adminWarning', 'Delete success.');
            return Redirect::to('/admin/post');
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

            $post = Post::find($id);
            if(is_null($post)){
                Session::flash('adminErrors', 'Resource does not exist.');
                return Redirect::to('/admin/post');
            }

            if( ! empty($post->image)){

                $oldFile = $post->getAbsolutePath() . '/' . $post->image;
                if (file_exists($oldFile)) {
                    File::delete($oldFile);

                    Session::flash('adminWarning', 'Delete success.');
                    return Redirect::to('/admin/post');
                }
            }
            Session::flash('adminErrors', 'Resource does not exist.');
            return Redirect::to('/admin/post');
        }
    }

}

