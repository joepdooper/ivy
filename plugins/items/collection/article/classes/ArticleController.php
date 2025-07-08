<?php

namespace Items\Collection\Article;

use Items\Collection\Image\ImageService;
use Items\CollectionController;
use Items\Item;
use Items\ItemHelper;
use Tags\Tag;

class ArticleController extends CollectionController
{
    private Article $article;
    private Tag $tag;

    public function __construct()
    {
        parent::__construct();
        $this->article = new Article();
        $this->tag = new Tag();
    }

    public function insert($id): void
    {
        $this->article->policy('create');

        $articleId = $this->article->populate([
            'title' => 'Title',
            'subtitle' => 'Subtitle',
        ])->insert();

        $this->item = (new Item)->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'slug' => ItemHelper::createSlug('Title'),
            'table_id' => $articleId,
        ]);

        $this->item->insert();

        $this->article->attachTag($this->tag->fetchOne()->getId());

        $this->flashBag->add('success', 'Article successfully inserted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function update($id): void
    {
        $this->article->policy('update');

        $article = $this->article->fetchOneWithItem($id);

        if($this->request->request->has('title')){
            $article->title = $this->request->request->get('title');
            $slug = ItemHelper::slugify($this->request->request->get('title'));
            if($this->article->getItem()->slug !== $slug){
                $this->article->getItem()->slug = $slug;
            }
        }
        if($this->request->request->has('subtitle')){
            $article->subtitle = $this->request->request->get('subtitle');
        }
        if($this->request->request->has('tag')){
            // tag
        }
        if($this->request->files->has('image')){
            $article->image = ImageService::upload($this->request->files->get('image'));
        }
        if($this->request->request->has('remove')){
            $article->image = ImageService::unlink($article->image);
        }

        $article->update();

        if($this->request->request->has('datetime')){
            $this->article->getItem()->date = $this->request->request->get('datetime');
        }

        $this->article->getItem()->populate([
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
