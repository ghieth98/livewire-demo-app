<?php

namespace App\Http\Livewire;

use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class CategoriesList extends Component
{
    use WithPagination;

    public Category $category;
    public Collection $categories;
    public bool $showModal = false;
    public array $active = [];
    public int $editedCategoryId = 0;
    public int $currentPage = 1;
    public int $perPage = 10;
    protected $listeners = ['delete'];

    public function openModal(): void
    {
        $this->showModal = true;
        $this->category = new Category();
    }


    public function updatedCategoryName(): void
    {
        $this->category->slug = Str::slug($this->category->name);
    }

    public function updateOrder($list): void
    {
        foreach ($list as $item) {
            $cat = $this->categories->firstWhere('id', $item['value']);
            $order = $item['order'] + (($this->currentPage - 1) * $this->perPage);

            if ($cat['position'] != $order) {
                Category::where('id', $item['value'])->update(['position' => $order]);
            }

        }
    }

    public function editCategory($categoryId): void
    {
        $this->editedCategoryId = $categoryId;
        $this->category = Category::find($categoryId);
    }

    public function toggleIsActive($categoryId): void
    {
        Category::where('id', $categoryId)->update([
            'is_active' => $this->active[$categoryId],
        ]);
    }

    public function cancelCategoryEdit(): void
    {
        $this->resetValidation();
        $this->reset('editedCategoryId');
    }

    public function deleteConfirm($method, $id = null): void
    {
        $this->dispatchBrowserEvent('swal:confirm', [
            'type' => 'warning',
            'title' => 'Are you sure?',
            'text' => '',
            'id' => $id,
            'method' => $method,
        ]);
    }

    public function delete($id): void
    {
        Category::findOrFail($id)->delete();
    }

    public function save(): void
    {
        $this->validate();
        if ($this->editedCategoryId === 0) {
            $this->category->position = Category::max('position') + 1;
        }
        $this->category->save();
        $this->reset('showModal');
        $this->resetValidation();
        $this->reset('showModal', 'editedCategoryId');
    }


    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $cats = Category::orderBy('position')->paginate($this->perPage);

        $links = $cats->links();

        $this->currentPage = $cats->currentPage();

        $this->categories = collect($cats->items());

        $this->active = $this->categories->mapWithKeys(fn(Category $item) => [$item['id'] => (bool)$item['is_active']])->toArray();

        return view('livewire.categories-list', [
            'links' => $links,
        ]);
    }

    protected function rules(): array
    {
        return [
            'category.name' => ['required', 'min:3', 'string'],
            'category.slug' => ['nullable', 'string'],
        ];
    }
}
