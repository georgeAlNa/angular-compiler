<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Exceptions\ModelNotFoundException;
use App\Traits\Filterable;
use App\Traits\Searchable;

class BaseService
{
    use Filterable, Searchable;

    protected Model $model;
    protected array $searchableFields = [];
    protected array $filterableFields = [];
    protected array $relationships = [];

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get relationships to load
     */
    protected function getRelationships(): array
    {
        // Use service relationships if set, otherwise try to get from model
        if (!empty($this->relationships)) {
            return $this->relationships;
        }

        // Check if model has a relationships property
        if (property_exists($this->model, 'relationships')) {
            return $this->model->relationships ?? [];
        }

        return [];
    }

    /**
     * Get all records with filtering and search
     */
    public function all(array $params = []): Collection
    {
        $query = $this->model->newQuery();

        // Load relationships
        $relationships = $this->getRelationships();
        if (!empty($relationships)) {
            $query->with($relationships);
        }

        // Apply search
        if (isset($params['search']) && !empty($this->searchableFields)) {
            $query = $this->applySearch($query, $params['search'], $this->searchableFields);
        }

        // Apply filters
        if (isset($params['filters'])) {
            $query = $this->applyFilters($query, $params['filters'], $this->filterableFields);
        }

        // Apply sorting
        if (isset($params['sort_by'])) {
            $direction = $params['sort_direction'] ?? 'asc';
            $query->orderBy($params['sort_by'], $direction);
        } else {
            $query->latest();
        }

        return $query->get();
    }

    /**
     * Get paginated records with filtering and search
     */
    public function paginate(array $params = []): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        // Load relationships
        $relationships = $this->getRelationships();
        if (!empty($relationships)) {
            $query->with($relationships);
        }

        // Apply search
        if (isset($params['search']) && !empty($this->searchableFields)) {
            $query = $this->applySearch($query, $params['search'], $this->searchableFields);
        }

        // Apply filters
        if (isset($params['filters'])) {
            $query = $this->applyFilters($query, $params['filters'], $this->filterableFields);
        }

        // Apply sorting
        if (isset($params['sort_by'])) {
            $direction = $params['sort_direction'] ?? 'asc';
            $query->orderBy($params['sort_by'], $direction);
        } else {
            $query->latest();
        }

        $perPage = $params['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Create a new record
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * Find record by ID
     */
    public function findById(int $id): Model
    {
        $query = $this->model->newQuery();

        $relationships = $this->getRelationships();
        if (!empty($relationships)) {
            $query->with($relationships);
        }

        $record = $query->find($id);

        if (!$record) {
            throw new ModelNotFoundException("Record with ID {$id} not found");
        }

        return $record;
    }

    /**
     * Update record by ID
     */
    public function update(int $id, array $data): Model
    {
        $record = $this->findById($id);
        $record->update($data);

        $relationships = $this->getRelationships();
        return $record->fresh($relationships);
    }

    /**
     * Delete record by ID
     */
    public function delete(int $id): bool
    {
        $record = $this->findById($id);

        return $record->delete();
    }

    /**
     * Find record by specific field
     */
    public function findBy(string $field, $value): ?Model
    {
        $query = $this->model->newQuery();

        $relationships = $this->getRelationships();
        if (!empty($relationships)) {
            $query->with($relationships);
        }

        return $query->where($field, $value)->first();
    }

    /**
     * Get records by specific field
     */
    public function getBy(string $field, $value): Collection
    {
        $query = $this->model->newQuery();

        $relationships = $this->getRelationships();
        if (!empty($relationships)) {
            $query->with($relationships);
        }

        return $query->where($field, $value)->get();
    }

    /**
     * Check if record exists
     */
    public function exists(int $id): bool
    {
        return $this->model->where('id', $id)->exists();
    }

    /**
     * Get count of records
     */
    public function count(array $params = []): int
    {
        $query = $this->model->newQuery();

        // Apply search
        if (isset($params['search']) && !empty($this->searchableFields)) {
            $query = $this->applySearch($query, $params['search'], $this->searchableFields);
        }

        // Apply filters
        if (isset($params['filters'])) {
            $query = $this->applyFilters($query, $params['filters'], $this->filterableFields);
        }

        return $query->count();
    }
}
