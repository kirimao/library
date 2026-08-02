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
    public function findById(int $id);
}
