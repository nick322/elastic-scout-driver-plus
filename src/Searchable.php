<?php declare(strict_types=1);

namespace ElasticScoutDriverPlus;

use Closure;
use ElasticScoutDriverPlus\Builders\QueryBuilderInterface;
use ElasticScoutDriverPlus\Builders\SearchRequestBuilder;
use Laravel\Scout\Searchable as BaseSearchable;

trait Searchable
{
    use BaseSearchable;

    /**
     * @param Closure|QueryBuilderInterface|array $query
     */
    public static function searchQuery($query): SearchRequestBuilder
    {
        return new SearchRequestBuilder($query, new static());
    }

    /**
     * @return string|int|null
     */
    public function shardRouting()
    {
        return null;
    }

    /**
     * @return array|string|null
     */
    public function searchableWith()
    {
        return null;
    }

    public static function createPointInTime(string $keepAlive = null): string
    {
        $model = new static();
        $engine = $model->searchableUsing();
        $indexName = $model->searchableAs();

        return $engine->createPointInTime($indexName, $keepAlive);
    }

    public static function deletePointInTime(string $pointInTimeId): void
    {
        $model = new static();
        $engine = $model->searchableUsing();

        $engine->deletePointInTime($pointInTimeId);
    }
}
