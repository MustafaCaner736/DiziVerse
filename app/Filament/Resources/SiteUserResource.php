<?php
namespace App\Filament\Resources;

use App\Filament\Resources\SiteUserResource\Pages;
use App\Models\SiteUser;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SiteUserResource extends Resource
{
    protected static ?string $model = SiteUser::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // form()
                Forms\Components\TextInput::make('name')->required(),
                Forms\Components\TextInput::make('email')->email()->required(),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->dehydrated(fn($state) => filled($state))
                    ->dehydrateStateUsing(fn($state) => bcrypt($state))
                    ->required(),
                Forms\Components\FileUpload::make('profile_photo')
                    ->image()
                    ->directory('site-user-photos'),
// table()
               
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                 Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                 Tables\Columns\TextColumn::make('email')->sortable()->searchable(),
                 Tables\Columns\IconColumn::make('profile_photo')
                    ->boolean() // ya da ->toggleable() değil, sadece var/yok göstermek için
                    ->label('Has Photo'),

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
            'index'  => Pages\ListSiteUsers::route('/'),
            'create' => Pages\CreateSiteUser::route('/create'),
            'edit'   => Pages\EditSiteUser::route('/{record}/edit'),
        ];
    }
}
