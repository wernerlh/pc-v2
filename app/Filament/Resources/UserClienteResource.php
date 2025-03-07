<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserClienteResource\Pages;
use App\Filament\Resources\UserClienteResource\RelationManagers;
use App\Models\UserCliente;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Support\Facades\Hash;
use Filament\Forms\Components\Textarea;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserClienteResource extends Resource
{
    protected static ?string $model = UserCliente::class;

    protected static ?string $navigationIcon = 'heroicon-c-user-circle'; // Icono para el menú de navegación
    protected static ?string $navigationLabel = 'Clientes'; // Etiqueta del menú
    protected static ?string $modelLabel = 'Cliente'; // Etiqueta singular
    protected static ?string $pluralModelLabel = 'Clientes'; // Etiqueta plural
    protected static ?string $navigationGroup = 'Gestión de Clientes'; // Grupo de navegación

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Usuario')
                    ->unique()
                    ->regex('/^[a-z0-9]{8,16}$/')
                    ->required()
                    ->maxLength(16),
                TextInput::make('nombre_completo')
                    ->label('Nombre Y Apellido')
                    ->required()
                    ->maxLength(200),
                TextInput::make('documento_identidad')
                    ->label('DNI')
                    ->unique()
                    ->maxLength(20),
                TextInput::make('email')
                    ->label('Correo Electrónico')
                    ->email()
                    ->unique()
                    ->maxLength(100),
                TextInput::make('telefono')
                    ->label('Teléfono')
                    ->nullable()
                    ->maxLength(15),
                TextInput::make('direccion')
                    ->label('Dirección')
                    ->nullable()
                    ->maxLength(200),
                DatePicker::make('fecha_nacimiento')
                    ->label('Fecha de Nacimiento')
                    ->required(),
                Textarea::make('preferencias')
                    ->label('Preferencias')
                    ->nullable(),
                Select::make('estado_membresia')
                    ->options([
                        'desactivado' => 'Desactivado',
                        'vip' => 'VIP',
                        'super_vip' => 'Super VIP',
                    ])
                    ->default('desactivado')
                    ->required(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required()
                    ->dehydrateStateUsing(fn($state) => Hash::make($state)), // Encripta la contraseña

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('row_number')
                ->label('N°')
                ->rowIndex()
                ->sortable(),
                Tables\Columns\TextColumn::make('name')
                ->label('Nombre de Usuario')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('nombre_completo')
                ->label('Nombre Y Apellido')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('email')
                ->label('Correo Electrónico')
                ->sortable()
                ->searchable(),
                Tables\Columns\TextColumn::make('telefono')
                ->label('Teléfono')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('direccion')
                ->label('Dirección')
                ->searchable()
                ->sortable(),
                Tables\Columns\TextColumn::make('fecha_nacimiento')
                    ->date()
                    ->label('Fecha de Nacimiento')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado_membresia'),
                Tables\Columns\TextColumn::make('documento_identidad'),
                Tables\Columns\TextColumn::make('limite_apuesta_diario'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Fecha de Creación')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->label('Fecha de Actualización')
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListUserClientes::route('/'),
            'create' => Pages\CreateUserCliente::route('/create'),
            'edit' => Pages\EditUserCliente::route('/{record}/edit'),
        ];
    }
}
