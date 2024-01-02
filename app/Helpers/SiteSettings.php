<?php
namespace App\Helpers;

use App\Models\GeneralSetting;
use Illuminate\Database\Eloquent\Collection;

class SiteSettings {

    /**
     * @var Collection $allSiteSettings
     */
    protected $allSiteSettings;

    public function __construct() {
        $this->allSiteSettings = GeneralSetting::where('core_site_setting', TRUE)->get();
    }

    public function siteName() : string {
        $entry = $this->allSiteSettings->where('id', GeneralSetting::SITE_NAME)->first();
        return $entry->string_value;
    }

    public function tagline() : string {
        $entry = $this->allSiteSettings->where('id', GeneralSetting::SITE_TAGLINE)->first();
        return $entry->string_value;
    }

    public function siteLogo() : string {
        $entry = $this->allSiteSettings->where('id', GeneralSetting::SITE_LOGO)->first();
        return $entry->string_value;
    }

    public function getSocialLink(string $socialAccount = null) : string {
        $entry = $this->allSiteSettings->where('id', GeneralSetting::SOCIAL_LINKS)->first();
        $socialLinks = !is_array($entry->json_value) ? json_decode($entry->json_value, true) : $entry->json_value;
        if(empty($socialAccount)){
            return $socialLinks;
        }
        return $socialLinks[$socialAccount];
    }
}
