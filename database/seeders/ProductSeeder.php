<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\UmkmProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    protected array $productsByUmkm = [
        'Kopi Senja' => [
            ['name' => 'Kopi Susu Gula Aren', 'price' => 18000],
            ['name' => 'Americano Dingin', 'price' => 15000],
            ['name' => 'Kopi Tubruk Original', 'price' => 12000],
            ['name' => 'Roti Bakar Cokelat Keju', 'price' => 16000],
        ],
        'Batik Rahayu' => [
            ['name' => 'Kain Batik Tulis Motif Parang', 'price' => 250000],
            ['name' => 'Kemeja Batik Pria Lengan Panjang', 'price' => 175000],
            ['name' => 'Dress Batik Wanita', 'price' => 210000],
        ],
        'Kriya Anyaman Asri' => [
            ['name' => 'Tas Anyaman Rotan', 'price' => 95000],
            ['name' => 'Tempat Tisu Bambu', 'price' => 35000],
            ['name' => 'Keranjang Piknik Anyaman', 'price' => 120000],
        ],
        'Sabun Herbal Alami' => [
            ['name' => 'Sabun Batang Lidah Buaya', 'price' => 22000],
            ['name' => 'Sabun Cair Sereh Wangi', 'price' => 28000],
            ['name' => 'Lulur Tradisional Rempah', 'price' => 30000],
        ],
        'Warung Nasi Ibu Sri' => [
            ['name' => 'Nasi Ayam Geprek', 'price' => 15000],
            ['name' => 'Nasi Rendang', 'price' => 20000],
            ['name' => 'Sayur Lodeh + Tempe', 'price' => 10000],
            ['name' => 'Es Teh Manis', 'price' => 5000],
        ],
    ];

    public function run(): void
    {
        foreach ($this->productsByUmkm as $umkmName => $products) {
            $umkm = UmkmProfile::where('name', $umkmName)->first();

            if (! $umkm) {
                continue;
            }

            foreach ($products as $product) {
                Product::updateOrCreate(
                    ['umkm_id' => $umkm->id, 'slug' => Str::slug($product['name'])],
                    [
                        'category_id' => $umkm->category_id,
                        'name' => $product['name'],
                        'description' => 'Produk unggulan dari '.$umkmName.'. Dibuat dengan bahan berkualitas dan penuh perhatian pada detail.',
                        'price' => $product['price'],
                        'stock' => rand(10, 50),
                        'status' => 'active',
                        'sold_count' => rand(0, 40),
                        'image' => collect(scandir(storage_path('app/public/products')))->filter(fn($f) => str_ends_with($f, '.jpg'))->random(),
                    ]
                );
            }
        }
    }
}
