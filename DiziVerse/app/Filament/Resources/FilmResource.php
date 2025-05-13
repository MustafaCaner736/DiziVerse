<?php
namespace App\Filament\Resources;

use App\Filament\Resources\FilmResource\Pages;
use App\Models\Film;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Stichoza\GoogleTranslate\GoogleTranslate;

class FilmResource extends Resource
{
    protected static ?string $model = Film::class;

    protected static ?string $navigationIcon  = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Filmler';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('imdb_id')
                    ->label('IMDb ID')
                    ->hint('Örn: tt0111161')
                    ->required()
                    ->maxLength(20)
                    ->reactive()
                    ->afterStateUpdated(function (string $state, Set $set) {
                        $apiKeyOmdb = config('services.omdb.key');

                        // OMDb’den veriyi çekiyoruz
                        $response = Http::get('http://www.omdbapi.com/', [
                            'i'      => $state,
                            'apikey' => $apiKeyOmdb,
                            'plot'   => 'full',
                        ])->json();

                        if (data_get($response, 'Response') !== 'True') {
                            return;
                        }

                        // Temel alanlar
                        $set('title', $response['Title'] ?? null);
                        $set('time', $response['Runtime'] ?? null);
                        // İlk olarak ingilizceyi set ediyoruz, sonra üzerine yazacağız
                        $set('description', $response['Plot'] ?? null);
                        $set('rating', $response['imdbRating'] ?? null);
                        $set('year', $response['Year'] ?? null);

                        // Yönetmen / yazar bilgisi
                        $director = data_get($response, 'Director') !== 'N/A'
                        ? $response['Director']
                        : ($response['Writer'] ?? null);
                        $set('director', $director);

                        $set('poster_url', $response['Poster'] ?? null);
                        $set('cast', json_encode(
                            array_slice(explode(', ', $response['Actors'] ?? ''), 0, 5)
                        ));

                        // ——————————————————————————————————————————
                        // Plot’u çeviriyoruz
                        $englishPlot = $response['Plot'] ?? '';

                        try {
                            $tr          = new GoogleTranslate('tr');
                            $turkishPlot = $tr->translate($englishPlot);
                        } catch (\Exception $e) {
                            // Hata olursa ingilizce bırak
                            $turkishPlot = $englishPlot;
                            \Log::warning('GoogleTranslate çeviri hatası: ' . $e->getMessage());
                        }

                        // Çeviriyi description’a set et
                        $set('description', $turkishPlot);
                    }),

                TextInput::make('title')->required(),
                Textarea::make('description')->required()->rows(3),

                TextInput::make('rating')->numeric()->required()->step(0.1),
                TextInput::make('year')->numeric()->required()->maxLength(4),
                TextInput::make('director')->required(),
                TextInput::make('time')->required(),
                TextInput::make('poster_url')->required()->url(),
                TextInput::make('trailer_url')->url(),
                TextInput::make('cast')->required()
                    ->label('Cast (JSON)')
                    ->hint('JSON formatında dizi olarak kaydedilir'),
                Toggle::make('featured')
                    ->label('Öne Çıkar')
                    ->inline(false),
                MultiSelect::make('categories')->required()
                    ->relationship('categories', 'name')
                    ->label('Kategoriler')
                    ->searchable()
                    ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable(),
                TextColumn::make('rating')->sortable(),
                TextColumn::make('year')->sortable(),
            ])
            ->filters([])
            ->actions([Tables\Actions\EditAction::make()])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
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
            'index'  => Pages\ListFilms::route('/'),
            'create' => Pages\CreateFilm::route('/create'),
            'edit'   => Pages\EditFilm::route('/{record}/edit'),
        ];
    }
}
