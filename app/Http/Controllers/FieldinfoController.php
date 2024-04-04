<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Statusticket;
use App\Models\Priorityticket;
use App\Models\Allocation;
use App\Models\Assettype;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;


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
