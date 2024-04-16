<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Schema;

class CustomerController extends Controller
{
    
     public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:create-customer|edit-customer|delete-customer', ['only' => ['index','show']]);
        $this->middleware('permission:create-customer', ['only' => ['create','store']]);
        $this->middleware('permission:edit-customer', ['only' => ['edit','update']]);
        $this->middleware('permission:delete-customer', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sort = $request->get('sort','CustomerId');
        $direction = $request->get('direction', 'asc');

        $searchTerm = $request->input('searchTerm');
        $customerQuery = Customer::query();

        if (!empty($searchTerm) ){
            $customerQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('customers');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
            });
        }

        $customerQuery->orderBy($sort,$direction);
        $customers = $customerQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('customers.index',compact('customers','nextDirection'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('customers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:10','min:10'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'address' => ['required', 'string', 'max:255'],
        ]);

		$customer = new Customer;
		$customer->firstname = $request->firstname;
		$customer->lastname = $request->lastname;
		$customer->mobile = $request->mobile;
		$customer->email = $request->email;
		$customer->address = $request->address;
		$customer->save();

        return redirect()->route('customers.index')
                ->with('success','New Customer is Created Successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($CustomerId): View
    {
        $customer = Customer::where('CustomerId',$CustomerId)->first();
        return view('customers.show', [
            'customer' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($CustomerId): View
    {
        $customer = Customer::where('CustomerId',$CustomerId)->first();
        return view('customers.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $CustomerId): RedirectResponse
    {

       $input = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'mobile' => ['required', 'string', 'max:10','min:10'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
        ]);

        $customer = Customer::where('CustomerId', $CustomerId)->first();
		$customer->firstname = $request->firstname;
		$customer->lastname = $request->lastname;
		$customer->mobile = $request->mobile;
		$customer->email = $request->email;
		$customer->address = $request->address;
        $customer->update($input);

        if(empty($request->from)){
        return redirect()->route('customers.index')
                ->with('success','Customer is Updated Successfully.');
        }else{
            return redirect()->route('customers.edit')
                ->with('error','Something went Wrong.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($CustomerId): RedirectResponse
    {
        $customer = Customer::where('CustomerId', $CustomerId)->first();
        $customer->delete();
        return redirect()->route('customers.index')->with('success','Customer is Deleted Successfully.');
    }
}
