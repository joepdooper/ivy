<?php

namespace Image;

use Exception;
use GUMP;
use Ivy\Controller;
use Ivy\Message;
use Ivy\Request;
use Ivy\User;

class ImageSizeController extends Controller
{
    protected ImageSize $image_size;

    public function post(Request $request = null): void
    {
        $request = $request ?? new Request();
        $this->image_size = new ImageSize;

        if ($request->isMethod('POST') && User::isLoggedIn()) {
            foreach ($request->all()['image_sizes'] as $row) {
                try {
                    $validated = GUMP::is_valid($row, [
                        'value' => 'alpha_numeric_dash'
                    ]);
                    if ($validated === true) {
                        $this->image_size->save($row);
                    } else {
                        foreach ($validated as $string) {
                            Message::add($string);
                        }
                    }
                } catch (Exception $e) {
                    Message::add($e->getMessage());
                }
            }
        }

        Message::add('Updated successful', $this->image_size->getPath());
    }
}
