<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Assettype;
use Exception;

class AssettypeController extends Controller
{

	public function create(): View
	{
		return view('assets.assettype', [
			'assettypes' => Assettype::paginate(10),
		]);
	}

	public function store(Request $request): RedirectResponse
	{
		$input = $request->validate([
			'AssetTypeName' => "required|string|max:255"
		]);

		try {
			Assettype::create($input);
			return redirect()->route('assets.create')
				->with('success', 'New Asset Type is Added Successfully.');
		} catch (Exception $e) {
			return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
		}
	}

	public function edit(Request $request, $AssetTypeId): View
	{
		$assettype = Assettype::where('AssetTypeId', $AssetTypeId)->first();
		return view('assets.editassettype', compact('assettype'));
	}

	public function update(Request $request, $AssetTypeId): RedirectResponse
	{
		$input = $request->validate([
			'AssetTypeName' => "required|string|max:255"
		]);
		try {
			$assettype = Assettype::where('AssetTypeId', $AssetTypeId)->first();
			$assettype->update($input);
			return redirect()->route('assettype.create')
				->with('success', 'Asset Type is updated Successfully.');
		} catch (Exception $e) {
			return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
		}
	}
	public function destroy($AssetTypeId): RedirectResponse
	{
		try {
			$assettype = Assettype::where('AssetTypeId', $AssetTypeId)->first();
			$assettype->delete();
			return redirect()->route('assettype.create')->with('success', 'Asset Type is Deleted Successfully.');
		} catch (Exception $e) {
			return back()->with('error', 'Error: ' . $e->getMessage())->withInput();
		}
	}
}
