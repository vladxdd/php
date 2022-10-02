<?php

class TelegraphText
{
    public $title;
    public $text;
    public $author;
    public $published;
    public $slug;

    public function __construct($author, $slug)
    {
        $this->author = $author;
        $this->slug = $slug;
        $this->published = date("D: h-i-sa");
    }

    public function storeText()
    {
        $arr = array(
            "text" => $this->text,
            "title" => $this->title,
            "author" => $this->author,
            "time" => $this->published
        );
        $ser = serialize($arr);

        if (file_exists($this->slug)) {
            $current = file_get_contents($this->slug);
            $current .= $ser . "\n";
            file_put_contents($this->slug, $current);
        } else echo "File is not existing";
    }

    public function loadText()
    {

        if (file_exists($this->slug)) {
        $uns = unserialize(file_get_contents($this->slug));
        $this->title = $uns['title'];
        $this->text = $uns['text'];
        $this->author = $uns['author'];
        $this->published = $uns['time'];
        }
        return $this->text;
    }

    public function editText($title, $text)
    {
        $this->title = $title;
        $this->text = $text;
    }

}

$telegraph = new TelegraphText("Vlad", "ax.txt");
$telegraph->editText("Changed", "Uraaa");
$telegraph->storeText();
$telegraph->loadText();

