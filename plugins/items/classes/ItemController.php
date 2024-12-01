<?php

namespace Items;

use Ivy\Controller;
use Ivy\Message;
use Ivy\Request;

abstract class ItemController extends Controller
{

    protected Item $item;
    protected Request $request;
    public ?string $slug = null;

    public function __construct()
    {
        $this->item = new Item;
        $this->request = new Request;
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        try {
            $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->getRow()->single()->id : null;
            $slug = ItemHelper::createSlug($this->slug);
            $this->item->insert(['template' => $id, 'parent' => $parent_id, 'slug' => $slug]);

            $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
            Message::add('Item inserted', $redirect);
        } catch (\Exception $e) {
            Message::add($e->getMessage(), _BASE_PATH);
        }
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        try {
            $slug = ItemHelper::createSlug($this->slug);
            $this->item->update(['slug' => $slug]);

            $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
            Message::add('Item updated', $redirect);
        } catch (\Exception $e) {
            Message::add($e->getMessage(), _BASE_PATH);
        }
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        try {
            $this->item->where('id', $id)->getRow();
            $this->item->delete();

            $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
            Message::add('Item deleted', $redirect);
        } catch (\Exception $e) {
            Message::add($e->getMessage(), _BASE_PATH);
        }
    }
}