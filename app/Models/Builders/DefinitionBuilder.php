<?php

declare(strict_types=1);

namespace App\Models\Builders;

use App\DataObjects\FilteredWords\FilteredWordCollection;
use App\Exceptions\NoCandidateDefinitionsAvailabletoChooseException;
use App\Models\Corpus;
use Illuminate\Database\Eloquent\Builder;

class DefinitionBuilder extends Builder
{
    public function getCandidateDefinitionsArrayByWordOrFail(int $corpusId): array
    {
        $definitions = $this->where('corpus_id', $corpusId)
            ->pluck('definition')
            ->toArray();

        return count($definitions) ? $definitions : throw new NoCandidateDefinitionsAvailabletoChooseException();
    }

    public function findByDefinitionAndCorpusId(string $definition, int $corpusId, array $columns = ['id']): \App\Models\Definition
    {
        return $this->where('definition', $definition)
            ->where('corpus_id', $corpusId)
            ->firstOrFail($columns);

    }

    public function storeByCollection(FilteredWordCollection $collection): void
    {
        $inputs = [];
        foreach ($collection as $filteredWord) {
            $word = Corpus::query()->findByWord($filteredWord->getWord());
            if (is_null($word) || $word->definitions()->count()) {
                continue;
            }

            foreach ($filteredWord->getDefinitions() as $definition) {
                $inputs[] = [
                    'corpus_id' => $word->id,
                    'definition' => $definition->getDefinition(),
                    'word_class' => $definition->getWordClass()->name,
                ];
            }
        }
        \App\Models\Definition::query()->insertOrIgnore($inputs);

    }
}
