<?php

namespace Items\Collection\Text;

use Items\Item;
use Ivy\Abstract\Controller;

class TextController extends Controller
{
    private Text $text;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->text = new Text();
        $this->item = new Item();
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
        $this->text->populate(['text' => 'Write…'])->insert();
        $this->item->populate(['template_id' => $id, 'parent_id' => $parent_id])->insert();

        $this->flashBag->add('success', 'Text inserted');
        $this->redirect(isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $item = $this->item->where('id', $id)->fetchOne();
        $this->text->where('id', $item->table_id)->fetchOne();
        $this->item->populate(['published' => $this->request->get('publish_item')])->update();
        $this->text->populate(['text' => $this->request->get('text')])->update();

        $redirect = (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Text updated', $redirect);
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        $item = $this->item->where('id', $id)->fetchOne();
        $this->text->where('id', $item->table_id)->fetchOne();
        $this->item->delete();
        $this->text->delete();

        $redirect = (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
        Message::add('Text deleted', $redirect);
    }
}
