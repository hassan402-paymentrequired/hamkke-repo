<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class GeneralSetting
 *
 * @property int $id
 * @property string $name
 * @property string $string_value
 * @property array $json_value
 * @property bool $core_site_setting
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class GeneralSetting extends Model
{
	protected $table = 'general_settings';

	protected $casts = [
		'json_value' => 'json',
		'core_site_setting' => 'bool'
	];

	protected $fillable = [
		'name',
		'string_value',
		'json_value',
		'core_site_setting'
	];

    const SITE_NAME = 1;
    const SITE_TAGLINE = 2;
    const SITE_LOGO = 3;
    const SOCIAL_LINKS = 4;

    const SOCIAL_LINK_FACEBOOK='facebook';
    const SOCIAL_LINK_INSTAGRAM='instagram';
    const SOCIAL_LINK_TWITTER='twitter';
    const SOCIAL_LINK_YOUTUBE='youtube';

    public static function seedData()
    {
        return [
            [
                'id' => self::SITE_NAME,
                'name' => 'Site Name',
                'string_value' => 'Hamkke',
                'json_value' => null,
                'core_site_setting' => TRUE
            ],
            [
                'id' => self::SITE_TAGLINE,
                'name' => 'Tagline',
                'string_value' => 'A Space Of Knowledge, Fun And Friendship',
                'json_value' => null,
                'core_site_setting' => TRUE
            ],
            [
                'id' => self::SITE_LOGO,
                'name' => 'Site Logo',
                'string_value' => asset('images/logo.jpeg'),
                'json_value' => null,
                'core_site_setting' => TRUE
            ],
            [
                'id' => self::SOCIAL_LINKS,
                'name' => 'Social Links',
                'string_value' => null,
                'json_value' => json_encode([
                    self::SOCIAL_LINK_FACEBOOK => 'https://www.facebook.com/hamkkechingus',
                    self::SOCIAL_LINK_INSTAGRAM => 'https://www.instagram.com/darlingdaraa',
                    self::SOCIAL_LINK_TWITTER => 'https://www.twitter.com/ham_kke',
                    self::SOCIAL_LINK_YOUTUBE => 'https://www.youtube.com/c/darlingdaraa'
                ]),
                'core_site_setting' => TRUE
            ]
        ];

    }
}
