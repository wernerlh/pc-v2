<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SucursalesResource\Pages;
use App\Filament\Resources\SucursalesResource\RelationManagers;
use App\Models\Sucursales;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SucursalesResource extends Resource
{
    protected static ?string $model = Sucursales::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2'; // Icono para el menú de navegación
    protected static ?string $navigationLabel = 'Sucursales'; // Etiqueta del menú
    protected static ?string $modelLabel = 'Sucursales'; // Etiqueta singular
    protected static ?string $pluralModelLabel = 'Sucursales'; // Etiqueta plural
    protected static ?string $navigationGroup = 'Gestión de Empresa'; // Grupo de navegación

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('nombre')
                ->required()
                ->maxLength(100),
            Forms\Components\TextInput::make('direccion')
                ->maxLength(255),
            Forms\Components\TextInput::make('telefono')
                ->nullable()
                ->maxLength(15),
            Forms\Components\TextInput::make('ciudad')
                ->maxLength(100),
            Forms\Components\TextInput::make('provincia')
                ->maxLength(100),
            Forms\Components\TextInput::make('codigo_postal')
                ->maxLength(20),
            Forms\Components\TextInput::make('pais')
                ->maxLength(100),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nombre'),
                Tables\Columns\TextColumn::make('direccion'),
                Tables\Columns\TextColumn::make('telefono'),
                Tables\Columns\TextColumn::make('ciudad'),
                Tables\Columns\TextColumn::make('provincia'),
                Tables\Columns\TextColumn::make('codigo_postal'),
                Tables\Columns\TextColumn::make('pais'),
            ])
            ->filters([
                //
            ])
            ->actions([
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
            'index' => Pages\ListSucursales::route('/'),
            'create' => Pages\CreateSucursales::route('/create'),
            'edit' => Pages\EditSucursales::route('/{record}/edit'),
        ];
    }
}
