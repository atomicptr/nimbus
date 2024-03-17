<?php

namespace App\Filament\Pages\Tenancy;

use App\Models\Blog;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Tenancy\RegisterTenant;

class AddNewBlog extends RegisterTenant
{
    public static function getLabel(): string
    {
        return 'Add new blog';
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title'),
                Textarea::make('description'),
            ]);
    }

    protected function handleRegistration(array $data): Blog
    {
        $blog = new Blog($data);
        $blog->save();

        $blog->users()->attach(auth()->user());

        return $blog;
    }
}
