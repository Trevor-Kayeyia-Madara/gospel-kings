<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class EventCategoryController extends Controller
{
    public function index(): View
    {
        return view('admin.categories.index', [
            'categories' => EventCategory::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        EventCategory::create($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category created.');
    }

    public function edit(EventCategory $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, EventCategory $category): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ]);

        $data['slug'] = Str::slug($data['name']);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('status', 'Category updated.');
    }

    public function destroy(EventCategory $category): RedirectResponse
    {
        $category->delete();

        return back()->with('status', 'Category deleted.');
    }
}
