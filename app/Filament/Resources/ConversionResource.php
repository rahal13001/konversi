<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConversionResource\Pages;
use App\Filament\Resources\ConversionResource\RelationManagers;
use App\Models\Conversion;
use App\Models\Species;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ConversionResource extends Resource
{
    protected static ?string $model = Conversion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('product_id')
                    ->label('Produk')
                    ->relationship('product', 'product')
                    ->required(),
                Forms\Components\Select::make('species_id')
                    ->required()
                    ->label('Spesies')
                    ->searchable()
                    ->preload()
                    ->options(Species::all()->mapWithKeys(function($species){
                        $namaspecies = $species->species. " - " .$species->local_name;
                        return [$species->id => $namaspecies];
                    })->toArray())
                   ,
                Forms\Components\TextInput::make('conversion_factor')
                    ->required()
                    ->label('Faktor Konversi')
                    ->suffix('%')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('product.product')
                    ->numeric()
                    ->label('Produk')
                    ->sortable(),
                Tables\Columns\TextColumn::make('species.species')
                    ->label('Spesies')
                    ->sortable(),
                Tables\Columns\TextColumn::make('species.local_name')
                    ->label('Nama Lokal')
                    ->sortable(),
                Tables\Columns\TextColumn::make('conversion_factor')
                    ->numeric()
                    ->label('Faktor Konversi')
                    ->suffix('%')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListConversions::route('/'),
            'create' => Pages\CreateConversion::route('/create'),
            'view' => Pages\ViewConversion::route('/{record}'),
            'edit' => Pages\EditConversion::route('/{record}/edit'),
        ];
    }
}
