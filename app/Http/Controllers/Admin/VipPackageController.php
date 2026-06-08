<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\VipPackage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VipPackageController extends Controller
{
    public function index(): View
    {
        return view('admin.vip-packages.index', [
            'packages' => VipPackage::with('event')->orderByDesc('created_at')->get(),
        ]);
    }

    public function create(): View
    {
        return view('admin.vip-packages.create', [
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'benefits' => ['nullable', 'array'],
        ]);

        VipPackage::create($data);

        return redirect()->route('admin.vip-packages.index')->with('status', 'VIP package created.');
    }

    public function edit(VipPackage $vipPackage): View
    {
        return view('admin.vip-packages.edit', [
            'package' => $vipPackage,
            'events' => Event::orderBy('starts_at')->get(),
        ]);
    }

    public function update(Request $request, VipPackage $vipPackage): RedirectResponse
    {
        $data = $request->validate([
            'event_id' => ['required', 'exists:events,id'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'amount' => ['required', 'numeric', 'min:0'],
            'capacity' => ['nullable', 'integer', 'min:1'],
            'benefits' => ['nullable', 'array'],
        ]);

        $vipPackage->update($data);

        return redirect()->route('admin.vip-packages.index')->with('status', 'VIP package updated.');
    }

    public function destroy(VipPackage $vipPackage): RedirectResponse
    {
        $vipPackage->delete();

        return back()->with('status', 'VIP package deleted.');
    }
}
