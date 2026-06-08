<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function registrations(): View
    {
        return view('admin.reports.registrations', [
            'registrations' => Registration::with('event', 'vipPackage')->orderByDesc('created_at')->get(),
        ]);
    }

    public function exportRegistrations(Request $request)
    {
        $registrations = Registration::with('event', 'vipPackage')->orderByDesc('created_at')->get();

        $csv = "Registration Number,Name,Phone,Email,Church,County,Gender,Event,VIP Package,Type,Status,Created At\n";

        foreach ($registrations as $reg) {
            $csv .= collect([
                $reg->registration_number,
                $reg->full_name,
                $reg->phone,
                $reg->email ?? '',
                $reg->church ?? '',
                $reg->county_city ?? '',
                $reg->gender ?? '',
                $reg->event->title ?? '',
                $reg->vipPackage->name ?? 'Free',
                $reg->registration_type,
                $reg->status,
                $reg->created_at->format('Y-m-d H:i'),
            ])->map(fn ($field) => '"'.str_replace('"', '""', $field).'"')->implode(',') . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="registrations-'.now()->format('Y-m-d').'.csv"',
        ]);
    }

    public function finance(): View
    {
        return view('admin.reports.finance', [
            'payments' => Payment::with('registration.event')->orderByDesc('created_at')->get(),
            'donors' => \App\Models\Donor::all(),
        ]);
    }

    public function exportFinance(Request $request)
    {
        $payments = Payment::with('registration.event')->orderByDesc('created_at')->get();

        $csv = "Payment ID,Amount,Method,Status,Receipt,Registration,Event,Name,Phone,Created At\n";

        foreach ($payments as $payment) {
            $reg = $payment->registration;
            $csv .= collect([
                $payment->id,
                $payment->amount,
                $payment->method,
                $payment->status,
                $payment->receipt_number ?? '',
                $reg->registration_number ?? '',
                $reg->event->title ?? '',
                $reg->full_name ?? '',
                $reg->phone ?? '',
                $payment->created_at->format('Y-m-d H:i'),
            ])->map(fn ($field) => '"'.str_replace('"', '""', $field).'"')->implode(',') . "\n";
        }

        return Response::make($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="finance-'.now()->format('Y-m-d').'.csv"',
        ]);
    }
}
