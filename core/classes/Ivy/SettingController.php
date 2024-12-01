<?php

namespace Ivy;

use Exception;

class SettingController extends Controller
{
    protected Setting $setting;

    public function post(Request $request = null): void
    {
        $request = $request ?? new Request();

        if ($request->isMethod('POST') && User::isLoggedIn()) {
            $settings = $request->input('setting') ?? '';

            foreach ($settings as $setting_data) {
                $this->setting = new Setting();

                if (!isset($setting_data['id'])) {
                    if (!empty($setting_data['name'])) {
                        try {
                            $this->setting->insert($setting_data);
                            Message::add('Update successfully');
                        } catch (Exception $e) {
                            Message::add("Error inserting setting: " . $e->getMessage());
                        }
                    }
                } else {
                    $this->setting->where('id', $setting_data['id'])->getRow();
                    if (isset($setting_data['delete'])) {
                        try {
                            $this->setting->delete();
                            Message::add('Delete successfully');
                        } catch (Exception $e) {
                            Message::add("Error deleting setting: " . $e->getMessage());
                        }
                    } else {
                        try {
                            $this->setting->update($setting_data);
                            Message::add('Update successfully');
                        } catch (Exception $e) {
                            Message::add("Error updating setting: " . $e->getMessage());
                        }
                    }
                }
            }
        }
        Message::add('Update successfully', _BASE_PATH . 'admin/setting');
    }
}