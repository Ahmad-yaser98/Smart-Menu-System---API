<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Table;
use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. حساب المدير
        User::firstOrCreate(
            ['email' => 'admin@test.com'],
            [
                'name' => 'المدير العام',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        // 2. حساب النادل (الكابتن)
        User::firstOrCreate(
            ['email' => 'waiter@test.com'],
            [
                'name' => 'نادل المطعم',
                'password' => Hash::make('123456'),
                'role' => 'waiter',
            ]
        );

        // 3. حساب المطبخ (الشيف)
        User::firstOrCreate(
            ['email' => 'kitchen@test.com'],
            [
                'name' => 'شيف المطبخ',
                'password' => Hash::make('123456'),
                'role' => 'kitchen',
            ]
        );

        // 4. حساب الكاشير
        User::firstOrCreate(
            ['email' => 'cashier@test.com'],
            [
                'name' => 'كاشير المطعم',
                'password' => Hash::make('123456'),
                'role' => 'cashier',
            ]
        );

        // 5. إنشاء طاولات
        if (Table::count() == 0) {
            Table::factory(10)->create();
        }

        // 6. Categories and Items (Real Data)
        $categoriesData = [
            [
                'name' => 'وجبات سريعة',
                'name_en' => 'Fast Food',
                'items' => [
                    ['name' => 'بروستد', 'name_en' => 'Broasted Chicken', 'price' => 12.50, 'image' => '/menu/وجبات سريعة/brosted.png'],
                    ['name' => 'شاورما', 'name_en' => 'Shawarma', 'price' => 6.00, 'image' => '/menu/وجبات سريعة/shawerma.png'],
                    ['name' => 'شاورما عربي', 'name_en' => 'Arabic Shawarma', 'price' => 8.50, 'image' => '/menu/وجبات سريعة/shawerma_arabi.png'],
                    ['name' => 'مكسيكانو', 'name_en' => 'Mexicano', 'price' => 7.00, 'image' => '/menu/وجبات سريعة/maxckano.png'],
                    ['name' => 'سكالوب', 'name_en' => 'Escalope', 'price' => 9.00, 'image' => '/menu/وجبات سريعة/skaloob.png'],
                    ['name' => 'برغر لحم', 'name_en' => 'Beef Burger', 'price' => 10.00, 'image' => '/menu/وجبات سريعة/burger.png'],
                    ['name' => 'كورونا', 'name_en' => 'Corona Meal', 'price' => 11.00, 'image' => '/menu/وجبات سريعة/corona.png'],
                ]
            ],
            [
                'name' => 'معجنات',
                'name_en' => 'Pastries',
                'items' => [
                    ['name' => 'بيتزا خضار', 'name_en' => 'Vegetable Pizza', 'price' => 14.00, 'image' => '/menu/معجنات/pizza_khodar.png'],
                    ['name' => 'بيتزا فصول أربعة', 'name_en' => 'Four Seasons Pizza', 'price' => 16.00, 'image' => '/menu/معجنات/pitza_4season.png'],
                    ['name' => 'بيتزا مرغريتا', 'name_en' => 'Margherita Pizza', 'price' => 13.00, 'image' => '/menu/معجنات/margherita-pizza.png'],
                    ['name' => 'بيتزا سجق', 'name_en' => 'Sausage Pizza', 'price' => 15.50, 'image' => '/menu/معجنات/pitza_sejek.png'],
                    ['name' => 'كروسان', 'name_en' => 'Croissant', 'price' => 3.50, 'image' => '/menu/معجنات/kerwasan.png'],
                    ['name' => 'مناقيش', 'name_en' => 'Manakish', 'price' => 4.00, 'image' => '/menu/معجنات/manakich.png'],
                    ['name' => 'فطائر', 'name_en' => 'Fatayer', 'price' => 5.00, 'image' => '/menu/معجنات/fataer.png'],
                ]
            ],
            [
                'name' => 'شوربات',
                'name_en' => 'Soups',
                'items' => [
                    ['name' => 'شوربة عدس', 'name_en' => 'Lentil Soup', 'price' => 4.50, 'image' => '/menu/شوربات/shorba_ades.png'],
                    ['name' => 'شوربة فطر', 'name_en' => 'Mushroom Soup', 'price' => 6.00, 'image' => '/menu/شوربات/shorba_alfeter.png'],
                    ['name' => 'شوربة بصل', 'name_en' => 'Onion Soup', 'price' => 5.50, 'image' => '/menu/شوربات/shorba_albasal.png'],
                    ['name' => 'شوربة خضار', 'name_en' => 'Vegetable Soup', 'price' => 5.00, 'image' => '/menu/شوربات/shorba_khodar.png'],
                    ['name' => 'شوربة ماجي', 'name_en' => 'Maggi Soup', 'price' => 3.50, 'image' => '/menu/شوربات/shorba_maje.png'],
                    ['name' => 'شوربة قرع', 'name_en' => 'Pumpkin Soup', 'price' => 6.50, 'image' => '/menu/شوربات/shorba_alkaree.png'],
                    ['name' => 'شوربة كريمة الطماطم', 'name_en' => 'Cream of Tomato Soup', 'price' => 6.00, 'image' => '/menu/شوربات/shorba_altmatem.png'],
                ]
            ],
            [
                'name' => 'المقبلات',
                'name_en' => 'Appetizers',
                'items' => [
                    ['name' => 'حمص', 'name_en' => 'Hummus', 'price' => 4.00, 'image' => '/menu/المقبلات/Hummus.png'],
                    ['name' => 'يالنجي', 'name_en' => 'Yalanji', 'price' => 5.50, 'image' => '/menu/المقبلات/yalanje.png'],
                    ['name' => 'كبة نية', 'name_en' => 'Kibbeh Nayyeh', 'price' => 8.00, 'image' => '/menu/المقبلات/keppe_naya.png'],
                    ['name' => 'سمبوسك', 'name_en' => 'Sambousek', 'price' => 4.50, 'image' => '/menu/المقبلات/sambosek.png'],
                    ['name' => 'محمرة', 'name_en' => 'Muhammara', 'price' => 4.50, 'image' => '/menu/المقبلات/mohamara.png'],
                    ['name' => 'ايج', 'name_en' => 'Ijjeh', 'price' => 5.00, 'image' => '/menu/المقبلات/eegg.png'],
                    ['name' => 'متبل', 'name_en' => 'Mutabbal', 'price' => 4.50, 'image' => '/menu/المقبلات/metabal.png'],
                ]
            ],
            [
                'name' => 'المشروبات',
                'name_en' => 'Beverages',
                'items' => [
                    ['name' => 'عصير برتقال', 'name_en' => 'Orange Juice', 'price' => 4.00, 'image' => '/menu/المشروبات/bortocal.png'],
                    ['name' => 'عصير فريز', 'name_en' => 'Strawberry Juice', 'price' => 4.50, 'image' => '/menu/المشروبات/friez.png'],
                    ['name' => 'عصير مانجو', 'name_en' => 'Mango Juice', 'price' => 4.50, 'image' => '/menu/المشروبات/mango.png'],
                    ['name' => 'بيبسي', 'name_en' => 'Pepsi', 'price' => 2.00, 'image' => '/menu/المشروبات/pipse.png'],
                    ['name' => 'سفن اب', 'name_en' => '7 Up', 'price' => 2.00, 'image' => '/menu/المشروبات/7up.png'],
                    ['name' => 'كوكا كولا', 'name_en' => 'Coca Cola', 'price' => 2.00, 'image' => '/menu/المشروبات/coca cola.png'],
                    ['name' => 'بولو', 'name_en' => 'Polo (Mint Lemonade)', 'price' => 3.50, 'image' => '/menu/المشروبات/polo.png'],
                ]
            ],
            [
                'name' => 'المشاوي',
                'name_en' => 'Grills',
                'items' => [
                    ['name' => 'كبة مشوية', 'name_en' => 'Grilled Kibbeh', 'price' => 12.00, 'image' => '/menu/المشاوي/keppa.png'],
                    ['name' => 'كبة بسياخ', 'name_en' => 'Kibbeh Skewers', 'price' => 14.00, 'image' => '/menu/المشاوي/seakh_keppa.png'],
                    ['name' => 'كباب غنم مشوي', 'name_en' => 'Grilled Lamb Kebab', 'price' => 18.00, 'image' => '/menu/المشاوي/kapap_ ganam.png'],
                    ['name' => 'فروج مشوي', 'name_en' => 'Grilled Chicken', 'price' => 15.00, 'image' => '/menu/المشاوي/farooj_machwe.png'],
                    ['name' => 'شيش طاووق', 'name_en' => 'Shish Tawook', 'price' => 14.00, 'image' => '/menu/المشاوي/shesh_tawook.png'],
                    ['name' => 'سمك مشوي', 'name_en' => 'Grilled Fish', 'price' => 22.00, 'image' => '/menu/المشاوي/samak_mashwe.png'],
                    ['name' => 'أجنحة مشوية', 'name_en' => 'Grilled Wings', 'price' => 10.00, 'image' => '/menu/المشاوي/Ajneha_mashwe.png'],
                ]
            ],
            [
                'name' => 'السلطات',
                'name_en' => 'Salads',
                'items' => [
                    ['name' => 'تبولة', 'name_en' => 'Tabbouleh', 'price' => 5.50, 'image' => '/menu/السطات/tabole.png'],
                    ['name' => 'سلطة سيزر', 'name_en' => 'Caesar Salad', 'price' => 8.00, 'image' => '/menu/السطات/sezer.png'],
                    ['name' => 'سلطة معكرونة', 'name_en' => 'Macaroni Salad', 'price' => 7.00, 'image' => '/menu/السطات/pasta-salad.png'],
                    ['name' => 'سلطة عادية', 'name_en' => 'Regular Salad', 'price' => 4.50, 'image' => '/menu/السطات/sald_normal.png'],
                    ['name' => 'فتوش', 'name_en' => 'Fattoush', 'price' => 5.50, 'image' => '/menu/السطات/fattoushsalad.png'],
                    ['name' => 'سلطة سبانخ', 'name_en' => 'Spinach Salad', 'price' => 6.50, 'image' => '/menu/السطات/spanekh_salad.png'],
                    ['name' => 'سلطة فواكة', 'name_en' => 'Fruit Salad', 'price' => 7.50, 'image' => '/menu/السطات/fwakeh_salad.png'],
                ]
            ],
            [
                'name' => 'الحلويات',
                'name_en' => 'Desserts',
                'items' => [
                    ['name' => 'تشيز كيك', 'name_en' => 'Cheesecake', 'price' => 6.50, 'image' => '/menu/الحلويات/cheesecake.png'],
                    ['name' => 'كريب', 'name_en' => 'Crepe', 'price' => 5.50, 'image' => '/menu/الحلويات/creep.png'],
                    ['name' => 'ايس كريم', 'name_en' => 'Ice Cream', 'price' => 4.00, 'image' => '/menu/الحلويات/Ice_Cream.png'],
                    ['name' => 'نابلسية', 'name_en' => 'Nabulsiyeh', 'price' => 7.00, 'image' => '/menu/الحلويات/nablsia.png'],
                    ['name' => 'تراميسو', 'name_en' => 'Tiramisu', 'price' => 6.50, 'image' => '/menu/الحلويات/Tiramisu.png'],
                    ['name' => 'كاتو غلاس', 'name_en' => 'Gateau Glace', 'price' => 6.00, 'image' => '/menu/الحلويات/glass.png'],
                    ['name' => 'هريسة', 'name_en' => 'Harissa', 'price' => 4.50, 'image' => '/menu/الحلويات/haressa.png'],
                ]
            ]
        ];

        foreach ($categoriesData as $catData) {
            $cat = Category::create([
                'name' => $catData['name'],
                'name_en' => $catData['name_en']
            ]);

            foreach ($catData['items'] as $itemData) {
                MenuItem::create([
                    'category_id' => $cat->id,
                    'name' => $itemData['name'],
                    'name_en' => $itemData['name_en'],
                    'price' => $itemData['price'],
                    'image' => $itemData['image'],
                    'is_available' => true,
                ]);
            }
        }
    }
}