<?php

namespace Items\Collection\Code;

use Items\Item;
use Ivy\Abstract\Controller;

class CodeController extends Controller
{
    private Code $code;
    private Item $item;

    public function __construct()
    {
        parent::__construct();
        $this->code = new Code();
        $this->item = new Item();
    }

    public function save($id, $template_route = null, $identifier = null): void
    {
        if($this->request->get('delete') !== null){
            $this->delete($id, $template_route, $identifier);
        } else {
            $this->update($id, $template_route, $identifier);
        }
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('create', $this->code);

        $parent_id = $identifier ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
        $this->code->populate(['code' => 'Insert code…', 'language' => 'php'])->insert();
        $this->item->populate(['template_id' => $id, 'parent_id' => $parent_id])->insert();

        $this->flashBag->add('success', 'Code successfully inserted');
        $this->redirect(isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('update', $this->code);

        $item = $this->item->where('id', $id)->fetchOne();
        $this->code->where('id', $item->table_id)->populate(['code' => $this->request->get('code'), 'language' => $this->request->get('language')])->update();
        $item->populate(['published' => $this->request->get('publish')])->update();
        $this->flashBag->add('success', 'Code successfully updated');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('delete', $this->code);

        $item = $this->item->where('id', $id)->fetchOne();
        $this->code->where('id', $item->table_id)->delete();
        $item->delete();

        $this->flashBag->add('success', 'Code successfully deleted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }
}
