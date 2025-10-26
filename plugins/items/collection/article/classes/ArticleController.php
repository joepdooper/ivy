<?php

namespace Items\Collection\Article;

use Items\Collection\Image\ImageFile;
use Items\Collection\Image\ImageFileService;
use Items\Collection\Image\ImageSize;
use Items\CollectionController;
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

        $item_table_id = $this->article->populate([
            'title' => 'Title',
            'subtitle' => 'Subtitle',
        ])->insert();

        $this->item->populate([
            'template_id' => $id,
            'parent_id' => ItemHelper::getParentId($this->request),
            'slug' => ItemHelper::createSlug('Title'),
            'table_id' => $item_table_id,
        ])->insert();

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
        if($this->request->files->get('image')){
            $files = [];
            $file = new ImageFile($this->request->files->get('image'));
            $file->generateFileName();
            foreach ((new ImageSize)->fetchAll() as $imageSize) {
                $files[] = clone $file
                    ->setUploadPath('item'. DIRECTORY_SEPARATOR . $imageSize->name)
                    ->setImageWidth($imageSize->value);
            }
            $article->image = $file->getFileName();
            (new ImageFileService)->add($files)->upload();
        }

        if($this->request->request->has('remove')){
            $file = new ImageFile();
            foreach ((new ImageSize)->fetchAll() as $imageSize) {
                $file->setUploadPath('item'. DIRECTORY_SEPARATOR . $imageSize->name)->remove($article->image);
            }
            $article->image = '';
        }

        $article->update();

        if($this->request->request->has('datetime')){
            $this->article->getItem()->date = $this->request->request->get('datetime');
        }

        $this->article->getItem()->populate([
            'publish' => $this->request->get('publish'),
        ])->update();

        $this->flashBag->add('success', 'Article successfully updated');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }

    public function delete($id): void
    {
        $this->article->policy('delete');

        $this->article->fetchOneWithItem($id)->delete();

        $this->flashBag->add('success', 'Article successfully deleted');
        $this->redirect(ItemHelper::getRedirect($this->request));
    }
}
