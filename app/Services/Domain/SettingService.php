<?php

namespace App\Services\Domain;


use App\Entities\Setting;

class SettingService
{

    public function getSetting($name) {
        $setting = Setting::where('name', $name)->first();
        if (empty($setting->value)) {
            return NEED_TO_CONFIG;
        }
        return $setting->value;
    }

    public function getAllSettings() {
        $settings = Setting::all();
        $result = array();
        foreach ($settings as $setting) {
            $result[$setting->name] = $setting->value;
        }
        return $result;
    }

    public function updateSetting($name, $value) {
        $setting = Setting::where('name', $name)->first();
        if($setting['canChange'] && $setting['value'] != $value) {
            $setting['value'] = $value;
            $setting->save();
        }
    }
}
