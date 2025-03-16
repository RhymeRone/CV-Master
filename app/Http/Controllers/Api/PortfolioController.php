<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use App\Models\PortfolioImage;
use App\Http\Resources\PortfolioResource;
use App\Http\Requests\Portfolio\StoreRequest;
use App\Http\Requests\Portfolio\UpdateRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class PortfolioController extends Controller
{

    public function index()
    {
        $portfolios = Portfolio::all();
        return response()->json([
            'data' => PortfolioResource::collection($portfolios)
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        // Kategori bilgisini veri dizisinden çıkart
        $categories = $data['categories'] ?? [];
        unset($data['categories']);

        $portfolio = Portfolio::create($data);

        // Kategorileri iliştir
        if (!empty($categories)) {
            $portfolio->categories()->attach($categories);
        }

        // Görselleri işle
        if ($request->hasFile('images')) {
            $this->savePortfolioImages($portfolio, $request->file('images'));
        }

        return response()->json([
            'message' => 'Portfolyo başarıyla oluşturuldu',
            'data' => new PortfolioResource($portfolio)
        ], 201);
    }

    public function show(Portfolio $portfolio)
    {
        return response()->json([
            'data' => new PortfolioResource($portfolio)
        ]);
    }

    public function update(UpdateRequest $request, Portfolio $portfolio)
    {
        $data = $request->validated();
    
        // Kategori bilgisini veri dizisinden çıkart
        $categories = $data['categories'] ?? [];
        unset($data['categories']);
    
        $portfolio->update($data);
    
        // Kategorileri senkronize et
        if (isset($request->validated()['categories'])) {
            $portfolio->categories()->sync($categories);
        }
    
        // Eğer yeni görseller yüklendiyse, eski görselleri sil ve yenilerini ekle
        if ($request->hasFile('images')) {
            // Eski görselleri sil
            foreach ($portfolio->images as $image) {
                if (Storage::disk('public')->exists($image->image_path)) {
                    Storage::disk('public')->delete($image->image_path);
                }
            }
            $portfolio->images()->delete();
            
            // Yeni görselleri ekle
            $this->savePortfolioImages($portfolio, $request->file('images'));
        }
    
        return response()->json([
            'message' => 'Portfolyo başarıyla güncellendi',
            'data' => new PortfolioResource($portfolio)
        ]);
    }

    public function destroy(Portfolio $portfolio)
    {
        $portfolio->delete();
        return response()->json([
            'message' => 'Portfolyo başarıyla silindi'
        ]);
    }
    // Ana görseli değiştirme
    public function setMainImage(Request $request, Portfolio $portfolio)
    {
        $request->validate([
            'image_id' => 'required|exists:portfolio_images,id'
        ]);

        // Önce tüm görsellerin ana görsel durumunu kaldır
        $portfolio->images()->update(['is_main' => false]);

        // Sonra seçilen görseli ana görsel olarak ayarla
        PortfolioImage::where('id', $request->image_id)
            ->where('portfolio_id', $portfolio->id)
            ->update(['is_main' => true]);

        return response()->json(['success' => true]);
    }

    // Görsel silme
    public function deleteImage($imageId)
    {
        $image = PortfolioImage::findOrFail($imageId);

        // Dosyayı sil
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Kayıt sil
        $image->delete();

        // Eğer silinen ana görselse, başka bir görseli ana görsel yap
        if ($image->is_main) {
            $newMainImage = PortfolioImage::where('portfolio_id', $image->portfolio_id)
                ->first();
            if ($newMainImage) {
                $newMainImage->update(['is_main' => true]);
            }
        }

        return response()->json(['success' => true]);
    }

    /**
 * Portfolyo görsellerini listele
 */
public function getImages(Portfolio $portfolio)
{
    $images = $portfolio->images()->orderBy('sort_order', 'asc')->get();
    
    return response()->json([
        'data' => $images->map(function ($image) {
            return [
                'id' => $image->id,
                'image_path' => asset('storage/'.$image->image_path),
                'is_main' => $image->is_main,
                'sort_order' => $image->sort_order,
                'created_at' => $image->created_at
            ];
        })
    ]);
}

/**
 * Tek veya çoklu görsel ekleme
 */
public function addImages(Request $request, Portfolio $portfolio)
{
    $request->validate([
        'images' => 'required|array',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);
    
    // Son sıralama değerini bul
    $lastOrder = $portfolio->images()->max('sort_order') ?? -1;
    
    // Görselleri arka plan sırasına ekle
    $addedImages = $this->savePortfolioImages($portfolio, $request->file('images'), $lastOrder + 1);
    
    return response()->json([
        'message' => (is_array($addedImages) ? count($addedImages) : 0) . ' görsel başarıyla eklendi',
        'data' => $addedImages ?? []
    ]);
}

/**
 * Görsellerin sıralama düzenini güncelle
 */
public function updateImageOrder(Request $request, Portfolio $portfolio)
{
    $request->validate([
        'images' => 'required|array',
        'images.*.id' => 'required|exists:portfolio_images,id',
        'images.*.sort_order' => 'required|integer|min:0'
    ]);
    
     // Portfolyo kontrolü ekle
     foreach ($request->images as $image) {
        PortfolioImage::where('id', $image['id'])
            ->where('portfolio_id', $portfolio->id)
            ->update(['sort_order' => $image['sort_order']]);
    }
    
    return response()->json([
        'message' => 'Görsel sıralaması başarıyla güncellendi'
    ]);
}

/**
 * Geliştirilmiş görsel kaydetme fonksiyonu (sort_order parametresi eklendi)
 */
private function savePortfolioImages(Portfolio $portfolio, $images, $startOrder = 0)
{
    $isMainSet = $portfolio->images()->where('is_main', true)->exists();
    $sortOrder = $startOrder;
    $addedImages = [];
    
    foreach ($images as $image) {
        // Görsel kaydetme
        $path = $image->store('portfolio_images', 'public');
        
        // Eğer ana görsel yoksa ilk görsel ana görsel olsun
        $isMain = !$isMainSet;
        if ($isMain) {
            $isMainSet = true;
        }
        
        // Görsel kaydı oluştur
        $portfolioImage = $portfolio->images()->create([
            'image_path' => $path,
            'is_main' => $isMain,
            'sort_order' => $sortOrder++,
        ]);
        
        $addedImages[] = [
            'id' => $portfolioImage->id,
            'image_path' => asset('storage/'.$path),
            'is_main' => $portfolioImage->is_main,
            'sort_order' => $portfolioImage->sort_order
        ];
    }
    
    return $addedImages;
}
}