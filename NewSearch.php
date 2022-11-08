<?php

declare(strict_types=1);

namespace Sigmie\Search;

use Sigmie\Base\Contracts\ElasticsearchConnection;
use Sigmie\Query\Contracts\Queries;
use Sigmie\Query\Contracts\QueryClause as Query;
use Sigmie\Query\Queries\Compound\Boolean;
use Sigmie\Query\Queries\MatchAll;
use Sigmie\Query\Queries\MatchNone;
use Sigmie\Query\Queries\Term\Exists;
use Sigmie\Query\Queries\Term\Fuzzy;
use Sigmie\Query\Queries\Term\IDs;
use Sigmie\Query\Queries\Term\Range;
use Sigmie\Query\Queries\Term\Regex;
use Sigmie\Query\Queries\Term\Term;
use Sigmie\Query\Queries\Term\Terms;
use Sigmie\Query\Queries\Term\Wildcard;
use Sigmie\Query\Queries\Text\Match_;
use Sigmie\Query\Queries\Text\MultiMatch;

class NewSearch implements Queries
{
    protected Search $search;

    public function __construct(
        protected string $index,
         protected ElasticsearchConnection $httpConnection)
    {
        $this->search = new Search();

        $this->search->index($index)->setElasticsearchConnection($httpConnection);
    }

    public function term(string $field, string|bool $value): Search
    {
        return $this->search->query(new Term($field, $value));
    }

    public function bool(callable $callable, float $boost = 1): Search
    {
        $query = new Boolean();

        $callable($query->boost($boost));

        return $this->search->query($query);
    }

    public function range(
        string $field,
        array $values = [],
        float $boost = 1
    ): Search {
        $clause = new Range($field, $values);

        return $this->search->query($clause->boost($boost));
    }

    public function matchAll(float $boost = 1): Search
    {
        $clause = new MatchAll();

        return $this->search->query($clause->boost($boost));
    }

    public function query(Query $query): Search
    {
        return $this->search->query($query);
    }

    public function matchNone(float $boost = 1): Search
    {
        $clause = new MatchNone();

        return $this->search->query($clause->boost($boost));
    }

    public function match(string $field, string $query, float $boost = 1): Search
    {
        $cluase = new Match_($field, $query);

        return $this->search->query($cluase->boost($boost));
    }

    public function multiMatch(string $query, array $fields, float $boost = 1): Search
    {
        $clause = new MultiMatch($query, $fields);

        return $this->search->query($clause->boost($boost));
    }

    public function exists(string $field, float $boost = 1): Search
    {
        $clause = new Exists($field);

        return $this->search->query($clause->boost($boost));
    }

    public function ids(array $ids, float $boost = 1): Search
    {
        $clause = new IDs($ids);

        return $this->search->query($clause->boost($boost));
    }

    public function fuzzy(string $field, string $value, float $boost = 1): Search
    {
        $clause = new Fuzzy($field, $value);

        return $this->search->query($clause->boost($boost));
    }

    public function terms(string $field, array $values, float $boost = 1): Search
    {
        $clause = new Terms($field, $values);

        return $this->search->query($clause->boost($boost));
    }

    public function regex(string $field, string $regex, float $boost = 1): Search
    {
        $clause = new Regex($field, $regex);

        return $this->search->query($clause->boost($boost));
    }

    public function wildcard(string $field, string $value, float $boost = 1): Search
    {
        $clause = new Wildcard($field, $value);

        return $this->search->query($clause->boost($boost));
    }
}
