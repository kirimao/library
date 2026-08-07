<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface CategoryRepositoryInterface
 *
 * Mendefinisikan kontrak untuk akses data Kategori Buku.
 * Memisahkan logika kueri database dari logika aplikasi.
 */
interface CategoryRepositoryInterface
{
    public function all(): Collection;
    public function paginate(int $perPage = 15, ?string $search = null): \Illuminate\Contracts\Pagination\LengthAwarePaginator;
    public function findById(int $id);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id): bool;
}
