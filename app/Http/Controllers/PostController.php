<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostRequest;
use App\Providers\RouteServiceProvider;
use App\Repositories\PostRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RealRashid\SweetAlert\Facades\Alert;

class PostController extends Controller
{
    public $postsRepo;
    public function __construct(PostRepository $postsRepo)
    {
        $this->postsRepo = $postsRepo;
    }

    /**
     * Get all posts
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        $data = $this->postsRepo->getAllPostsPaginated();

        return view('home', ['posts' => $data]);
    }

    /**
     * Create a new post
     * @param CreatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(CreatePostRequest $request) {
        $this->postsRepo->create($request->validated());

        Alert::success('Success!', 'Post Created Successfully');

        return redirect(RouteServiceProvider::HOME);
    }
}
