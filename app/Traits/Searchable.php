<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Apply search to the query
     * Searches the entire phrase in each specified field
     */
    public function applySearch(Builder $query, string $searchTerm, array $searchableFields): Builder
    {
        if (empty($searchTerm) || empty($searchableFields)) {
            return $query;
        }

        $searchTerm = trim($searchTerm);
        
        if ($searchTerm === '') {
            return $query;
        }

        return $query->where(function (Builder $q) use ($searchTerm, $searchableFields) {
            foreach ($searchableFields as $field) {
                if (strpos($field, '.') !== false) {
                    // Handle relationship fields
                    $this->applyRelationshipSearch($q, $field, $searchTerm);
                } else {
                    // Handle direct model fields
                    $q->orWhere($field, 'LIKE', "%{$searchTerm}%");
                }
            }
        });
    }

    /**
     * Apply search on relationship fields
     * Example: 'user.name', 'category.title'
     */
    protected function applyRelationshipSearch(Builder $query, string $field, string $searchTerm): void
    {
        $parts = explode('.', $field, 2);
        $relation = $parts[0];
        $relationField = $parts[1];

        $query->orWhereHas($relation, function (Builder $q) use ($relationField, $searchTerm) {
            $q->where($relationField, 'LIKE', "%{$searchTerm}%");
        });
    }

    /**
     * Apply advanced search with multiple terms
     * Searches for each word separately across all fields
     */
    public function applyAdvancedSearch(Builder $query, string $searchTerm, array $searchableFields, string $mode = 'any'): Builder
    {
        if (empty($searchTerm) || empty($searchableFields)) {
            return $query;
        }

        $searchTerm = trim($searchTerm);
        
        if ($searchTerm === '') {
            return $query;
        }

        // Split search term into words
        $words = array_filter(explode(' ', $searchTerm));

        if (empty($words)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($words, $searchableFields, $mode) {
            if ($mode === 'all') {
                // All words must be found (AND logic)
                foreach ($words as $word) {
                    $q->where(function (Builder $subQ) use ($word, $searchableFields) {
                        $this->searchInFields($subQ, $word, $searchableFields);
                    });
                }
            } else {
                // Any word can be found (OR logic)
                foreach ($words as $word) {
                    $this->searchInFields($q, $word, $searchableFields);
                }
            }
        });
    }

    /**
     * Search for a term in all specified fields
     */
    protected function searchInFields(Builder $query, string $term, array $fields): void
    {
        foreach ($fields as $field) {
            if (strpos($field, '.') !== false) {
                // Handle relationship fields
                $this->applyRelationshipSearch($query, $field, $term);
            } else {
                // Handle direct model fields
                $query->orWhere($field, 'LIKE', "%{$term}%");
            }
        }
    }

    /**
     * Apply search with custom operators
     */
    public function applyCustomSearch(Builder $query, array $searchCriteria): Builder
    {
        foreach ($searchCriteria as $criteria) {
            $field = $criteria['field'] ?? null;
            $value = $criteria['value'] ?? null;
            $operator = $criteria['operator'] ?? 'LIKE';
            $boolean = $criteria['boolean'] ?? 'and';

            if (!$field || $value === null || $value === '') {
                continue;
            }

            $method = $boolean === 'or' ? 'orWhere' : 'where';

            if (strpos($field, '.') !== false) {
                // Handle relationship fields
                $parts = explode('.', $field, 2);
                $relation = $parts[0];
                $relationField = $parts[1];

                $hasMethod = $boolean === 'or' ? 'orWhereHas' : 'whereHas';
                
                $query->{$hasMethod}($relation, function (Builder $q) use ($relationField, $operator, $value) {
                    if ($operator === 'LIKE') {
                        $q->where($relationField, $operator, "%{$value}%");
                    } else {
                        $q->where($relationField, $operator, $value);
                    }
                });
            } else {
                // Handle direct model fields
                if ($operator === 'LIKE') {
                    $query->{$method}($field, $operator, "%{$value}%");
                } else {
                    $query->{$method}($field, $operator, $value);
                }
            }
        }

        return $query;
    }

    /**
     * Apply search with highlighting (for display purposes)
     */
    public function applySearchWithHighlight(Builder $query, string $searchTerm, array $searchableFields): Builder
    {
        $query = $this->applySearch($query, $searchTerm, $searchableFields);

        // Add search term to query for potential highlighting in results
        $query->addSelect('*');
        
        // You can extend this to add actual SQL highlighting if needed
        // For now, we'll just apply the search and let the frontend handle highlighting
        
        return $query;
    }

    /**
     * Get search summary for debugging
     */
    public function getSearchSummary(string $searchTerm, array $searchableFields): array
    {
        return [
            'search_term' => $searchTerm,
            'searchable_fields' => $searchableFields,
            'search_applied' => !empty($searchTerm) && !empty($searchableFields)
        ];
    }

    /**
     * Escape special characters for LIKE queries
     */
    protected function escapeLikeValue(string $value): string
    {
        return str_replace(['%', '_'], ['\%', '\_'], $value);
    }

    /**
     * Apply case-insensitive search (useful for some databases)
     */
    public function applyCaseInsensitiveSearch(Builder $query, string $searchTerm, array $searchableFields): Builder
    {
        if (empty($searchTerm) || empty($searchableFields)) {
            return $query;
        }

        $searchTerm = trim(strtolower($searchTerm));
        
        if ($searchTerm === '') {
            return $query;
        }

        return $query->where(function (Builder $q) use ($searchTerm, $searchableFields) {
            foreach ($searchableFields as $field) {
                if (strpos($field, '.') !== false) {
                    // Handle relationship fields
                    $parts = explode('.', $field, 2);
                    $relation = $parts[0];
                    $relationField = $parts[1];

                    $q->orWhereHas($relation, function (Builder $subQ) use ($relationField, $searchTerm) {
                        $subQ->whereRaw('LOWER(' . $relationField . ') LIKE ?', ["%{$searchTerm}%"]);
                    });
                } else {
                    // Handle direct model fields
                    $q->orWhereRaw('LOWER(' . $field . ') LIKE ?', ["%{$searchTerm}%"]);
                }
            }
        });
    }
}