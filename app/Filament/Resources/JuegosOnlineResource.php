<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JuegosOnlineResource\Pages;
use App\Models\CategoriasJuego;
use App\Models\JuegosOnline;
use App\Models\Membresia;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class JuegosOnlineResource extends Resource
{
    protected static ?string $model = JuegosOnline::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'Juegos Online';
    protected static ?string $modelLabel = 'Juego Online';
    protected static ?string $pluralModelLabel = 'Juegos Online';
    protected static ?string $navigationGroup = 'Gestión de Juegos';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nombre')
                    ->label('Nombre del juego')
                    ->required()
                    ->maxLength(100),
                Select::make('categoria_id')
                    ->label('Categoría')
                    ->options(CategoriasJuego::all()->pluck('nombre', 'id'))
                    ->searchable()
                    ->required(),
                Textarea::make('descripcion')
                    ->label('Descripción')
                    ->maxLength(500)
                    ->columnSpanFull(),
                TextInput::make('pagina_juego')
                    ->label('Enlace al juego')
                    ->required()
                    ->columnSpanFull(),
                Select::make('membresia_requerida')
                    ->label('Membresía Requerida')
                    ->options(Membresia::all()->pluck('nombre', 'id'))
                    ->searchable(),
                Select::make('estado')
                    ->label('Estado')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'mantenimiento' => 'En Mantenimiento',
                        'proximamente' => 'Próximamente',
                    ])
                    ->default('activo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('categoriaJuego.nombre')
                    ->label('Categoría')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('descripcion')
                    ->label('Descripción')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('pagina_juego')
                    ->label('Enlace al juego')
                    ->wrap(),
                TextColumn::make('membresiaRequerida.nombre')
                    ->label('Membresía Requerida')
                    ->wrap()
                    ->searchable(),
                TextColumn::make('estado')
                    ->label('Estado')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'activo' => 'success',
                        'inactivo' => 'danger',
                        'mantenimiento' => 'warning',
                        'proximamente' => 'info',
                    })
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label('Creado')
                    ->dateTime('d/m/Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('estado')
                    ->options([
                        'activo' => 'Activo',
                        'inactivo' => 'Inactivo',
                        'mantenimiento' => 'En Mantenimiento',
                        'proximamente' => 'Próximamente',
                    ]),

                SelectFilter::make('categoria_id')
                    ->options(CategoriasJuego::all()->pluck('nombre', 'id')),
            ])
            ->actions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJuegosOnlines::route('/'),
            'create' => Pages\CreateJuegosOnline::route('/create'),
            'edit' => Pages\EditJuegosOnline::route('/{record}/edit'),
        ];
    }
}
