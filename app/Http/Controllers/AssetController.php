<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Assettype;
use App\Models\Department;
use App\Models\Organization;
use App\Models\Staff;
use App\Models\Customer;
use App\Models\ServiceOffer;
use App\Models\Servicetype;
use App\Models\Servicedate;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;



class AssetController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $sort = $request->get('sort', 'AssetId');
        $direction = $request->get('direction', 'asc');

        $searchTerm = $request->input('searchTerm');
        $assetQuery = Asset::query();

        if (!empty($searchTerm)) {
            $assetQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('assets');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('assettype', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetTypeName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('department', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('DepartmentName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('organization', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('OrganizationName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('servicetype', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('ServiceDesc', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $assetQuery->orderBy($sort, $direction);
        $assets = $assetQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('assets.index', compact('assets', 'nextDirection'), [
            'assettypes' => Assettype::pluck('AssetTypeName'),
            'departments' => Department::pluck('DepartmentName'),
            'organizations' => Organization::pluck('OrganizationName'),
            'services' => Servicetype::select('ServiceDesc')->get(),
        ]);
    }

    public function myAssets(Request $request): View
    {
        $sort = $request->get('sort', 'AssetId');
        $direction = $request->get('direction', 'asc');
        $searchTerm = $request->input('searchTerm');
        $userId = Auth::user()->id;
        $TicketCusId = Customer::where('user_id', $userId)->value('CustomerId');

        $assetQuery = Asset::query();
        if (!empty($searchTerm)) {
            $assetQuery->where(function ($query) use ($searchTerm) {
                $columns = Schema::getColumnListing('assets');
                foreach ($columns as $index => $column) {
                    $method = $index === 0 ? 'where' : 'orWhere';
                    $query->$method($column, 'LIKE', '%' . $searchTerm . '%');
                }
                $query->orWhereHas('assettype', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('AssetTypeName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('department', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('DepartmentName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('organization', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('OrganizationName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('staff', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('StaffName', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('customer', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('firstname', 'LIKE', '%' . $searchTerm . '%')
                        ->orWhere('lastname', 'LIKE', '%' . $searchTerm . '%');
                });
                $query->orWhereHas('servicetype', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('ServiceDesc', 'LIKE', '%' . $searchTerm . '%');
                });
            });
        }

        $assetQuery->orderBy($sort, $direction);
        $assetQuery->where('AssetCusId', $TicketCusId)->get();
        $assets = $assetQuery->paginate(10);

        $nextDirection = $direction == 'asc' ? 'desc' : 'asc';

        return view('assets.myassets', compact('assets', 'nextDirection'), [
            'assets' => Asset::orderBy('AssetId')->paginate(15),
            'assettypes' => Assettype::pluck('AssetTypeName'),
            'departments' => Department::pluck('DepartmentName'),
            'organizations' => Organization::pluck('OrganizationName'),
            // 'services' => Servicetype::select('ServiceDesc')->get(),          
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('assets.create', [
            'assettypes' => Assettype::select('AssetTypeId', 'AssetTypeName')->get(),
            'assetdepartments' => Department::select('DepartmentId', 'DepartmentName')->get(),
            'assetorganizations' => Organization::select('OrganizationId', 'OrganizationName')->get(),
            'customers' => Customer::select('CustomerId', 'firstname', 'lastname')->get(),
            'staffs' => Staff::select('StaffId', 'StaffName')->get(),
            'services' => Servicetype::select('ServiceDesc', 'id')->get(),
            'numofservices' => ServiceOffer::get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'AssetCusId' => ['required', 'integer', 'exists:customers,CustomerId'],
            'AssetName' => ['required', 'string', 'max:255'],
            'AssetSerialNum' => ['required', 'string', 'max:255'],
            'AssetTypeId' => ['required', 'integer', 'exists:assettypes,AssetTypeId'],
            'AssetDescription' => ['required', 'string', 'max:255'],
            'AssetDepartmentId' => ['required', 'integer', 'exists:departments,DepartmentId'],
            'AssetOrganizationId' => ['required', 'integer', 'exists:organizations,OrganizationId'],
            'AssetLocation' => ['required', 'string', 'max:255'],
            'AssetManagedBy' => ['required', 'integer', 'exists:users,id'],
            'AssetPurchaseDate' => ['required', 'string', 'date'],
            'AssetWarrantyExpiryDate' => ['required', 'string', 'date'],
            'AssetServiceTypeId' => ['required', 'integer', 'exists:servicetypes,id'],
            'NumberOfServices' => ['required', 'integer'],
            'AssetImage' => ['file'],

        ]);

        // $request->validate([
        //     'ServiceDate.*' => 'required|date',
        // ]);

        if ($request->hasFile('AssetImage')) {
            $originalFileName = $request->AssetImage->getClientOriginalName();
            $request->AssetImage->move(public_path('uploads'), $originalFileName);
            $validatedData['AssetImage'] = $originalFileName;
        }

        try {
            $serviceDates = $request->ServiceDate;
            $serviceDate = new Servicedate();
            foreach ($serviceDates as $index => $date) {
                $dateColumn = 'ServiceDate' . ($index + 1);
                $serviceDate->$dateColumn = $date;
            }
            $serviceDate->save();
            $validatedData['ServiceDateId'] = $serviceDate->ServiceDateId;           
            Asset::create($validatedData);

            return redirect()->route('assets.index')->with('success', 'Asset is created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($AssetId): View
    {
        $asset = Asset::where('AssetId', $AssetId)->first();
        return view('assets.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request ,$AssetId): View
    {
        $asset = Asset::where('AssetId', $AssetId)->first();
        $getDateId = Asset::where('AssetId', $AssetId)->value('ServiceDateId');
        $serviceDate = Servicedate::where('ServiceDateId',$getDateId)->first();
        // $dd = $asset->serviceDate->toJson();
        // dd($serviceDate);
        return view('assets.edit', compact('asset','serviceDate'), [
            'assettypes' => Assettype::select('AssetTypeId', 'AssetTypeName')->get(),
            'assetdepartments' => Department::select('DepartmentId', 'DepartmentName')->get(),
            'assetorganizations' => Organization::select('OrganizationId', 'OrganizationName')->get(),
            'customers' => Customer::select('CustomerId', 'firstname', 'lastname')->get(),
            'staffs' => Staff::select('StaffId', 'StaffName')->get(),
            'services' => Servicetype::select('ServiceDesc', 'id')->get(),
            'numofservices' => ServiceOffer::get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $AssetId): RedirectResponse
    {
        $validatedData = $request->validate([
            'AssetCusId' => ['required', 'integer', 'exists:customers,CustomerId'],
            'AssetName' => ['required', 'string', 'max:255'],
            'AssetSerialNum' => ['required', 'string', 'max:255'],
            'AssetTypeId' => ['required', 'integer', 'exists:assettypes,AssetTypeId'],
            'AssetDescription' => ['required', 'string', 'max:255'],
            'AssetDepartmentId' => ['required', 'integer', 'exists:departments,DepartmentId'],
            'AssetOrganizationId' => ['required', 'integer', 'exists:organizations,OrganizationId'],
            'AssetLocation' => ['required', 'string', 'max:255'],
            'AssetManagedBy' => ['required', 'integer', 'exists:staffs,StaffId'],
            'AssetPurchaseDate' => ['required', 'string', 'date'],
            'AssetWarrantyExpiryDate' => ['string', 'date'],
            'AssetServiceTypeId' => ['required', 'integer', 'exists:servicetypes,id'],
            'NumberOfServices' => ['required', 'integer'],
            'AssetImage' => ['file'],

        ]);

        $request->validate([
            'ServiceDate.*' => 'required|date',
        ]);

        if ($request->hasFile('AssetImage')) {
            $originalFileName = $request->AssetImage->getClientOriginalName();
            $request->AssetImage->move(public_path('uploads'), $originalFileName);
            $validatedData['AssetImage'] = $originalFileName;
        }

        try {
            $asset = Asset::where('AssetId', $AssetId)->first();
            $asset->update($validatedData);

            $getDate = Asset::where('AssetId', $AssetId)->value('ServiceDateId');
            $serviceDate = Servicedate::where('ServiceDateId',$getDate)->first();
            $serviceDates = $request->ServiceDate;
            for ($i = 0; $i < count($serviceDates); $i++) {
                $dateColumn = 'ServiceDate' . ($i + 1);
                if (isset($serviceDates[$i])) {
                    $serviceDate->$dateColumn = $serviceDates[$i];
                } else {
                    $serviceDate->$dateColumn = null;
                }
            }
            $serviceDate->save();

            return redirect()->route('assets.index')->with('success', 'Asset is Updated Successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($AssetId): RedirectResponse
    {
        try {
            $asset = Asset::where('AssetId', $AssetId)->first();
            $asset->delete();
            return redirect()->route('assets.index')->with('success', 'Asset is Deleted Successfully.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
        }
    }

}
