<?php

namespace App\Filament\Resources;

use App\Enums\PostPublishingStatus;
use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use App\Models\PostSeries;
use App\Models\Tag;
use Filament\Facades\Filament;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))),
                MarkdownEditor::make('content')
                    ->required()
                    ->fileAttachmentsDisk(env('APP_STORAGE_DRIVER', 'local')),
                FileUpload::make('promo_image')
                    ->label('Image')
                    ->disk(env('APP_STORAGE_DRIVER', 'local'))
                    ->nullable()
                    ->image(),
                Select::make('post_series_id')
                    ->label('Series')
                    ->nullable()
                    ->options(PostSeries::query()->where('blog_id', Filament::getTenant()->id)->pluck('title', 'id'))
                    ->createOptionForm([
                        TextInput::make('title')->required(),
                        Textarea::make('description')->nullable(),
                    ])
                    ->createOptionUsing(function (Post $post, array $data) {
                        return $post->postSeries()->create([...$data])->getKey();
                    }),
                Select::make('tags')
                    ->label('Tags')
                    ->multiple()
                    ->relationship(name: 'tags', titleAttribute: 'title')
                    ->options(Tag::query()->where('blog_id', Filament::getTenant()->id)->pluck('slug', 'id'))
                    ->createOptionForm([
                        TextInput::make('title')->required(),
                    ])
                    ->createOptionUsing(function (Post $post, array $data) {
                        return $post->tags()->create([...$data])->getKey();
                    })
                    ->hiddenOn(['create']),
                Repeater::make('links')
                    ->label('Links')
                    ->relationship()
                    ->schema([
                        TextInput::make('title')
                            ->required(),
                        Textarea::make('description')
                            ->nullable(),
                        TextInput::make('link')
                            ->required()
                            ->url(),
                        TextInput::make('archive_link')
                            ->nullable(),
                    ])
                    ->addActionLabel('Add Link')
                    ->itemLabel(fn (array $state): ?string => $state['title'] ? ($state['link'] ? $state['title'].' - '.$state['link'] : $state['title']) : null)
                    ->collapsible()
                    ->collapsed()
                    ->defaultItems(0)
                    ->orderColumn('sort')
                    ->reorderable(true)
                    ->reorderableWithButtons()
                    ->columns(1),
                Section::make('Meta')
                    ->description('Meta information for this post.')
                    ->schema([
                        Select::make('author_id')
                            ->required()
                            ->relationship(name: 'author', titleAttribute: 'name')
                            ->options(
                                Filament::getTenant()->users()->pluck('name', 'id'),
                            )
                            ->default(auth()->user()->id),
                        TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        DateTimePicker::make('publish_date')
                            ->label('Publish Date')
                            ->required()
                            ->default(now())
                            ->time(false),
                    ]),
                Section::make('Publishing')
                    ->description('Settings for publishing this post.')
                    ->schema([
                        Toggle::make('is_draft')
                            ->label('Is Draft?')
                            ->default(true),
                        DateTimePicker::make('starttime')
                            ->label('Publish after')
                            ->seconds(false),
                    ]),
            ])
            ->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('publish_date')
                    ->label('Publish Date')
                    ->sortable()
                    ->dateTime(),
                TextColumn::make('post_series_id')
                    ->label('Post Series')
                    ->formatStateUsing(fn (int $state) => PostSeries::query()->find($state)?->title),
                IconColumn::make('is_draft')
                    ->label('Published')
                    ->icon(fn (Post $post) => match ($post->publishingStatus()) {
                        PostPublishingStatus::draft => 'heroicon-o-pencil',
                        PostPublishingStatus::timed => 'heroicon-o-clock',
                        PostPublishingStatus::published => 'heroicon-o-check',
                    })
                    ->color(fn (Post $post) => match ($post->publishingStatus()) {
                        PostPublishingStatus::draft, PostPublishingStatus::timed => 'warning',
                        PostPublishingStatus::published => 'success',
                    }),
            ])
            ->filters([
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('publish_date', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}
