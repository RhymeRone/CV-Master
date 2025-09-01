<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Contact;

class AdminProfileController extends Controller
{
    public function index()
    {
        $messages = Contact::orderBy('created_at', 'desc')->paginate(5);
        return view('admin.pages.profile', compact('messages'));
    }
    
    public function update(Request $request)
{
    // Admin kimliğini al
    $admin = auth()->guard('admin')->user();
    $adminId = $admin->id;
    
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:admins,email,' . $adminId,
        'phone' => 'nullable|string|max:20',
        'position' => 'nullable|string|max:255',
        'website' => 'nullable|url|max:255',
        'address' => 'nullable|string|max:1000',
        'bio' => 'nullable|string|max:5000',
    ]);
    
    // Query Builder ile direkt veritabanı güncellemesi
    DB::table('admins')
        ->where('id', $adminId)
        ->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'position' => $request->position,
            'website' => $request->website,
            'address' => $request->address,
            'bio' => $request->bio,
        ]);
    
    return redirect()->back()->with('success', 'Profil bilgileriniz başarıyla güncellendi.');
}

public function updateAvatar(Request $request)
{
    $admin = auth()->guard('admin')->user();
    $adminId = $admin->id;
    
    $request->validate([
        'avatar' => [
            'required',
            'image',
            'mimes:' . implode(',', config('admin.upload.image.mimes')),
            'min:' . config('admin.upload.image.min_size'),
            'max:' . config('admin.upload.image.max_size'),
        ]
    ]);
    
    // Eski avatarı sil
    if ($admin->avatar) {
        Storage::disk('public')->delete($admin->avatar);
    }
    
    // Yeni avatarı yükle
    $path = $request->file('avatar')->store('avatars', 'public');
    
    // Query Builder ile direkt güncelleme
    DB::table('admins')
        ->where('id', $adminId)
        ->update(['avatar' => $path]);
    
    return redirect()->back()->with('success', 'Profil resminiz başarıyla güncellendi.');
}

public function updatePassword(Request $request)
{
    $admin = auth()->guard('admin')->user();
    $adminId = $admin->id;
    
    $request->validate([
        'current_password' => 'required',
        'new_password' => [
            'required',
            'confirmed',
            Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
        ],
    ]);
    
    // Mevcut şifreyi kontrol et
    if (!Hash::check($request->current_password, $admin->password)) {
        return redirect()->back()->withErrors(['current_password' => 'Mevcut şifreniz doğru değil.']);
    }
    
    // Query Builder ile direkt güncelleme
    DB::table('admins')
        ->where('id', $adminId)
        ->update(['password' => Hash::make($request->new_password)]);
    
    return redirect()->back()->with('success', 'Şifreniz başarıyla değiştirildi.');
}


    
}