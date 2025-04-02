<?php

namespace Items\Collections\Audio;

use Ivy\Model;
use Ivy\File;
use Ivy\Path;
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
            $file->setName(bin2hex(random_bytes(16)));
            $file->allowed = array('audio/*');
            $file->directory = Path::get('PUBLIC_PATH') . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH;
            $this->file = $file->upload($audio);
        } catch (RandomException $e) {
            Message::add($e->getMessage());
        }
        return $this->file;
    }

    public function deleteSet($file = null): void
    {
        $audio = $file ?? $this->file;
        unlink(Path::get('PUBLIC_PATH') . _MEDIA_PATH . 'item/' . self::_AUDIO_PATH . $audio);
    }

    public static function set($name, $value, $id = null): void
    {
        Template::render(_PLUGIN_PATH . 'audio/template/input.TypeAudio.latte', [
            'inputAudio' => compact('name', 'value', 'id')
        ]);
    }

}
