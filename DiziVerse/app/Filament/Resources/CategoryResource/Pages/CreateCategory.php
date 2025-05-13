<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;

    /**
     * Formdan gelen ham veriyi, kaydetmeden önce buradan döneceğiz.
     */
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // 'name' alanından slug oluştur
        $data['slug'] = Str::slug($data['name']);

        return $data;
    }
}
