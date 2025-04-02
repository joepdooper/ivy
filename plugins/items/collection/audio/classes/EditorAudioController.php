<?php

namespace Items\Collections\Audio;

use Exception;
use Items\Item;
use Ivy\Controller;

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
        $redirect = (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");

        try {
            $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
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
        $redirect = Path::get('BASE_PATH') . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");

        try {
            $item = $this->item->where('id', $id)->fetchOne();
            $audio = $this->audio->where('id', $item->table_id)->fetchOne();
            if ($request->input('delete_audio') !== null) {
                $this->audio->deleteSet();
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
        $redirect = (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");

        try {
            $item = $this->item->where('id', $id)->fetchOne();
            $audio = $this->audio->where('id', $item->table_id)->fetchOne();
            if (!empty($audio->file)) {
                $this->audio->deleteSet();
            }
            $this->item->delete();
            $this->audio->delete();

            Message::add('Audio deleted', $redirect);
        } catch (Exception $e) {
            Message::add($e->getMessage(), $redirect);
        }
    }

}
