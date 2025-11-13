<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    protected $shops = [
        'Sultan_marg' => [
            'name' => 'كشري السلطان',
            'fullAddress' => 'المرج - فرع الشارع الجديد الشرفا ',
            'shortAddress' => 'المرج فرع الشارع الجديد الشرفا',
            'slug' => 'Sultan_marg',
            'image' => 'images/Sultan_marg/Sul_marg1.jpg',
            // support multiple menu images
            'menuImages' => [
                'images/Sultan_marg/Sul_marg4.jpg',
                'images/Sultan_marg/Sul_marg5.jpg',
            ],
            'deliveryNumbers' => ['01069113030', '01120205827','01144594460'],
        ],
        'Sul_alarb3en' => [
            'name' => 'كشري السلطان',
            'fullAddress' => ' شارع الترول سيجال متفرع من شارع الأربعين - خلف حديقة بدر',
            'shortAddress' => 'فرع ش الأربعين - سيجال',
            'slug' => 'Sul_alarb3en',
            'image' => 'images/Sultan_Alarb3en/Sul1.jpg',
            'menuImages' => [
                'images/Sultan_Alarb3en/Sul_menu.jpg',
            ],
            'deliveryNumbers' => ['01125169998', '01125193332','01101143687','01022001264','0221859512','01272927710'],
        ],
        'Especo' => [
            'name' => 'كشري السلطان',
            'fullAddress' => 'اسبيكو ',
            'shortAddress' => 'فرع اسبيكو',
            'slug' => 'Especo',
            'image' => 'images/Especo/Sul1.jpg',
            'menuImages' => [
                'images/Especo/Sul_menu.jpg',
            ],
            'deliveryNumbers' => ['01117501313', '01278535226','01026277130','22787666'],
        ],
        'Alorsha' => [
            'name' => 'كشري السلطان',
            'fullAddress' => 'المرج - فرع شارع الورشة ',
            'shortAddress' => 'فرع شارع الورشة المرج',
            'slug' => 'Alorsha',
            'image' => 'images/Alorsha/Sul1.jpg',
            'menuImages' => [
                'images/Alorsha/Sul_menu1.jpg',
                'images/Alorsha/Sul_menu2.jpg',
            ],
            'deliveryNumbers' => ['01030881563', '01501229290','01067060709','01112993924','01112111081'],
        ],
    ];

    public function index() {
        $shops = [];
        foreach ($this->shops as $shopData) {
            $shops[] = [
                'name' => $shopData['name'],
                'address' => $shopData['shortAddress'],
                'slug' => $shopData['slug'],
                'image' => asset($shopData['image']),
            ];
        }

        return view('shops.index', compact('shops'));
    }

    public function show($slug) {
        if (!isset($this->shops[$slug])) {
            abort(404, 'المحل غير موجود');
        }

        $shop = $this->shops[$slug];
        $shop['image'] = asset($shop['image']);
        // convert all menu images to full asset URLs
        if (isset($shop['menuImages']) && is_array($shop['menuImages'])) {
            $menuImages = [];
            foreach ($shop['menuImages'] as $m) {
                $menuImages[] = asset($m);
            }
            $shop['menuImages'] = $menuImages;
        } else {
            // backward-compat: if single menuImage exists, wrap it
            if (isset($shop['menuImage'])) {
                $shop['menuImages'] = [asset($shop['menuImage'])];
            } else {
                $shop['menuImages'] = [];
            }
        }

        return view('shops.show', compact('shop'));
    }
}
