<?php

namespace Tag;

use GUMP;
use Ivy\Controller;
use Ivy\Message;
use Ivy\Request;
use Ivy\User;

class TagController extends Controller
{
    protected Tag $tag;

    public function post(Request $request = null): void
    {
        $request = $request ?? new Request();
        $this->tag = new Tag;

        if ($request->isMethod('POST') && User::isLoggedIn()) {
            foreach ($request->all()['tag'] as $row) {
                try {
                    $validated = GUMP::is_valid($row, [
                        'value' => 'alpha_numeric_dash'
                    ]);
                    if ($validated === true) {
                        $this->tag->save($row);
                    } else {
                        foreach ($validated as $string) {
                            Message::add($string);
                        }
                    }
                } catch (\Exception $e) {
                    Message::add($e->getMessage());
                }
            }
        }

        Message::add('Updated successful', $this->tag->getPath());
    }
}
