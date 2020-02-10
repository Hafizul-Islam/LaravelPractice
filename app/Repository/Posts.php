<?php

namespace App\Repository;

use App\Post;

class Posts {

   public function allPosts( $orderBy= null)
    {
       return Post::all();
    }

}