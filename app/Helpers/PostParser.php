<?php

namespace App\Helpers;

use App\Models\ForumDiscussion;
use App\Models\ForumPost;
use App\Models\Post;
use nadar\quill\Lexer as QuillParser;
use Everyday\HtmlToQuill\HtmlConverter;
use nadar\quill\listener\Image;

class PostParser
{
    protected Post|ForumPost|ForumDiscussion $post;
    public function __construct($post)
    {
        $this->post = $post;
    }

    public function parsePostBody()
    {
        $quillParser = new QuillParser($this->post->body);
        $quillParser->overwriteListener(new Image(), new ImageListenerCustom());
        return $quillParser;
    }

    public static function getQuillFromHtml($htmlString)
    {
        $converter = new HtmlConverter();
        return json_encode($converter->convert($htmlString));
    }
}
