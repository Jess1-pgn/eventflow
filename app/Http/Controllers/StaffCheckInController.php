<?php

namespace App\Http\Controllers;

use App\Models\CheckIn;
use App\Models\Ticket;
use App\Support\TicketQrSigner;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StaffCheckInController extends Controller
{
    public function index(): View
    {
        $this->authorizeStaffAccess();

        return view('dashboard.check-ins.index');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authorizeStaffAccess();

        $validated = $request->validate([
            'ticket_code' => ['required', 'string', 'max:255'],
        ]);

        $ticket = Ticket::query()
            ->with('checkIn', 'orderItem.order.event')
            ->where('ticket_code', $validated['ticket_code'])
            ->first();

        if ($ticket === null) {
            return back()->withErrors(['ticket_code' => 'Ticket not found.'])->withInput();
        }

        if (! TicketQrSigner::verify($ticket->qr_payload_json, $ticket->qr_signature)) {
            return back()->withErrors(['ticket_code' => 'Invalid ticket signature.'])->withInput();
        }

        if ($ticket->checkIn !== null) {
            return back()->withErrors([
                'ticket_code' => 'Ticket already checked in at '.$ticket->checkIn->checked_in_at?->format('Y-m-d H:i:s'),
            ])->withInput();
        }

        CheckIn::create([
            'ticket_id' => $ticket->id,
            'checked_in_by_user_id' => $request->user()->id,
            'checked_in_at' => now(),
            'is_manual_override' => false,
        ]);

        return back()->with('status', 'Check-in successful for '.$ticket->holder_first_name.'.');
    }

    public function override(Request $request, Ticket $ticket): RedirectResponse
    {
        $this->authorizeStaffAccess();

        $validated = $request->validate([
            'override_reason' => ['required', 'string', 'max:255'],
        ]);

        CheckIn::query()->updateOrCreate(
            ['ticket_id' => $ticket->id],
            [
                'checked_in_by_user_id' => $request->user()->id,
                'checked_in_at' => now(),
                'is_manual_override' => true,
                'override_reason' => $validated['override_reason'],
            ]
        );

        return back()->with('status', 'Manual override saved.');
    }

    private function authorizeStaffAccess(): void
    {
        abort_unless(auth()->check() && auth()->user()->hasAnyRole(['staff', 'organizer', 'super-admin']), 403);
    }
}
