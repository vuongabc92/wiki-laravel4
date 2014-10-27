<?php

namespace King\Backend;

use \View,
    \Request,
    \Validator,
    \Input,
    \Redirect,
    \Auth,
    \Session,
    \Hash;

class PostController extends \BaseController
{
    /**
     * @var string layout layout controller
     */
    protected $layout = 'backend::layouts._master';

    /**
     * @var array rules Insert|update rules
     */
    public $rules = array(
        'name' => 'required|min:10|max:255|alpha_num|unique:post,name',
        'image' => 'image|mimes:jpg,png,jpeg,gif',
        'description' => 'max:255',
        'content' => 'required|min:100',
    );

    /**
     * @var array rules Insert|update rules
     */
    public $msg = array(
        'name.required' => 'The name field is required.',
        'name.min' => 'The name is too short.',
        'name.max' => 'The name is too long.',
        'name.alpha_num' => 'The name could not contain characters that is not alpha number.',
        'name.unique' => 'The name has already been taken.',
        'image.image' => 'The image must be image file.',
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
            $post->content = Input::get('content');
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

}
