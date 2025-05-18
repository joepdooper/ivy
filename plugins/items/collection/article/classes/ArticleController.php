<?php

namespace Items\Collection\Article;

use Items\Collection\Image\ImageService;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;
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

    public function save($id): void
    {
        if($this->request->get('delete') !== null){
            $this->delete($id);
        } else {
            $this->update($id);
        }
    }

    public function insert($id): void
    {
        $this->article->policy('create');

        $this->item->table_id = $this->article->populate([
            'title' => 'Title',
            'subtitle' => 'Subtitle',
            'subject' => $this->tag->fetchOne()->getId()
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'slug' => ItemHelper::createSlug('Title')
        ])->insert();

        $this->flashBag->add('success', 'Article successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->article->policy('update');

        $item = $this->item->where('id', $id)->fetchOne();
        $article = $this->article->where('id', $item->table_id)->fetchOne();

        if($this->request->request->has('title')){
            $article->title = $this->request->request->get('title');
            $slug = ItemHelper::slugify($this->request->request->get('title'));
            if($item->slug !== $slug){
                $item->slug = $slug;
            }
        }
        if($this->request->request->has('subtitle')){
            $article->subtitle = $this->request->request->get('subtitle');
        }
        if($this->request->request->has('tag')){
            $article->subject = $this->request->request->get('tag');
        }
        if($this->request->files->has('image')){
            $article->image = ImageService::upload($this->request->files->get('image'));
        }
        if($this->request->request->has('remove')){
            $article->image = ImageService::unlink($article->image);
        }

        $article->update();

        if($this->request->request->has('datetime')){
            $item->date = $this->request->request->get('datetime');
        }

        $item->populate([
            'published' => $this->request->get('publish'),
        ])->update();

        $this->flashBag->add('success', 'Article successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->article->policy('delete');

        $item = $this->item->where('id', $id)->fetchOne();
        $article = $this->article->where('id', $item->table_id)->fetchOne();
        ImageService::unlink($article->image);
        $article->delete();
        $item->delete();

        $this->flashBag->add('success', 'Article successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
