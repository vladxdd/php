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

abstract class Storage
{
    abstract function create();

    abstract function read();

    abstract function update();

    abstract function delete();

    abstract function list();

}

abstract class View
{
    public $storage;

    public function __construct()
    {
    }

    abstract function displayTextById();

    abstract function displayTextByUrl();

}

abstract class User
{
    public $id;
    public $name;
    public $role;

    abstract function getTextsToEdit();
}

class FileStorage extends TelegraphText
{
    public static $dir = "~Desktop/PHP/Telegraph";

    public function create($text)
    {
        $x = 1;
        $fn = $text->slug . date("_d-m-y");

        while (file_exists(self::$dir . $fn)) {
            $fn = $text->slug . date("_d-m-y") . $x;
            $x++;
        }
        $text->slug = $fn;
        file_put_contents(self::$dir . $fn, serialize($text));
        return $fn;
    }

    public function read()
    {
        return unserialize(file_get_contents($this->slug));
    }

    public function update()
    {
        $sv = serialize(file_get_contents($this->slug));


    }

    public function delete()
    {
        if (unlink(self::$dir . $this->slug)) return 0;
        else return 1;
    }

    public function list()
    {
        $search = scandir(FileStorage::$dir);
    }
}


$telegraph = new TelegraphText("Vlad", "ax.txt");
$telegraph->editText("awdad", "awdwd");
$telegraph->storeText();
$telegraph->loadText();




