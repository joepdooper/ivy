<?php

namespace Tag;

use GUMP;
use Ivy\Controller;
use Ivy\Message;

class TagController extends Controller
{
    protected Tag $tag;

    public function post(): void
    {
        $this->requirePost();
        $this->requireLogin();

        $tags_data = $this->request->input('tag') ?? '';

        foreach ($tags_data as $tag_data) {
            try {
                $validated = GUMP::is_valid($tag_data, [
                    'value' => 'alpha_numeric_dash'
                ]);
                if ($validated === true) {
                    $this->tag = new Tag;
                    $this->tag->save($tag_data);
                } else {
                    foreach ($validated as $string) {
                        Message::add($string);
                    }
                }
            } catch (\Exception $e) {
                Message::add($e->getMessage());
            }
        }

        Message::add('Updated successful', $this->tag->getPath() . DIRECTORY_SEPARATOR . 'manage');
    }
}
