<?php
namespace Database\Seeders;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class DatabaseSeeder extends Seeder {
    public function run(): void {
        User::create(['name'=>'Admin','email'=>'admin@idc.local','password'=>Hash::make('password'),'is_admin'=>true,'balance'=>0]);
        User::create(['name'=>'测试用户','email'=>'test@idc.local','password'=>Hash::make('password'),'is_admin'=>false,'balance'=>1000]);
        Product::create(['name'=>'樱花云 · 香港CN2 · 1核1G','slug'=>'hk-1c1g','description'=>'高性能香港节点，二次元主题专属','price'=>15.00,'billing_cycle'=>'monthly','config'=>['cpu'=>'1核','memory'=>'1G','disk'=>'20G','bandwidth'=>'20M'],'is_active'=>true]);
        Product::create(['name'=>'樱花云 · 香港CN2 · 2核4G','slug'=>'hk-2c4g','description'=>'中型业务首选','price'=>50.00,'billing_cycle'=>'monthly','config'=>['cpu'=>'2核','memory'=>'4G','disk'=>'60G','bandwidth'=>'30M'],'is_active'=>true]);
        Product::create(['name'=>'樱花云 · 美国 · 1核2G','slug'=>'us-1c2g','description'=>'大带宽美国节点','price'=>25.00,'billing_cycle'=>'monthly','config'=>['cpu'=>'1核','memory'=>'2G','disk'=>'30G','bandwidth'=>'100M'],'is_active'=>true]);
    }
}
