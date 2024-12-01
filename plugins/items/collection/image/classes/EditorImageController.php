<?php

namespace Image;

use Delight\Db\Throwable\EmptyWhereClauseError;
use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\Controller;
use Ivy\Item;
use Ivy\Message;
use Ivy\Request;
use Random\RandomException;

class EditorImageController extends Controller
{
    private Image $image;
    private Item $item;

    public function __construct()
    {
        $this->image = new Image();
        $this->item = new Item();
    }

    /**
     * @throws IntegrityConstraintViolationException
     */
    public function insert($id, $template_route = null, $identifier = null): void
    {
        $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->getRow()->single()->id : null;
        $this->image->insert(['file' => null]);
        $this->item->insert(['template' => $id, 'parent' => $parent_id]);

        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Image inserted', $redirect);
    }

    /**
     * @throws IntegrityConstraintViolationException
     * @throws RandomException
     */
    public function update($id, $template_route = null, $identifier = null): void
    {
        $request = new Request;

        $item = $this->item->where('id', $id)->getRow()->single();
        $image = $this->image->where('id', $item->table_id)->getRow()->single();
        if ($request->input('delete_image') !== null) {
            $this->image->delete_set();
        }
        $image->file = $request->input('delete_image') !== null ? NULL : $image->file;
        if (!empty($request->file('upload_image')['name'])) {
            $image->file = $this->image->upload($request->file('upload_image'));
        }
        $this->item->update(['published' => $request->input('publish_item')]);
        $this->image->update(['file' => $image->file]);

        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Image updated', $redirect);
    }

    /**
     * @throws EmptyWhereClauseError
     */
    public function delete($id, $template_route = null, $identifier = null): void
    {
        $item = $this->item->where('id', $id)->getRow()->single();
        $image = $this->image->where('id', $item->table_id)->getRow()->single();
        if (!empty($image->file)) {
            $this->image->delete_set();
        }
        $this->item->delete();
        $this->image->delete();

        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Image deleted', $redirect);
    }
}
