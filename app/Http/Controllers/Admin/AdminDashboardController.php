<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Payment;
use App\Models\VipPackage;
use App\Models\GuestMinister;
use App\Models\Sponsor;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\MediaFile;
use App\Models\AttendanceLog;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'eventsCount' => Event::count(),
            'upcomingEvents' => Event::where('starts_at', '>=', now())->orderBy('starts_at')->take(5)->get(),
            'registrationsCount' => Registration::count(),
            'confirmedCount' => Registration::where('status', 'confirmed')->count(),
            'pendingCount' => Registration::where('status', 'payment_pending')->count(),
            'revenue' => Payment::where('status', 'completed')->sum('amount'),
            'pendingPayments' => Payment::where('status', 'pending')->count(),
            'events' => Event::withCount('registrations')->with(['payments'])->orderBy('starts_at')->get(),
            'latestRegistrations' => Registration::with('event', 'vipPackage')->latest()->take(8)->get(),
            'vipPackagesCount' => VipPackage::count(),
            'guestMinistersCount' => GuestMinister::count(),
            'sponsorsCount' => Sponsor::count(),
            'announcementsCount' => Announcement::count(),
            'publishedAnnouncements' => Announcement::whereNotNull('published_at')->count(),
            'draftAnnouncements' => Announcement::whereNull('published_at')->count(),
            'galleriesCount' => Gallery::count(),
            'mediaCount' => MediaFile::count(),
            'checkInsCount' => AttendanceLog::count(),
            'vipRegistrations' => Registration::where('registration_type', 'paid')->count(),
            'freeRegistrations' => Registration::where('registration_type', 'free')->count(),
        ]);
    }
}
