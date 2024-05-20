<?php

declare(strict_types=1);

namespace App\Providers;

use App\Apis\DefinitionsAPI\FreeDictionaryApi;
use App\Apis\DefinitionSelectorApi\FirstPartyDefinitionSelectorApi;
use App\Apis\SentencesApi\FirstPartySentencingApi;
use App\Apis\SrtParser\BenlippStrParser;
use App\Apis\WordsFilterApi\FirstPartyWordFilterApi;
use App\Apis\YoutubeCaptionsGrabberApi\FirstPartyYoutubeCaptionsGrabberApi;
use App\Core\Contracts\Apis\DefinitionsApiInterface;
use App\Core\Contracts\Apis\DefinitionSelectorApiInterface;
use App\Core\Contracts\Apis\SentencesApiInterface;
use App\Core\Contracts\Apis\SrtParserInterface;
use App\Core\Contracts\Apis\WordFilterApiInterface;
use App\Core\Contracts\Apis\YoutubeCaptionsGrabberApiInterface;
use App\Core\Contracts\Services\CaptionServiceInterface;
use App\Core\Contracts\Services\DefinitionSelectorServiceInterface;
use App\Core\Contracts\Services\DefinitionsServiceInterface;
use App\Core\Contracts\Services\EnhancementServiceInterface;
use App\Core\Contracts\Services\FilteredWordServiceInterface;
use App\Core\Contracts\Services\SentenceServiceInterface;
use App\Core\Contracts\Services\WordServiceInterface;
use App\Events\DurationSaved;
use App\Events\NewFilteredWordsStored;
use App\Events\SentenceSaved;
use App\Listeners\SaveFilteredWords;
use App\Listeners\SaveSentences;
use App\Listeners\UpdateDefiniton;
use App\Services\CaptionService;
use App\Services\DefinitionSelectorService;
use App\Services\DefinitionsService;
use App\Services\EnhancementService;
use App\Services\FilteredWordService;
use App\Services\SentenceService;
use App\Services\WordService;
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
        $this->app->bind(DefinitionSelectorServiceInterface::class, DefinitionSelectorService::class);

        $this->app->bind(DefinitionsApiInterface::class, FreeDictionaryApi::class);
        $this->app->bind(SentencesApiInterface::class, FirstPartySentencingApi::class);
        $this->app->bind(SrtParserInterface::class, BenlippStrParser::class);
        $this->app->bind(WordFilterApiInterface::class, FirstPartyWordFilterApi::class);
        $this->app->bind(YoutubeCaptionsGrabberApiInterface::class, FirstPartyYoutubeCaptionsGrabberApi::class);
        $this->app->bind(DefinitionSelectorApiInterface::class, FirstPartyDefinitionSelectorApi::class);

    }

    public function boot(): void
    {
        Event::listen(DurationSaved::class, SaveSentences::class);
        Event::listen(SentenceSaved::class, SaveFilteredWords::class);
        Event::listen(NewFilteredWordsStored::class, UpdateDefiniton::class);
        Model::shouldBeStrict();
    }
}
