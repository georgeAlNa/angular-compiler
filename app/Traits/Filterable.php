<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Filterable
{
    /**
     * Apply filters to the query
     * Format: ?filters[name]=john&filters[age][between]=18,65&filters[status][in]=active,pending
     */
    public function applyFilters(Builder $query, array $filters, array $allowedFields = []): Builder
    {
        foreach ($filters as $field => $value) {
            // Skip if field is not in allowed fields (when specified)
            if (!empty($allowedFields) && !in_array($field, $allowedFields)) {
                continue;
            }

            // Handle different filter types
            if (is_array($value)) {
                $this->applyComplexFilter($query, $field, $value);
            } else {
                $this->applySimpleFilter($query, $field, $value);
            }
        }

        return $query;
    }

    /**
     * Apply simple filter (exact match)
     * Example: filters[name]=john
     */
    protected function applySimpleFilter(Builder $query, string $field, $value): void
    {
        if ($value !== null && $value !== '') {
            $query->where($field, $value);
        }
    }

    /**
     * Apply complex filters with operators
     * Example: filters[age][between]=18,65 or filters[status][in]=active,pending
     */
    protected function applyComplexFilter(Builder $query, string $field, array $filters): void
    {
        foreach ($filters as $operator => $value) {
            switch ($operator) {
                case 'where':
                    $this->applyWhereFilter($query, $field, $value);
                    break;
                    
                case 'in':
                    $this->applyInFilter($query, $field, $value);
                    break;
                    
                case 'between':
                    $this->applyBetweenFilter($query, $field, $value);
                    break;
                    
                default:
                    // Skip unknown operators
                    break;
            }
        }
    }

    /**
     * Apply where filter (exact match)
     * Example: filters[name][where]=john
     */
    protected function applyWhereFilter(Builder $query, string $field, $value): void
    {
        if ($value !== null && $value !== '') {
            $query->where($field, $value);
        }
    }

    /**
     * Apply IN filter
     * Example: filters[status][in]=active,pending
     */
    protected function applyInFilter(Builder $query, string $field, $value): void
    {
        if (empty($value)) {
            return;
        }

        // Convert comma-separated string to array
        if (is_string($value)) {
            $values = array_map('trim', explode(',', $value));
        } else {
            $values = is_array($value) ? $value : [$value];
        }

        // Remove empty values
        $values = array_filter($values, fn($val) => $val !== null && $val !== '');

        if (!empty($values)) {
            $query->whereIn($field, $values);
        }
    }

    /**
     * Apply BETWEEN filter
     * Example: filters[age][between]=18,65 or filters[created_at][between]=2023-01-01,2023-12-31
     */
    protected function applyBetweenFilter(Builder $query, string $field, $value): void
    {
        if (empty($value)) {
            return;
        }

        // Convert comma-separated string to array
        if (is_string($value)) {
            $values = array_map('trim', explode(',', $value));
        } else {
            $values = is_array($value) ? $value : [$value];
        }

        // Need exactly 2 values for between
        if (count($values) !== 2) {
            return;
        }

        [$start, $end] = $values;

        // Skip if either value is empty
        if ($start === null || $start === '' || $end === null || $end === '') {
            return;
        }

        $query->whereBetween($field, [$start, $end]);
    }

    /**
     * Apply filters with relationships
     * Example: filters[user.name]=john or filters[category.slug]=electronics
     */
    protected function applyRelationshipFilter(Builder $query, string $field, $value): void
    {
        if (strpos($field, '.') === false) {
            return;
        }

        $parts = explode('.', $field, 2);
        $relation = $parts[0];
        $relationField = $parts[1];

        $query->whereHas($relation, function (Builder $q) use ($relationField, $value) {
            if (is_array($value)) {
                $this->applyComplexFilter($q, $relationField, $value);
            } else {
                $this->applySimpleFilter($q, $relationField, $value);
            }
        });
    }

    /**
     * Get filter summary for debugging
     */
    public function getFilterSummary(array $filters): array
    {
        $summary = [];

        foreach ($filters as $field => $value) {
            if (is_array($value)) {
                foreach ($value as $operator => $operatorValue) {
                    $summary[] = [
                        'field' => $field,
                        'operator' => $operator,
                        'value' => $operatorValue
                    ];
                }
            } else {
                $summary[] = [
                    'field' => $field,
                    'operator' => 'where',
                    'value' => $value
                ];
            }
        }

        return $summary;
    }
}