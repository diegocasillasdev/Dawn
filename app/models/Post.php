<?php


class Post extends Model
{
    protected $author;
    protected $title;
    protected $body;
    protected $comments = [];

    public function __construct()
    {
        $this->comments();
    }

    public function save()
    {
        $sql = "
            INSERT INTO posts(author, title, body)
            VALUES('{$this->author}', '{$this->title}', '{$this->body}')
        ";
        $this->db->exec($sql);
    }

    public function setAuthor($author)
    {
        $this->author = $author;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setBody($body)
    {
        $this->body = $body;
    }

    public function comments()
    {
        die(var_dump($this->id));
        $this->comments = Comment::getByPost($this->id);
    }

    public function getComments()
    {
        return $this->comments;
    }
}
