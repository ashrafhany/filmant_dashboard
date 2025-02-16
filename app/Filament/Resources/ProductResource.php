<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\NumberInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationLabel = 'المنتجات';
    protected static ?string $navigationGroup = 'إدارة المنتجات';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('اسم المنتج')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->label('وصف المنتج')
                    ->required(),

                TextInput::make('weight')
                    ->label('الوزن (كجم)')
                    ->required(),
                 //   ->min(0),
                TextInput::make('price')
                    ->label('السعر')
                    ->required(),
                  //  ->min(0),

                FileUpload::make('image')
                    ->label('صورة المنتج')
                    ->image()
                    ->required(),

                Select::make('category_id')
                    ->label('التصنيف')
                    ->relationship('category', 'name')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            ImageColumn::make('image')
                ->label('الصورة')
                ->circular(),

            TextColumn::make('name')
                ->label('اسم المنتج')
                ->searchable()
                ->sortable(),
            TextColumn::make('weight')
                ->label('الوزن (كجم)')
                ->sortable(),

            TextColumn::make('price')
                ->label('السعر')
                ->sortable(),

            TextColumn::make('category.name')
                ->label('التصنيف')
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('تعديل المنتج'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()->label('حذف المنتج'),
            ]);
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
    public static function getPluralModelLabel(): string
{
    return 'المنتجات';
}
}
