<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CVAssignment;
use App\Models\CVInformation;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CVComponentController extends Controller
{
    /**
     * Bileşen tipine göre model sınıfını döndürür
     */
    private function getModelClass($type)
    {
        $type = strtolower($type);

        $modelMap = [
            'skill' => Skill::class,
            'experiences' => Experience::class,
            'portfolio' => Portfolio::class,
            'services' => Service::class,
            'testimonial' => Testimonial::class,
        ];

        return $modelMap[$type] ?? null;
    }

    /**
     * CV'ye ait tüm bileşenleri getir
     */
    public function getAllComponents(CVInformation $cv)
    {
        $components = $cv->getComponents();
        return response()->json($components);
    }

    /**
     * CV'ye ait belirli tipteki bileşenleri getir
     */
    public function getComponents(Request $request, CVInformation $cv, $type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        $components = $cv->getComponent($modelClass);
        return response()->json($components);
    }

    /**
     * Bileşeni CV'ye ekle
     */
    public function addComponent(Request $request, CVInformation $cv, $type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        // Tablo adını belirle - Laravel'in çoğullama kurallarına uygun olacak şekilde
        $tableName = with(new $modelClass)->getTable();

        $request->validate([
            'component_id' => 'required|exists:' . $tableName . ',id',
            'order' => 'nullable|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            $component = $modelClass::findOrFail($request->component_id);

            // Bileşeni CV'ye ekle
            $cv->setComponent($modelClass, $component);

            // Eğer sıralama belirtilmişse güncelle
            if ($request->has('order')) {
                $assignment = $cv->assignments()
                    ->where('assignable_type', $modelClass)
                    ->where('assignable_id', $component->id)
                    ->first();

                if ($assignment) {
                    $assignment->update(['order' => $request->order]);
                }
            }

            DB::commit();
            return response()->json(['message' => 'Bileşen başarıyla eklendi'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Bileşen eklenirken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * CV'den belirli bir bileşeni sil
     */
    public function removeComponent(Request $request, CVInformation $cv, $type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        // Tablo adını belirle
        $tableName = with(new $modelClass)->getTable();

        $request->validate([
            'component_id' => 'required|exists:' . $tableName . ',id',
        ]);

        try {
            $cv->assignments()
                ->where('assignable_type', $modelClass)
                ->where('assignable_id', $request->component_id)
                ->delete();

            return response()->json(['message' => 'Bileşen başarıyla silindi']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Bileşen silinirken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * CV'den belirli tipteki tüm bileşenleri sil
     */
    public function removeAllComponents(CVInformation $cv, $type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        try {
            $cv->deleteComponent($modelClass);
            return response()->json(['message' => 'Tüm bileşenler başarıyla silindi']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Bileşenler silinirken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * CV'deki bileşenlerin sırasını değiştir
     */
    public function reorderComponents(Request $request, CVInformation $cv, $type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        // Tablo adını belirle
        $tableName = with(new $modelClass)->getTable();

        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|integer|exists:' . $tableName . ',id',
            'orders.*.order' => 'required|integer|min:0'
        ]);

        try {
            DB::beginTransaction();

            foreach ($request->orders as $item) {
                $cv->assignments()
                    ->where('assignable_type', $modelClass)
                    ->where('assignable_id', $item['id'])
                    ->update(['order' => $item['order']]);
            }

            DB::commit();
            return response()->json(['message' => 'Sıralama başarıyla güncellendi']);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Sıralama güncellenirken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Tek bir bileşenin sırasını güncelle
     */
    public function updateComponentOrder(Request $request, CVInformation $cv, $type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        // Tablo adını belirle
        $tableName = with(new $modelClass)->getTable();

        $request->validate([
            'component_id' => 'required|exists:' . $tableName . ',id',
            'order' => 'required|integer|min:0'
        ]);

        try {
            $cv->assignments()
                ->where('assignable_type', $modelClass)
                ->where('assignable_id', $request->component_id)
                ->update(['order' => $request->order]);

            return response()->json(['message' => 'Sıralama başarıyla güncellendi']);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Sıralama güncellenirken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }

    /**
     * Belirli tipteki bileşenlerin sayısını getir
     */
    public function getComponentCount(CVInformation $cv, $type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        $count = $cv->getComponentCount($modelClass);
        return response()->json(['count' => $count]);
    }

    /**
     * Belirli bir bileşenin detayını getir
     */
    public function getComponentDetail(CVInformation $cv, $type, $id)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        $component = $modelClass::find($id);

        if (!$component) {
            return response()->json(['error' => 'Bileşen bulunamadı'], 404);
        }

        // Bileşenin CV'ye atanıp atanmadığını kontrol et
        $isAssigned = $cv->assignments()
            ->where('assignable_type', $modelClass)
            ->where('assignable_id', $id)
            ->exists();

        $componentData = $component->toArray();
        $componentData['is_assigned'] = $isAssigned;

        if ($isAssigned) {
            $assignment = $cv->assignments()
                ->where('assignable_type', $modelClass)
                ->where('assignable_id', $id)
                ->first();

            $componentData['order'] = $assignment->order;
            $componentData['assignment_id'] = $assignment->id;
        }

        return response()->json($componentData);
    }
    /**
     * Bir bileşenin atandığı CV'leri getir
     */
    public function getComponentCVs(Request $request, $type, $id)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        try {
            // Bileşenin gerçekten var olduğunun kontrolü istiyorsak:
            if (!$modelClass::where('id', $id)->exists()) {
                return response()->json(['error' => 'Bileşen bulunamadı'], 404);
            }

            // Bileşenin atandığı CV'leri bul
            $cvs = CVInformation::whereHas('assignments', function ($query) use ($modelClass, $id) {
                $query->where('assignable_type', $modelClass)
                    ->where('assignable_id', $id);
            })->get();

            return response()->json($cvs);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Bileşenin CV\'leri alınırken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }
    public function getAllTypeComponentsCVs($type)
    {
        $modelClass = $this->getModelClass($type);

        if (!$modelClass) {
            return response()->json(['error' => 'Geçersiz bileşen tipi'], 400);
        }

        try {
            // Tüm bu tipteki bileşenleri al
            $components = $modelClass::all();

            $result = [];

            foreach ($components as $component) {
                // Her bileşen için atandığı CV'leri bul
                $cvs = CVInformation::whereHas('assignments', function ($query) use ($modelClass, $component) {
                    $query->where('assignable_type', $modelClass)
                        ->where('assignable_id', $component->id);
                })->get();

                // Bileşen ve CV bilgilerini topla
                $result[] = [
                    'id' => $component->id,
                    'name' => $component->name ?? $component->title ?? '',  // veya uygun özellik
                    'cv_count' => $cvs->count(),
                    'cvs' => $cvs
                ];
            }

            return response()->json($result);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Veriler alınırken bir hata oluştu: ' . $e->getMessage()], 500);
        }
    }
}