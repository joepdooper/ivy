<?php

namespace Ivy;

use Exception;

class PluginController extends Controller
{
    protected Plugin $plugin;

    public function post(Request $request = null): void
    {
        $request = $request ?? new Request();

        if ($request->isMethod('POST') && User::isLoggedIn()) {

            $plugins = $request->input('plugin') ?? '';

            foreach ($plugins as $plugin_data) {

                $this->plugin = new Plugin($plugin_data);
                
                if (!$this->plugin->hasId()) {
                    $this->plugin->setUrl($plugin_data['url'])->setInfo();
                    $this->plugin->install();
                } else {
                    $this->plugin->where('id', $this->plugin->getId())->getRow();
                    if (isset($plugin_data['delete'])) {
                        $this->plugin->uninstall();
                    } else {
                        $this->plugin->update($plugin_data);
                    }
                }
            }
        }
        Message::add('Update successfully', _BASE_PATH . 'admin/plugin');
    }

}
