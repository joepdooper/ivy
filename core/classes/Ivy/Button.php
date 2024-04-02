<?php
namespace Ivy;

class Button {

    public static function delete($name = null, $value = null, $id = null, $formaction = null): void
    {
        include Template::file('buttons/button.delete.php');
        include Template::file('buttons/button.confirm.php');
    }

    public static function remove($name = null, $value = null): void
    {
        include Template::file('buttons/button.remove.php');
    }

    public static function close($name = null, $value = null): void
    {
        include Template::file('buttons/button.close.php');
    }

    public static function save($text = null, $value = null): void
    {
        include Template::file('buttons/button.save.php');
    }

    public static function confirm($text = null, $value = null): void
    {
        include Template::file('buttons/button.confirm.php');
    }

    public static function submit($text = null): void
    {
        include Template::file('buttons/button.submit.php');
    }

    public static function link($url = null, $text = null, $icon = null, $label = null): void
    {
        include Template::file('buttons/button.link.php');
    }

    public static function upload($name = null, $value = null, $id = null): void
    {
        include Template::file('buttons/button.upload.php');
    }

    public static function switch($name = null, $value = null, $id = null): void
    {
        include Template::file('buttons/button.switch.php');
    }

    public static function visible($name = null, $value = null, $id = null): void
    {
        include Template::file('buttons/button.visible.php');
    }

}
