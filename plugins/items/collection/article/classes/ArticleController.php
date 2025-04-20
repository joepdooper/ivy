<?php

namespace Items\Collection\Article;

use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;
use Ivy\Model\Profile;
use Ivy\Model\Setting;
use Ivy\Path;
use Ivy\View\LatteView;
use Tag\Tag;

class ArticleController extends Controller
{
    private Article $article;
    private Item $item;
    private Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->article = new Article();
        $this->item = new Item();
        $this->tag = new Tag();
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
        $this->authorize('create', $this->article);

        $parent_id = $identifier ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
        $slug = ItemHelper::createSlug('Title');

        $this->article->populate(['title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => $this->tag->where('value', 'Article')->fetchOne()->id])->insert();
        $this->item->populate(['template_id' => $id, 'parent_id' => $parent_id, 'slug' => $slug])->insert();

        $this->flashBag->add('success', 'Article successfully inserted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('update', $this->article);

        $item = $this->item->where('id', $id)->fetchOne();
        $article = $this->article->where('id', $item->table_id)->fetchOne();

        $article->update();
        $item->populate(['published' => $this->request->get('publish')])->update();

        $this->flashBag->add('success', 'Article successfully updated');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        $this->authorize('delete', $this->article);

        $item = $this->item->where('id', $id)->fetchOne();
        $this->article->where('id', $item->table_id)->delete();
        $item->delete();

        $this->flashBag->add('success', 'Article successfully deleted');
        $this->redirect($identifier ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : '');
    }

    public function page($slug): void
    {
        $this->authorize('read', $this->article);

        $item = $this->item->where('slug', $slug)->fetchOne();
        $article = $this->article->where('id', $item->table_id)->fetchOne();
        $tag = (new Tag)->where('id', $article->subject)->fetchOne();
        $author = (new Profile)->where('id', $item->user_id)->fetchOne();
        Setting::getStash()['title']->value = Setting::getStash()['title']->value . " - " . $article->title;
        $items = (new Item)->where('parent_id', $item->id)->sortBy(['sort', 'date', 'id'])->fetchAll();
        LatteView::render(Path::get('PLUGIN_PATH') . $item->plugin_url . '/template/page.latte', ['item' => $item, 'article' => $article, 'tag' => $tag, 'author' => $author, 'items' => $items]);
    }
}
