<?php

namespace App\Controllers;

use Exception;
use App\Models\Post;
use App\Services\Auth;
use App\Routes\Request;
use App\Routes\Redirect;
use App\Controllers\Controller;
use App\Services\Policies\PostPolicy;

class PostController extends Controller {
    public function create_form() {
        $this->template->render('create-post');
    }

    public function read() {
        $post_id = Request::get("id");

        $post = $this->db->raw("
            SELECT * FROM posts
            INNER JOIN users ON users.id = posts.user_id
            WHERE posts.id = :id
        ", [":id" => $post_id]);

        $this->template->with("post", $post[0])->render("single-post");
    }

    public function delete() {
        $this->can("create", PostPolicy::class);

        $post_id = Request::get("id");

        $this->db->delete("post", ["id" => $post_id]);

        Redirect::redirect("/posts", ["success" => "Post deleted with success"]);
    }

    public function create() {
        $this->can("create", PostPolicy::class);

        $title = Request::post('title');
        $body = Request::post('body');
        $user = Auth::user();

        try {
            $post = new Post(
                null,
                $title,
                $body,
                $user["id"],
            );
        } catch(Exception $e) {
            Redirect::redirect('/create-post', ['error' => $e->getMessage()]);      
        }

        $this->db->insertModel($post);
        Redirect::redirect('/posts', ['success' => 'Post created successfully.']);      
    }

    public function read_all() {
        $posts = $this->db->selectModel("post");

        $this->template->with("posts", $posts)->render("posts");
    }
}