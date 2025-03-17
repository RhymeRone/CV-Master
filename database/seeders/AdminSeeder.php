<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'name' => 'Admin', 
            'email' => 'admin@example.com',
            'password' => Hash::make('password')
        ]);
        
        $this->command->info('Admin kullanıcısı oluşturuldu!');
    }
}