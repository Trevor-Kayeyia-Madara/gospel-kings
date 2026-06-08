<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\MediaFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(): View
    {
        return view('admin.galleries.index', [
            'galleries' => Gallery::with(['event', 'mediaFiles'])->orderByDesc('created_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.galleries.create', [
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['nullable', 'exists:events,id'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:galleries,slug'],
        ]);

        $data['slug'] = $data['slug'] ?? \Illuminate\Support\Str::slug($data['title']);

        Gallery::create($data);

        return redirect()->route('admin.galleries.index')->with('status', 'Gallery created.');
    }

    public function show(Gallery $gallery): View
    {
        return view('admin.galleries.show', [
            'gallery' => $gallery->load('mediaFiles', 'event'),
        ]);
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        $gallery->delete();

        return back()->with('status', 'Gallery deleted.');
    }
}
