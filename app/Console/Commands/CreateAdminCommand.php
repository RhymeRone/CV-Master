<?php

namespace App\Console\Commands;

use App\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminCommand extends Command
{
    protected $signature = 'admin:create {--name=} {--email=} {--password=}';
    protected $description = 'Yönetici oluştur';

    public function handle()
    {
        $name = $this->option('name') ?: $this->ask('Admin adı?');
        $email = $this->option('email') ?: $this->ask('Admin email adresi?');
        $password = $this->option('password') ?: $this->secret('Admin şifresi?');
        
        // Doğrulama
        $validator = Validator::make([
            'name' => $name,
            'email' => $email, 
            'password' => $password
        ], [
            'name' => 'required|string|min:3',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8'
        ]);
        
        if ($validator->fails()) {
            $this->error($validator->errors()->first());
            return 1;
        }
        
        // Admin oluştur
        $admin = Admin::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password)
        ]);
        
        $this->info("Admin başarıyla oluşturuldu: {$admin->email}");
        return 0;
    }
}