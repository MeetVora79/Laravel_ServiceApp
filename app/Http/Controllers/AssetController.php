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
use App\Models\Servicetype;
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
            'AssetServiceTypeId' => ['required', 'integer', 'exists:servicetypes,id'],
            'AssetWarrantyExpiryDate' => ['string', 'date'],
            'AssetImage' => ['file'],

        ]);

        if ($request->hasFile('AssetImage')) {
            $fileName = time() . '.' . $request->AssetImage->extension();
            $request->AssetImage->move(public_path('uploads'), $fileName);
            $validatedData['AssetImage'] = $fileName;
        }

        Asset::create($validatedData);
        return redirect()->route('assets.index')
            ->with('success', 'Asset is Created Successfully.');
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
    public function edit($AssetId): View
    {
        $asset = Asset::where('AssetId', $AssetId)->first();
        return view('assets.edit', compact('asset'), [
            'assettypes' => Assettype::select('AssetTypeId', 'AssetTypeName')->get(),
            'assetdepartments' => Department::select('DepartmentId', 'DepartmentName')->get(),
            'assetorganizations' => Organization::select('OrganizationId', 'OrganizationName')->get(),
            'customers' => Customer::select('CustomerId', 'firstname', 'lastname')->get(),
            'staffs' => Staff::select('StaffId', 'StaffName')->get(),
            'services' => Servicetype::select('ServiceDesc', 'id')->get(),
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
            'AssetServiceTypeId' => ['required', 'integer', 'exists:servicetypes,id'],
            'AssetWarrantyExpiryDate' => ['string', 'date'],
            'AssetImage' => ['file'],

        ]);

        if ($request->hasFile('AssetImage')) {
            $fileName = time() . '.' . $request->AssetImage->extension();
            $request->AssetImage->move(public_path('uploads'), $fileName);
            $validatedData['AssetImage'] = $fileName;
        }

        $asset = Asset::where('AssetId', $AssetId)->first();
        $asset->AssetCusId = $request->AssetCusId;
        $asset->AssetName = $request->AssetName;
        $asset->AssetSerialNum = $request->AssetSerialNum;
        $asset->AssetTypeId = $request->AssetTypeId;
        $asset->AssetDescription = $request->AssetDescription;
        $asset->AssetDepartmentId = $request->AssetDepartmentId;
        $asset->AssetOrganizationId = $request->AssetOrganizationId;
        $asset->AssetLocation = $request->AssetLocation;
        $asset->AssetManagedBy = $request->AssetManagedBy;
        $asset->AssetPurchaseDate = $request->AssetPurchaseDate;
        $asset->AssetServiceTypeId = $request->AssetServiceTypeId;
        $asset->AssetWarrantyExpiryDate = $request->AssetWarrantyExpiryDate;
        $asset->AssetImage = $request->AssetImage;
        $asset->update($validatedData);


        if (empty($request->from)) {
            return redirect()->route('assets.index')
                ->with('success','Asset is Updated Successfully.');
        } else {
            return redirect()->route('assets.edit')
                ->with('error','Something went WWrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($AssetId): RedirectResponse
    {
        $asset = Asset::where('AssetId', $AssetId)->first();
        $asset->delete();
        return redirect()->route('assets.index')->with('success','Asset is Deleted Successfully.');
    }


    /**
     * Functios for AssetType
     */

    public function assetType(): View
    {
        return view('assets.assettype');
    }

    public function storeAssetType(Request $request): RedirectResponse
    {
        $input = $request->validate([
            'AssetTypeName' => "required|string|max:255"
        ]);
        Assettype::create($input);

        return redirect()->route('assets.create')
            ->with('success','New Asset Type is Added Successfully.');
    }


}
