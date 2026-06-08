<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\MediaFile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index(Request $request): View
    {
        $query = MediaFile::with('gallery');

        if ($request->filled('gallery_id')) {
            $query->where('gallery_id', $request->gallery_id);
        }

        return view('admin.media.index', [
            'media' => $query->orderByDesc('created_at')->paginate(30),
            'galleries' => Gallery::orderBy('title')->get(),
            'currentGallery' => $request->gallery_id,
        ]);
    }

    public function create(): View
    {
        return view('admin.media.create', [
            'galleries' => Gallery::orderBy('title')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'gallery_id' => ['nullable', 'exists:galleries,id'],
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:photo,video'],
            'file' => ['required', 'file', 'max:10240'],
            'thumbnail' => ['nullable', 'file', 'max:2048'],
        ]);

        $path = $request->file('file')->store('media', 'public');
        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('media/thumbnails', 'public');
        }

        MediaFile::create([
            'gallery_id' => $data['gallery_id'],
            'title' => $data['title'],
            'type' => $data['type'],
            'path' => 'storage/'.$path,
            'thumbnail_path' => $thumbnailPath ? 'storage/'.$thumbnailPath : null,
        ]);

        return redirect()->route('admin.media.index')->with('status', 'Media uploaded.');
    }

    public function destroy(MediaFile $medium): RedirectResponse
    {
        Storage::disk('public')->delete(str_replace('storage/', '', $medium->path));
        if ($medium->thumbnail_path) {
            Storage::disk('public')->delete(str_replace('storage/', '', $medium->thumbnail_path));
        }
        $medium->delete();

        return back()->with('status', 'Media deleted.');
    }
}
