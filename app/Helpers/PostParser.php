<?php

namespace App\Helpers;

use App\Models\Post;
use nadar\quill\Lexer as QuillParser;
use Everyday\HtmlToQuill\HtmlConverter;

class PostParser
{
    protected $post;
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function parsePostBody()
    {
        return new QuillParser($this->post->body);
    }

    public static function getQuillFromHtml($htmlString)
    {
        $converter = new HtmlConverter();
        return json_encode($converter->convert($htmlString));
    }
}
