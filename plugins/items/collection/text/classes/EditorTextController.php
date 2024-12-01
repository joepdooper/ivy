<?php

namespace Text;

use Delight\Db\Throwable\EmptyWhereClauseError;
use Delight\Db\Throwable\IntegrityConstraintViolationException;
use Ivy\Controller;
use Ivy\Item;
use Ivy\Message;
use Ivy\Request;

class EditorTextController extends Controller
{
    private Text $text;
    private Item $item;

    public function __construct()
    {
        $this->text = new Text();
        $this->item = new Item();
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->getRow()->single()->id : null;
        $this->text->insert(['text' => 'Write…']);
        $this->item->insert(['template' => $id, 'parent' => $parent_id]);

        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Text inserted', $redirect);
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $request = new Request;

        $item = $this->item->where('id', $id)->getRow()->single();
        $this->text->where('id', $item->table_id)->getRow()->single();
        $this->item->update(['published' => $request->input('publish_item')]);
        $this->text->update(['text' => $request->input('text')]);

        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Text updated', $redirect);
    }
    
    public function delete($id, $template_route = null, $identifier = null): void
    {
        $item = $this->item->where('id', $id)->getRow()->single();
        $this->text->where('id', $item->table_id)->getRow()->single();
        $this->item->delete();
        $this->text->delete();

        $redirect = _BASE_PATH . (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Text deleted', $redirect);
    }
}
