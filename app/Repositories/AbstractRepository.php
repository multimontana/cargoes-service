<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as DBBuilder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected Model $model;
    protected DB $db;

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return $this->model->getTable();
    }

    /**
     * @param string $tableName
     * @return DBBuilder
     */
    public function getDb(string $tableName): DBBuilder
    {
        return DB::table($tableName);
    }

    /**
     * @return Builder
     */
    public function newQuery(): Builder
    {
        return $this->model
        ->newQuery();
    }

    /**
     * @return Collection
     */
    public function getAll(): Collection
    {
        return $this
            ->newQuery()
            ->get();
    }

    /**
     * @param int $id
     * @return Model|null
     */
    public function findOneById(int $id): ?Model
    {
        return $this
            ->newQuery()
            ->find($id);
    }

    /**
     * @param string $email
     * @return Model|null
     */
    public function findOneByEmail(string $email): ?Model
    {
        return $this
            ->newQuery()
            ->where('email', '=', $email)
            ->first();
    }

    /**
     * @param int $id
     * @return Model
     */
    public function getOneById(int $id): Model
    {
        return $this->model
            ->query()
            ->findOrFail($id);
    }

    /**
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model
    {
        return $this->model
            ->create($data)
            ->refresh();
    }

    /**
     * @param array $data
     * @return bool
     */
    public function insert(array $data): ?bool
    {
        return $this->model
        ->insert($data);
    }

    /**
     * @param array $options
     * @param array $data
     * @return Model|null
     */
    public function updateOrCreate(array $options, array $data): ?Model
    {
        return $this->model
            ->updateOrCreate($options, $data);
    }

    /**
     * @param array $options
     * @param array $data
     * @return Model|null
     */
    public function firstOrCreate(array $options, array $data): ?Model
    {
        return $this->model
            ->firstOrCreate($options, $data);
    }

    /**
     * @param array $data
     * @param int $id
     * @return bool
     */
    public function update(array $data, int $id): bool
    {
        $query = $this->model
            ->find($id);

        if ($query) {
            return $query->update($data);
        }

        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        return $this->model
            ->whereIn('id', $id)
            ->delete();
    }

    /**
     * @param array $request
     * @return array
     */
    public function get(array $request): array
    {

        $query = $this->getDb($this->getTableName())
            ->select($request['db']['table'] . '.*')
            ->where('user_id', '=', $request['auth_user_id']);

        if (isset($request['query']['type']) && $request['query']['type'] === 'deleted') {
            $query = $query->whereNotNull('deleted_at');
        } else {
            $query = $query->whereNull('deleted_at');
        }

        $count = count($query->get()) ?? 0;

        if (isset($request['query']['language_name'])) {
            $query = $query->where('language_name', '=', $request['query']['language_name']);
            $count = count($query->get());
        }

        if (isset($request['query']['q'])) {
            $query = $query->where($this->getTableName() . '.name', 'iLIKE', "%{$request['query']['q']}%");
            $count = count($query->get());
        }

        if (isset($request['query']['offset']) && isset($request['query']['limit'])) {
            $query = $query
                ->offset($request['query']['offset'] - 1)
                ->limit($request['query']['limit']);
        }

        return [
            'count' => $count,
            'result' => $query->get()
        ];
    }

    /**
     * @param array $request
     *
     * @return array
     */
    public function getDeletedData(array $request): array
    {
        $query = $this->getDb($this->getTableName())
            ->select($this->getTableName() . '.*')
            ->whereNotNull('deleted_at');

        $count = count($query->get()) ?? 0;

        if (isset($request['query']['language_name'])) {
            $query = $query->where('language_name', '=', $request['query']['language_name']);
            $count = count($query->get());
        }

        if (isset($request['query']['q'])) {
            $query = $query->where($this->getTableName() . '.name', 'iLIKE', "%{$request['query']['q']}%");
            $count = count($query->get());
        }

        if (isset($request['query']['offset']) && isset($request['query']['limit'])) {
            $query = $query
                ->offset($request['query']['offset'] - 1)
                ->limit($request['query']['limit']);
        }

        return [
            'count' => $count,
            'result' => $query->get()
        ];
    }
}
