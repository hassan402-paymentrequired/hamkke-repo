<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GeneralSetting;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\File;
use App\Helpers\SiteSettings;

class GeneralSettingsController extends Controller
{
    const RULE_NULLABLE_URL = 'nullable|url';

    public function siteSettings(Request $request)
    {
        $siteSettings = new SiteSettings();
        if (request()->isMethod('GET')) {
            return view('settings.site-settings', compact('siteSettings'));
        }
        
        $request->validate([
            'site_name' => 'required|string',
            'tagline' => 'required|string',
            'site_logo' => ['nullable', File::image()->types(['png', 'jpg', 'jpeg'])->min('2kb')->max('2mb')],
            'social_facebook' => self::RULE_NULLABLE_URL,
            'social_instagram' => self::RULE_NULLABLE_URL,
            'social_twitter' => self::RULE_NULLABLE_URL,
            'social_youtube' => self::RULE_NULLABLE_URL,
        ]);
        GeneralSetting::where('id', GeneralSetting::SITE_NAME)->update([
            'string_value' => $request->site_name
        ]);
        GeneralSetting::where('id', GeneralSetting::SITE_TAGLINE)->update([
            'string_value' => $request->tagline
        ]);
        if($request->site_logo) {
            $siteLogo = uploadFilesFromRequest($request, 'site_logo', 'core-uploads', strtolower("{$request->site_name}_logo"));
            GeneralSetting::where('id', GeneralSetting::SITE_LOGO)->update([
                'string_value' => $siteLogo
            ]);
        }
        GeneralSetting::where('id', GeneralSetting::SOCIAL_LINKS)->update([
            'json_value' => json_encode([
                SOCIAL_LINK_FACEBOOK => $request->social_facebook ?: $siteSettings->getSocialLink(SOCIAL_LINK_FACEBOOK),
                SOCIAL_LINK_INSTAGRAM => $request->social_instagram ?: $siteSettings->getSocialLink(SOCIAL_LINK_INSTAGRAM),
                SOCIAL_LINK_TWITTER => $request->social_twitter ?: $siteSettings->getSocialLink(SOCIAL_LINK_TWITTER),
                SOCIAL_LINK_YOUTUBE => $request->social_youtube ?: $siteSettings->getSocialLink(SOCIAL_LINK_YOUTUBE),
            ])
        ]);

        flashSuccessMessage('Site settings updated successfully');
        return back();
    }
}
