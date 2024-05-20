<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('companies')->truncate(); // 既存のデータをクリア
        DB::table('companies')->insert([
            ['company_name' => 'Coca-Cola', 'street_address' => '', 'representative_name' => 'John Doe'],
            ['company_name' => 'サントリー', 'street_address' => '', 'representative_name' => 'Jane Smith'],
            ['company_name' => 'Pepsi', 'street_address' => '', 'representative_name' => 'Michael Johnson'],
            ['company_name' => 'Nestle', 'street_address' => '', 'representative_name' => 'Emily Davis'],
            // 他のメーカー名もここに追加し、代表者名を適切に設定してください
        ]);
    }
}
