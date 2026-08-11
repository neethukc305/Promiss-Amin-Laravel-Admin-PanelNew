<?php
namespace Modules\Hotel;
use Modules\Core\Helpers\SitemapHelper;
use Modules\ModuleServiceProvider;
use Modules\Hotel\Models\Hotel;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(SitemapHelper $sitemapHelper){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        if(is_installed() and Hotel::isEnable()){

            $sitemapHelper->add("hotel",[app()->make(Hotel::class),'getForSitemap']);
        }
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getAdminMenu()
{
    if(!Hotel::isEnable()) return [];
    return [
        'hotel'=>[
            "position"=>32,
            'url'        => 'admin/module/hotel',
            'title'      => __('Shops'),
            'icon'       => 'fa fa-building-o',
            'permission' => 'hotel_view',
            'children'   => [
                'add'=>[
                    'url'        => 'admin/module/hotel',
                    'title'      => __('All Shops'),
                    'permission' => 'hotel_view',
                ],
                'create'=>[
                    'url'        => 'admin/module/hotel/create',
                    'title'      => __('Add new Shop'),
                    'permission' => 'hotel_create',
                ],
                'attribute'=>[
                    'url'        => 'admin/module/hotel/attribute',
                    'title'      => __('Shop Amenities'),
                    'permission' => 'hotel_manage_attributes',
                ],
                'room_attribute'=>[
                    'url'        => 'admin/module/hotel/room/attribute',
                    'title'      => __('Service Categories'),
                    'permission' => 'hotel_manage_attributes',
                ],
                'recovery'=>[
                    'url'        => 'admin/module/hotel/recovery',
                    'title'      => __('Recovery'),
                    'permission' => 'hotel_view',
                ],
            ]
        ]
    ];
}

    public static function getBookableServices()
    {
        if(!Hotel::isEnable()) return [];
        return [
            'hotel'=>Hotel::class
        ];
    }

    public static function getMenuBuilderTypes()
    {
        if(!Hotel::isEnable()) return [];
        return [
            'hotel'=>[
                'class' => Hotel::class,
                'name'  => __("Hotel"),
                'items' => Hotel::searchForMenu(),
                'position'=>41
            ]
        ];
    }


    public static function getUserMenu()
    {
        $res = [];
        if(Hotel::isEnable()){
            $res['hotel'] = [
                'url'   => route('hotel.vendor.index'),
                'title'      => __("Manage Shop"),
                'icon'       => Hotel::getServiceIconFeatured(),
                'position'   => 30,
                'permission' => 'hotel_view',
                'children' => [
                    [
                        'url'   => route('hotel.vendor.index'),
                       'title'  => __("All Shops"),
                    ],
                    [
                        'url'   => route('hotel.vendor.create'),
                        'title'      => __("Add Shop"),
                        'permission' => 'hotel_create',
                    ],
                    [
                        'url'   => route('hotel.vendor.recovery'),
                        'title'      => __("Recovery"),
                        'permission' => 'hotel_create',
                    ],
                ]
            ];
        }
        return $res;
    }

    public static function getTemplateBlocks(){
        if(!Hotel::isEnable()) return [];
        return [
            'form_search_hotel'=>"\\Modules\\Hotel\\Blocks\\FormSearchHotel",
            'list_hotel'=>"\\Modules\\Hotel\\Blocks\\ListHotel",
        ];
    }
}
