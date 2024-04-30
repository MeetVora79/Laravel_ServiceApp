<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Asset;
use App\Models\Customer;
use App\Models\Staff;
use App\Models\Priorityticket;
use App\Models\Allocation;
use Exception;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schema;



class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-ticket|edit-ticket|delete-ticket|assign-ticket', ['only' => ['index', 'show', 'assign', 'onfield']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $status = $request->get('status');

        $sort = $request->get('sort', 'TicketId');
        $direction = $request->get('direction', 'asc');
        $searchTerm = $request->input('searchTerm');
        $ticketsQuery  = Ticket::query();

        if ($status === 'Open') {
            $ticketsQuery->where('TicketStatusId', '1');
        } elseif ($status === 'Closed') {
            $ticketsQuery->where('TicketStatusId', '2');
        } elseif ($status === 'Resolved') {
            $ticketsQuery->where('TicketStatusId', '3');
        }

        if (!empty($searchTerm)) {
            $ticketsQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('tickets');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('asset', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('priorityticket', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('PriorityName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('statusticket', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StatusName', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $ticketsQuery->orderBy($sort, $direction);

        $tickets  = $ticketsQuery->paginate(10);
        $hasTickets = $tickets->isNotEmpty();

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('tickets.index', compact('tickets', 'hasTickets', 'nextDirection'), []);
    }

    public function myTickets(Request $request): View
    {
        $sort = $request->get('sort', 'TicketId');
        $direction = $request->get('direction', 'asc');
        $userId = Auth::user()->id;
        $TicketCusId = Customer::where('user_id', $userId)->value('CustomerId');
        $searchTerm = $request->input('searchTerm');
        $ticketsQuery  = Ticket::query();

        if (!empty($searchTerm)) {
            $ticketsQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('tickets');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('asset', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('priorityticket', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('PriorityName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('statusticket', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StatusName', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $ticketsQuery->where('TicketCreaterId', $TicketCusId)->get();
        $ticketsQuery->orderBy($sort, $direction);

        $tickets  = $ticketsQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('tickets.mytickets', compact('tickets', 'nextDirection', 'ticketsQuery', 'TicketCusId'), []);
    }

    public function updateStatus($TicketId, $status): RedirectResponse
    {
        $statusMappings = [
            'open' => 1,
            'closed' => 2,
            'resolved' => 3,
        ];

        $ticket = Ticket::findOrFail($TicketId);
        $ticket->TicketStatusId = $statusMappings[$status] ?? null;
        $ticket->save();

        return redirect()->route('tickets.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('tickets.create', [
            'assets' => Asset::select('AssetId', 'AssetName')->get(),
            'ticketpriority' => Priorityticket::select('PriorityId', 'PriorityName')->get(),
            'customers' => Customer::select('CustomerId', 'firstname', 'lastname')->get(),
        ]);
    }

    public function mycreate(): View
    {
        $userId = Auth::user()->id;
        $TicketCusId = Customer::where('user_id', $userId)->value('CustomerId');
        return view('tickets.mycreate', [
            'assets' => Asset::where('AssetCusId', $TicketCusId)->get(),
            'ticketpriority' => Priorityticket::select('PriorityId', 'PriorityName')->get(),
            'customers' => Customer::where('CustomerId', $TicketCusId)->get(),
        ]);
    }

    public function assign($TicketId): view
    {
        return view('tickets.assign', [
            'ticket' => Ticket::where('TicketId', $TicketId)->first(),
            'staffs' => DB::table("staffs")->where("role", '3')->get(),
        ]);
    }

    public function editassign(Ticket $ticket, $AllocationId): view
    {
        return view('tickets.editassign', [
            'ticket' => $ticket,
            'staffs' => DB::table("staffs")->where("role", '3')->get(),
            'allocation' => Allocation::where('AllocationId', $AllocationId)->first(),
        ]);
    }

    public function allocation(Request $request): view
    {
        $sort = $request->get('sort', 'AllocationId');
        $direction = $request->get('direction', 'asc');

        $searchTerm = $request->input('searchTerm');
        $allocationQuery = Allocation::query();

        if (!empty($searchTerm)) {
            $allocationQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('allocations');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $allocationQuery->orderBy($sort, $direction);
        $allocation =  $allocationQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('tickets.allocation', compact('allocation', 'nextDirection'));
    }

    public function myAllocation(Request $request): view
    {
        $sort = $request->get('sort', 'AllocationId');
        $direction = $request->get('direction', 'asc');
        $userId = Auth::user()->id;
        $TicketStaffId = Staff::where('user_id', $userId)->value('StaffId');
        $searchTerm = $request->input('searchTerm');
        $allocationQuery = Allocation::query();

        if (!empty($searchTerm)) {
            $allocationQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('allocations');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $allocationQuery->orderBy($sort, $direction);
        $allocationQuery->where('AssignId', $TicketStaffId)->get();

        $allocation =  $allocationQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('tickets.myallocation', compact('allocation', 'nextDirection'));
    }

    public function assigneestore(Request $request, Allocation $allocation): RedirectResponse
    {
        try {
            $allocation->TicketId = $request->TicketId;
            $allocation->AssignId = $request->AssignId;
            $allocation->ServiceDate = $request->ServiceDate;
            $allocation->TimeSlot = $request->TimeSlot;
            $allocation->Instruction = $request->Instruction;
            $allocation->save();

            $this->sendTicketAllocationEmail($allocation);
            $this->sendTicketAllocationUserEmail($allocation);

            return redirect()->route('tickets.allocation')->withSuccess('Ticket-Allocation is Created Successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    protected function sendTicketAllocationEmail(Allocation $allocation)
    {

        $to_email = 'meetvora792@gmail.com';

        $data = [
            'name' => $allocation->staff->StaffName,
            'id' => $allocation->TicketId,
            'subject' => $allocation->ticket->TicketSubject,
            'description' => $allocation->ticket->TicketDescription,
            'servicedate' => $allocation->ServiceDate,
            'time' => $allocation->TimeSlot,
            'instruction' => $allocation->Instruction,
            'body' => "A ticket has been allocated to you with the following details:"
        ];

        Mail::send('mailAllocation', $data, function ($message) use ($to_email, $allocation) {
            $message->from('meetvora792@gmail.com', 'Admin');
            $message->to($to_email)->subject("Ticket Allocation: {$allocation->ticket->TicketSubject}");
        });
    }

    protected function sendTicketAllocationUserEmail(Allocation $allocation)
    {

        $to_email = 'meetvora792@gmail.com';

        $data = [
            'name' => $allocation->ticket->customer->firstname .' '. $allocation->ticket->customer->lastname,
            'id' => $allocation->TicketId,
            'subject' => $allocation->ticket->TicketSubject,
            'description' => $allocation->ticket->TicketDescription,
            'engineer' => $allocation->staff->StaffName,
            'servicedate' => $allocation->ServiceDate,
            'time' => $allocation->TimeSlot,
            'body' => "Your ticket has been allocated to engineer with the following details:"
        ];

        Mail::send('mailAllocationUser', $data, function ($message) use ($to_email, $allocation) {
            $message->from('meetvora792@gmail.com', 'Admin');
            $message->to($to_email)->subject("Ticket Allocated: {$allocation->ticket->TicketSubject}");
        });
    }

    public function assigneeupdate(Request $request, Allocation $AllocationId): RedirectResponse
    {
        $input = $request->all();
        try {
            $AllocationId->update($input);
            return redirect()->route('tickets.allocation')->withSuccess('Ticket-Allocation is Updated Successfully');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Ticket $ticket): RedirectResponse
    {
        try {
            $ticket->TicketSubject = $request->TicketSubject;
            $ticket->TicketCreaterId = $request->TicketCreaterId;
            $ticket->TicketAssetId = $request->TicketAssetId;
            $ticket->TicketPriorityId = $request->TicketPriorityId;
            $ticket->TicketDescription = $request->TicketDescription;
            $originalFileName = $request->Attachments->getClientOriginalName();
            $request->Attachments->move(public_path('uploads'), $originalFileName);
            $ticket->Attachments = $originalFileName;
            $ticket->save();

            $this->sendTicketCreationEmail($ticket);

            return redirect()->route('tickets.index')
                ->with('success', 'Your Ticket is Created Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function mystore(Request $request, Ticket $ticket): RedirectResponse
    {
        try {
            $ticket->TicketSubject = $request->TicketSubject;
            $ticket->TicketCreaterId = $request->TicketCreaterId;
            $ticket->TicketAssetId = $request->TicketAssetId;
            $ticket->TicketPriorityId = $request->TicketPriorityId;
            $ticket->TicketDescription = $request->TicketDescription;
            $originalFileName = $request->Attachments->getClientOriginalName();
            $request->Attachments->move(public_path('uploads'), $originalFileName);
            $ticket->Attachments = $originalFileName;
            $ticket->save();

            // Send email
            $this->sendTicketCreationEmail($ticket);

            return redirect()->route('mytickets')
                ->with('success', 'Your Ticket is Created Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    protected function sendTicketCreationEmail(Ticket $ticket)
    {

        $to_email = 'meetvora792@gmail.com';

        $fromAddress = $ticket->customer->email ?? 'user@gmail.com';
        $fromName = $ticket->customer->firstname . ' ' . $ticket->customer->lastname;

        $data = [
            'name' => $fromName,
            'subject' => $ticket->TicketSubject,
            'description' => $ticket->TicketDescription,
            'body' => "A new ticket has been created with the following details:"
        ];

        Mail::send('mail', $data, function ($message) use ($to_email, $fromAddress, $fromName, $ticket) {
            $message->from($fromAddress, $fromName);
            $message->to($to_email)->subject("New Ticket: {$ticket->TicketSubject}");
        });
    }


    /**
     * Display the specified resource.
     */
    public function show($TicketId): View
    {
        $ticket = Ticket::where('TicketId', $TicketId)->first();
        return view('tickets.show', [
            'ticket' => $ticket,
        ]);
    }

    public function myshow($TicketId): View
    {
        $ticket = Ticket::where('TicketId', $TicketId)->first();
        return view('tickets.myshow', [
            'ticket' => $ticket,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket): View
    {
        return view('tickets.edit', [
            'ticket' => $ticket,
            'assets' => Asset::select('AssetId', 'AssetName')->get(),
            'ticketpriorities' => Priorityticket::select('PriorityId', 'PriorityName')->get(),
            'customers' => Customer::select('CustomerId', 'firstname', 'lastname')->get(),

        ]);
    }
    public function myedit(Ticket $ticket, $TicketId): View
    {
        $userId = Auth::user()->id;
        $ticket = Ticket::where('TicketId', $TicketId)->first();
        $TicketCusId = Customer::where('user_id', $userId)->value('CustomerId');
        return view('tickets.myedit', compact('ticket'), [
            'assets' => Asset::where('AssetCusId', $TicketCusId)->get(),
            'ticketpriorities' => Priorityticket::select('PriorityId', 'PriorityName')->get(),
            'customers' => Customer::where('CustomerId', $TicketCusId)->get(),

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket): RedirectResponse
    {
        try {
            $ticket->TicketSubject = $request->TicketSubject;
            $ticket->TicketCreaterId = $request->TicketCreaterId;
            $ticket->TicketAssetId = $request->TicketAssetId;
            $ticket->TicketPriorityId = $request->TicketPriorityId;
            $ticket->TicketDescription = $request->TicketDescription;
            $originalFileName = $request->Attachments->getClientOriginalName();
            $request->Attachments->move(public_path('uploads'), $originalFileName);
            $ticket->Attachments = $originalFileName;
            $ticket->update();
            return redirect()->route('tickets.index')
                ->with('success', 'Ticket is Updated Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function myupdate(Request $request, $TicketId): RedirectResponse
    {
        $input = $request->validate([
            'TicketCreaterId' => ['required', 'integer', 'exists:customers,CustomerId'],
            'TicketSubject' => ['required', 'string', 'max:255'],
            'TicketAssetId' => ['required', 'integer', 'exists:assets,AssetId'],
            'TicketPriorityId' => ['required', 'integer', 'exists:prioritytickets,PriorityId'],
            'TicketDescription' => ['required', 'string', 'max:255'],
            'Attachments' => ['file'],
        ]);
        if ($request->hasFile('Attachments')) {
            $originalFileName = $request->Attachments->getClientOriginalName();
            $request->Attachments->move(public_path('uploads'), $originalFileName);
            $input['Attachments'] = $originalFileName;
        }
        $ticket = Ticket::where('TicketId', $TicketId)->first();
        try {
            $ticket->update($input);
            return redirect()->route('mytickets')
                ->with('success', 'Ticket is Updated Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket): RedirectResponse
    {
        try {
            $ticket->delete();
            return redirect()->route('tickets.index')->with('success', 'Ticket is Deleted Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function delete(Allocation $allocation): RedirectResponse
    {
        try {
            $allocation->delete();
            return redirect()->route('tickets.allocation')->with('success', 'Allocation is Deleted Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    public function deleteTickets($TicketId): RedirectResponse
    {
        try {
            $ticket = Ticket::where('TicketId', $TicketId)->first();
            $ticket->delete();
            return redirect()->route('mytickets')->with('success', 'Ticket is Deleted Successfully.');
        } catch (Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }
}
