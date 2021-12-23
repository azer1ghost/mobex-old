<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Setting
 *
 * @property int $id
 * @property string|null $header_logo
 * @property string|null $footer_logo
 * @property string|null $email
 * @property string|null $location
 * @property string|null $address
 * @property string|null $address_turkey
 * @property string|null $phone
 * @property string|null $facebook
 * @property string|null $twitter
 * @property string|null $instagram
 * @property string|null $linkedin
 * @property string|null $about_cover
 * @property string|null $shop_cover
 * @property string|null $tariffs_cover
 * @property string|null $calculator_cover
 * @property string|null $faq_cover
 * @property string|null $contact_cover
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereAboutCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCalculatorCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereContactCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereFaqCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereFooterLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereHeaderLogo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereLinkedin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereShopCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereTariffsCover($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting query()
 * @property string|null $email_turkey
 * @property string|null $phone_turkey
 * @property string|null $app_store
 * @property string|null $google_play
 * @property string|null $working_hours
 * @property string|null $contact_map
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereAddressTurkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereAppStore($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereContactMap($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereEmailTurkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereGooglePlay($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting wherePhoneTurkey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereWorkingHours($value)
 * @property string|null $whatsapp
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Setting whereWhatsapp($value)
 */
class Setting extends Model
{
    /**
     * @var string
     */
    public $uploadDir = 'uploads/setting/';
}
