<?php

namespace Audio;

use Delight\Db\Throwable\EmptyWhereClauseError;
use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Exception;
use Ivy\Controller;
use Ivy\Item;
use Ivy\Message;
use Ivy\Request;

class EditorAudioController extends Controller
{
    private Audio $audio;
    private Item $item;

    public function __construct()
    {
        $this->audio = new Audio();
        $this->item = new Item();
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");

        try {
            $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->getRow()->single()->id : null;
            $this->audio->insert(['file' => null]);
            $this->item->insert(['template' => $id, 'parent' => $parent_id]);
            Message::add('Audio inserted', $redirect);
        } catch (Exception $e) {
            Message::add($e->getMessage(), $redirect);
        }
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $request = new Request;
        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");

        try {
            $item = $this->item->where('id', $id)->getRow()->single();
            $audio = $this->audio->where('id', $item->table_id)->getRow()->single();
            if ($request->input('delete_audio') !== null) {
                $this->audio->delete_set();
            }
            $audio->file = $request->input('delete_audio') !== null ? null : $audio->file;
            if (!empty($request->file('upload_audio')['name'])) {
                $audio->file = $this->audio->upload($request->file('upload_audio'));
            }
            $this->item->update(['published' => $request->input('publish_item')]);
            $this->audio->update(['file' => $audio->file]);

            Message::add('Audio updated', $redirect);
        } catch (Exception $e) {
            Message::add($e->getMessage(), $redirect);
        }
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");

        try {
            $item = $this->item->where('id', $id)->getRow()->single();
            $audio = $this->audio->where('id', $item->table_id)->getRow()->single();
            if (!empty($audio->file)) {
                $this->audio->delete_set();
            }
            $this->item->delete();
            $this->audio->delete();

            Message::add('Audio deleted', $redirect);
        } catch (Exception $e) {
            Message::add($e->getMessage(), $redirect);
        }
    }

}
