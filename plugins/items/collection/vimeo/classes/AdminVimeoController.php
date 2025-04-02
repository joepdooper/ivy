<?php

namespace Items\Collections\Vimeo;

use Items\ItemController;

class AdminVimeoController extends ItemController
{
    private Vimeo $vimeo;

    public function __construct()
    {
        $this->vimeo = new Vimeo;
        parent::__construct();
    }

    public function insert($id, $template_route = null, $identifier = null): void
    {
        $this->vimeo->insert(['vimeo_video_id' => '876176995']);
        parent::insert($id, $template_route, $identifier);
    }

    public function update($id, $template_route = null, $identifier = null): void
    {
        $vimeo = $this->vimeo->where('id', $this->item->table_id)->fetchOne();
        $vimeo_video_id = $this->request->input('vimeo_video_id') ?? $vimeo->vimeo_video_id;
        $this->vimeo->update(['vimeo_video_id' => $vimeo_video_id]);
        parent::update($id, $template_route, $identifier);
    }

    public function delete($id, $template_route = null, $identifier = null): void
    {
        $this->vimeo->where('id', $this->item->single()->table_id)->getRow();
        $this->vimeo->delete();
        parent::delete($id, $template_route, $identifier);
    }
}
