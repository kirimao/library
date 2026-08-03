<?php

namespace App\Livewire\Categories;

use App\Actions\Category\CreateCategoryAction;
use App\Actions\Category\DeleteCategoryAction;
use App\Actions\Category\UpdateCategoryAction;
use App\Models\Category;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Exception;
use Livewire\Component;

class CategoryManager extends Component
{
    public string $name = '';
    public string $code = '';
    public string $slug = '';
    public ?int $editingCategoryId = null;

    public bool $isOpen = false;

    // Delete modal states
    public bool $isDeleteModalOpen = false;
    public ?Category $deletingCategory = null;
    public int $deletingBooksCount = 0;

    public function openModal(?int $id = null)
    {
        $this->resetValidation();
        $this->editingCategoryId = $id;

        if ($id) {
            $categoryRepository = app(CategoryRepositoryInterface::class);
            $category = $categoryRepository->findById($id);
            $this->name = $category->name;
            $this->code = $category->code ?? '';
            $this->slug = $category->slug ?? '';
        } else {
            $this->reset(['name', 'code', 'slug']);
        }

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(['name', 'code', 'slug', 'editingCategoryId']);
        $this->resetValidation();
    }

    public function save(CreateCategoryAction $createAction, UpdateCategoryAction $updateAction)
    {
        $rules = [
            'name' => 'required|string|max:100|unique:categories,name,' . ($this->editingCategoryId ?? 'NULL'),
            'code' => 'nullable|string|max:20|unique:categories,code,' . ($this->editingCategoryId ?? 'NULL'),
            'slug' => 'nullable|string|max:120|unique:categories,slug,' . ($this->editingCategoryId ?? 'NULL'),
        ];
        $this->validate($rules);

        try {
            $data = [
                'name' => $this->name,
                'code' => $this->code ?: null,
                'slug' => $this->slug ?: null,
            ];

            if ($this->editingCategoryId) {
                $updateAction->execute($this->editingCategoryId, $data);
                session()->flash('success', 'Kategori berhasil diperbarui!');
            } else {
                $createAction->execute($data);
                session()->flash('success', 'Kategori baru berhasil ditambahkan!');
            }

            $this->closeModal();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
        }
    }

    public function confirmDelete(int $id)
    {
        $categoryRepository = app(CategoryRepositoryInterface::class);
        $this->deletingCategory = $categoryRepository->findById($id);
        $this->deletingBooksCount = $this->deletingCategory->books()->count();
        $this->isDeleteModalOpen = true;
    }

    public function closeDeleteModal()
    {
        $this->isDeleteModalOpen = false;
        $this->deletingCategory = null;
        $this->deletingBooksCount = 0;
    }

    public function deleteCategory(DeleteCategoryAction $deleteAction)
    {
        if (!$this->deletingCategory) return;

        try {
            $deleteAction->execute($this->deletingCategory->id);
            session()->flash('success', 'Kategori berhasil dihapus!');
            $this->closeDeleteModal();
        } catch (Exception $e) {
            session()->flash('error', $e->getMessage());
            $this->closeDeleteModal();
        }
    }

    public function render(CategoryRepositoryInterface $categoryRepository)
    {
        return view('livewire.categories.category-manager', [
            'categories' => $categoryRepository->all(),
        ])->layout('layouts.app');
    }
}
