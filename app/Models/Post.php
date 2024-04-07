<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;
    protected $table = 'posts';
    public $timestamps = false;
    protected $fillable = ['title', 'description'];
    public function getAllPosts()
    {
        return DB::table('posts')->get();
    }
    public function getOnePost($id)
    {
        $posts = DB::table('posts')
            ->where('id', $id)
            ->get();
        return $posts;
    }
    public function mySQLCrud()
    {
        $servername = "localhost";
        $username = "username";
        $password = "password";
        $dbname = "query_builder";
        $conn = new \mysqli($servername, $username, $password, $dbname);
        $postId = 51;
        $title = "post title";
        $description = "Post content";
        // Create Post
        $sttCreate =$conn->prepare( "INSERT INTO posts (title, description) VALUES(:title, :description)");
        $sttCreate->bind_param(':title', $title);
        $sttCreate->bind_param(':description', $description);
        $sttCreate->execute();
        echo "Post created successfully!";
        // Read Post
        $sttRead= $conn->prepare("SELECT * FROM posts WHERE id=?");
        $sttRead->bind_param("i", $postId);
        $sttRead->execute();
        $result = $sttRead->get_result();
        // Edit Post
        $newTitle = "update post title";
        $newDescription = "update Post content";
        $sttEdit = $conn->prepare("UPDATE posts SET title=:title, description=:description where id=:id");
        $sttEdit -> execute([
            ':title' => $newTitle,
            ':description' => $newDescription,
            ':id' => $postId
        ]);
        // Delete Post
        $sttDelete = $conn->prepare("DELETE FROM posts WHERE $id=?");
        $sttDelete->bind_param("i", $postId);
        $sttDelete->execute();
        $sttCreate -> close();
        $sttRead -> close();
        $sttEdit -> close();
        $sttDelete -> close();
    }
    public function PDOCrud(){
        $postId = 51;
        $title = "post title";
        $description = "Post content";
        $createPost = DB::table('posts')->insert(['title'=>$title, 'description' => $description]);
        $readPost = DB::table('posts')->where('id', $postId)->get();
        $newTitle = "update post title";
        $newDescription = "update Post content";
        $updatePost = DB::table('posts')->where('id', $postId)-> update(['title'=>$newTitle, 'description' => $newDescription]);
        $deletePost = DB::table('posts')->where('id', $postId)->delete();
    }
}
