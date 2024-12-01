<?php

namespace Audio;

use Ivy\Message;
use Ivy\Model;
use Ivy\File;
use Ivy\Template;
use Random\RandomException;

class Audio extends Model
{

    public int $id;
    public string $file;
    public string $token;

    protected string $table = 'audio';
    private const _AUDIO_PATH = 'audio' . DIRECTORY_SEPARATOR;

    public function upload($audio): string
    {
        try {
            $file = new File();
            $file->name = bin2hex(random_bytes(16));
            $file->allowed = array('audio/*');
            $file->directory = _PUBLIC_PATH . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH;
            $this->file = $file->upload($audio);
        } catch (RandomException $e) {
            Message::add($e->getMessage());
        }
        return $this->file;
    }

    public function delete_set($file = null): void
    {
        $audio = $file ?? $this->file;
        unlink(_PUBLIC_PATH . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH . $audio);
    }

    public static function set($name, $value, $id = null): void
    {
        Template::render(_PLUGIN_PATH . 'audio/template/input.TypeAudio.latte', [
            'inputAudio' => compact('name', 'value', 'id')
        ]);
    }

}
