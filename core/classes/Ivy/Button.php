<?php

namespace Ivy;

class Button
{

    public static function delete($name = null, $value = null, $id = null, $form_action = null): void
    {
        Template::render('buttons/button.delete.latte', ['name' => $name, 'value' => $value, 'id' => $id]);
    }

    public static function remove($name = null, $value = null): void
    {
        Template::render('buttons/button.remove.latte', ['name' => $name, 'value' => $value]);
    }

    public static function close($name = null, $value = null): void
    {
        Template::render('buttons/button.close.latte', ['name' => $name, 'value' => $value]);
    }

    public static function save($text = null, $value = null): void
    {
        Template::render('buttons/button.save.latte', ['text' => $text, 'value' => $value]);
    }

    public static function confirm($text = null, $value = null, $form_action = null): void
    {
        Template::render('buttons/button.confirm.latte', ['text' => $text, 'value' => $value, 'form_action' => $form_action]);
    }

    public static function submit($text = null): void
    {
        Template::render('buttons/button.submit.latte', ['text' => $text]);
    }

    public static function link($url = null, $text = null, $icon = null, $label = null): void
    {
        Template::render('buttons/button.link.latte', ['url' => $url, 'text' => $text, 'icon' => $icon, 'label' => $label]);
    }

    public static function upload($name = null, $value = null, $id = null): void
    {
        Template::render('buttons/button.upload.latte', ['name' => $name, 'value' => $value, 'id' => $id]);
    }

    public static function switch($name = null, $value = null, $id = null): void
    {
        Template::render('buttons/button.switch.latte', ['name' => $name, 'value' => $value, 'id' => $id]);
    }

    public static function visible($name = null, $value = null, $id = null): void
    {
        Template::render('buttons/button.visible.latte', ['name' => $name, 'value' => $value, 'id' => $id]);
    }

}
