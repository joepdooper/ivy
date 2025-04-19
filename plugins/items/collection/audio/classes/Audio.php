<?php

namespace Items\Collection\Audio;

use Ivy\Abstract\Model;
use Ivy\File;
use Ivy\Path;

class Audio extends Model
{
    protected string $table = 'audio';
    protected array $columns = [
        'text',
        'token'
    ];

    protected ?string $file;
    protected ?string $token;

    private const _AUDIO_PATH = 'audio' . DIRECTORY_SEPARATOR;

    public function upload($audio): string
    {
        try {
            $file = new File();
            $file->setName(bin2hex(random_bytes(16)));
            // $file->getAllowed(array('audio/*'));
            // $file->getDirectory(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/' . self::_AUDIO_PATH);
            $this->file = $file->upload($audio);
        } catch (\Exception $e) {
            error_log($e->getMessage());
        }
        return $this->file;
    }

    public function unlinkFile(): static
    {
        if($this->file){
            unlink(Path::get('PUBLIC_PATH') . Path::get('MEDIA_PATH') . 'item/' . self::_AUDIO_PATH . $this->file);
        }
        $this->file = '';
        return $this;
    }

}
