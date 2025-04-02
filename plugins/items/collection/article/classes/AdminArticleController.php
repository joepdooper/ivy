<?php

namespace Items\Collection\Article;

use Exception;
use Items\Item;
use Items\ItemHelper;
use Ivy\Abstract\Controller;

class AdminArticleController extends Controller
{
    private Article $article;
    private Item $item;

    public function __construct()
    {
        $this->article = new Article();
        $this->item = new Item();
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        try {
            $parent_id = isset($identifier) ? (new Item)->where('slug', $identifier)->fetchOne()->id : null;
            $slug = ItemHelper::createSlug('Title');
            $this->article->insert(['title' => 'Title', 'subtitle' => 'Subtitle', 'subject' => DatabaseManager::connection()->selectValue('SELECT `id` FROM `tag` LIMIT 0, 1', [])]);
            $this->item->insert(['template' => $id, 'parent' => $parent_id, 'slug' => $slug]);

            $redirect = (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
            Message::add('Article inserted', $redirect);
        } catch (Exception $e) {
            Message::add($e->getMessage(), '');
        }
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $request = new Request;

        try {
            $item = $this->item->where('id', $id)->fetchOne();
            $article = $this->article->where('id', $item->table_id)->fetchOne();

            if ($request->input('datetime') !== null) {
                $this->item->update(['published' => $request->input('publish_item'), 'date' => $request->input('datetime')]);
            } else {
                $this->item->update(['published' => $request->input('publish_item')]);
            }

            $title = $request->input('title') ?? $article->title;
            $subtitle = $request->input('subtitle') ?? $article->subtitle;
            $subject = $request->input('tag') ?? $article->subject;
            $image = $request->input('delete_image') !== null ? NULL : $article->image;
            $slug = ItemHelper::createSlug($title);

            if ($request->input('delete_image') !== null) {
                (new Image)->deleteSet($article->image);
            }

            if (!empty($request->input('upload_image')['name'])) {
                $image = (new Image)->upload($request->input('upload_image'));
            }

            $this->article->update(['title' => $title, 'subtitle' => $subtitle, 'subject' => $subject, 'image' => $image]);
            $this->item->update(['slug' => $slug]);

            $redirect = (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($slug) : "");
            Message::add('Article updated', $redirect);
        } catch (Exception $e) {
            Message::add($e->getMessage(), '');
        }
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        try {
            $this->item->where('id', $id)->getRow();
            $this->article->where('id', $this->item->single()->table_id)->getRow();
            if ($this->article->single()->image) {
                (new Image)->deleteSet($this->article->single()->image);
            }
            $this->item->delete();
            $this->article->delete();

            $redirect = (isset($identifier) ? htmlentities($template_route) . DIRECTORY_SEPARATOR . htmlentities($identifier) : "");
            Message::add('Article deleted', $redirect);
        } catch (Exception $e) {
            Message::add($e->getMessage(), '');
        }
    }
}
