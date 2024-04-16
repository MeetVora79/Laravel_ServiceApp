<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Allocation;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;



class FieldinfoController extends Controller
{

    public function showAllocation($AllocationId): view
    {
        return view('tickets.onfield',[
            'allocation' => Allocation::where('AllocationId', $AllocationId)->first(),
        ]);
    }
 
    public function statusUpdate($TicketId, $status): RedirectResponse
    {
        $statusMappings = [
            'open' => 1, 
            'closed' => 2, 
            'resolved' => 3, 
        ];
    
        $ticket = Ticket::findOrFail($TicketId);
        $ticket->TicketStatusId = $statusMappings[$status] ?? null;
        $ticket->save();

        return redirect()->route('tickets.allocation');
    }
 

}
