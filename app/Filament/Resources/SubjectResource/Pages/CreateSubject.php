<?php

namespace App\Filament\Resources\SubjectResource\Pages;

use App\Filament\Resources\SubjectResource;
use App\Models\Subject;
use Filament\Resources\Pages\CreateRecord;

class CreateSubject extends CreateRecord
{
    protected static string $resource = SubjectResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Generate unique 6-letter code if not provided
        if (empty($data['code'])) {
            do {
                $code = strtoupper(substr(md5(rand()), 0, 6));
            } while (Subject::where('code', $code)->exists());
            $data['code'] = $code;
        }
        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
