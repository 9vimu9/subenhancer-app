<?php

declare(strict_types=1);

namespace App\Providers;

use App\Apis\DefinitionsAPI\DefinitionsApiInterface;
use App\Apis\DefinitionsAPI\FreeDictionaryApi;
use App\Apis\SentencesApi\FirstPartySentencingApi;
use App\Apis\SentencesApi\SentencesApiInterface;
use App\Apis\SrtParser\BenlippStrParser;
use App\Apis\SrtParser\SrtParserInterface;
use App\Apis\WordsFilterApi\FirstPartyWordFilterApi;
use App\Apis\WordsFilterApi\WordFilterApiInterface;
use App\Apis\YoutubeCaptionsGrabberApi\FirstPartyYoutubeCaptionsGrabberApi;
use App\Apis\YoutubeCaptionsGrabberApi\YoutubeCaptionsGrabberApiInterface;
use App\Events\DurationSaved;
use App\Events\SentenceSaved;
use App\Listeners\SaveFilteredWords;
use App\Listeners\SaveSentences;
use App\Services\CaptionService;
use App\Services\CaptionServiceInterface;
use App\Services\DefinitionsService;
use App\Services\DefinitionsServiceInterface;
use App\Services\EnhancementService;
use App\Services\EnhancementServiceInterface;
use App\Services\FilteredWordService;
use App\Services\FilteredWordServiceInterface;
use App\Services\SentenceService;
use App\Services\SentenceServiceInterface;
use App\Services\WordService;
use App\Services\WordServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CaptionServiceInterface::class, CaptionService::class);
        $this->app->bind(DefinitionsServiceInterface::class, DefinitionsService::class);
        $this->app->bind(EnhancementServiceInterface::class, EnhancementService::class);
        $this->app->bind(FilteredWordServiceInterface::class, FilteredWordService::class);
        $this->app->bind(SentenceServiceInterface::class, SentenceService::class);
        $this->app->bind(WordServiceInterface::class, WordService::class);
        $this->app->bind(DefinitionsApiInterface::class, FreeDictionaryApi::class);
        $this->app->bind(SentencesApiInterface::class, FirstPartySentencingApi::class);
        $this->app->bind(SrtParserInterface::class, BenlippStrParser::class);
        $this->app->bind(WordFilterApiInterface::class, FirstPartyWordFilterApi::class);
        $this->app->bind(YoutubeCaptionsGrabberApiInterface::class, FirstPartyYoutubeCaptionsGrabberApi::class);

    }

    public function boot(): void
    {
        Event::listen(DurationSaved::class, SaveSentences::class);
        Event::listen(SentenceSaved::class, SaveFilteredWords::class);
        Model::shouldBeStrict();
    }
}
