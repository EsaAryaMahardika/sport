<?php

namespace App\Http\Controllers;
use App\Models\provinsi;
use App\Models\kabupaten;
use App\Models\customer;
use App\Models\category;
use App\Models\factory;
use App\Models\materials;
use App\Models\product;
use App\Models\production;
use App\Models\purchase;
use App\Models\vendor;
use App\Models\selling;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;

class DBController extends Controller
{
    function product() {
        $product = product::all();
        $category = category::all();
        $factory = factory::all();
        return view('product', compact('factory', 'product', 'category'));
    }
    function i_product(Request $request) {
        $currentTime = Carbon::now();
        $imageName = $request->file('foto')->getClientOriginalName();
        $path = $request->file('foto')->move(public_path('img'), $imageName);
        $filePath = pathinfo($path, PATHINFO_BASENAME);
        product::create([
            'nama' => $request->input('nama'),
            'category_id' => $request->input('category_id'),
            'harga' => $request->input('harga'),
            'factory_id' => $request->input('factory_id'),
            'foto' => $filePath,
            'created_at' =>$currentTime,
            'updated_at' =>$currentTime
        ]);
        Session::flash('success', 'Produk berhasil ditambahkan.');
        return redirect('/product');
    }
    function u_product(Request $request, $id) {
        $product = product::find($id);
        $currentTime = Carbon::now();
        if ($request->file('foto')) {
            $imageName = $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->move(public_path('img/'), $imageName);
            $filePath = pathinfo($path, PATHINFO_BASENAME);
            $product->update([
                'nama' => $request->input('nama'),
                'category_id' =>$request->input('category_id'),
                'harga' =>$request->input('harga'),
                'factory_id' =>$request->input('factory_id'),
                'foto' =>$filePath,
                'updated_at' =>$currentTime
            ]);
        } else {
            $product->update([
                'nama' => $request->input('nama'),
                'category_id' =>$request->input('category_id'),
                'harga' =>$request->input('harga'),
                'factory_id' =>$request->input('factory_id'),
                'updated_at' =>$currentTime
            ]);
        }
        Session::flash('success', 'Produk berhasil diubah');
        return redirect('/product');
    }
    function d_product($id) {
        $product = product::find($id);
        $product->delete();
        Session::flash('success', 'Produk berhasil dihapus.');
        return redirect('/product');
    }
    function factory() {
        $factory = factory::all();
        $prov = provinsi::all();
        $kab = kabupaten::all();
        return view('factory', compact('factory', 'prov', 'kab'));
    }
    function i_factory(Request $request) {
        factory::create($request->all());
        Session::flash('success', 'Pabrik berhasil ditambahkan.');
        return redirect('/factory');
    }
    function u_factory(Request $request, $id) {
        $factory = factory::find($id);
        $factory->update($request->all());
        Session::flash('success', 'Pabrik berhasil diubah.');
        return redirect('/factory');
    }
    function d_factory($id) {
        $factory = factory::find($id);
        $factory->delete();
        Session::flash('success', 'Pabrik berhasil dihapus.');
        return redirect('/factory');
    }
    function materials() {
        $materials = materials::all();
        return view('materials', compact('materials'));
    }
    function i_materials(Request $request) {
        materials::create($request->all());
        Session::flash('success', 'Bahan Baku berhasil ditambahkan.');
        return redirect('/materials');
    }
    function u_materials(Request $request, $id) {
        $materials = materials::find($id);
        $materials->update($request->all());
        Session::flash('success', 'Bahan Baku berhasil diubah.');
        return redirect('/materials');
    }
    function d_materials($id) {
        $materials = materials::find($id);
        $materials->delete();
        Session::flash('success', 'Bahan Baku berhasil dihapus.');
        return redirect('/materials');
    }
    function component() {
        $product = product::with('materials')->get();
        $materials = materials::all();
        return view('component', compact('materials', 'product'));
    }
    function i_component(Request $request) {
        $productID = $request->input('product_id');
        $materialsID = $request->input('materials_id');
        $jumlahMaterials = $request->input('jumlah');
        $product = product::find($productID);
        $sync_data = [];
        for($i = 0; $i < count($materialsID); $i++){
            $sync_data[$materialsID[$i]] = ['jumlah' => $jumlahMaterials[$i]];
        }
        $product->materials()->sync($sync_data);
        $product->update([
            'harga' =>$request->input('harga'),
        ]);
        Session::flash('success', 'Komposisi berhasil ditambahkan.');
        return redirect('/component');
    }
    function d_component($id) {
        $product = product::find($id);
        $product->materials()->detach();
        Session::flash('success', 'Komposisi berhasil dihapus.');
        return redirect('/component');
    }
    function category() {
        $category = category::all();
        return view('category', compact('category'));
    }
    function i_category(Request $request) {
        category::create($request->all());
        Session::flash('success', 'Kategori berhasil ditambahkan.');
        return redirect('/category');
    }
    function u_category(Request $request, $id) {
        $category = category::find($id);
        $category->update($request->all());
        Session::flash('success', 'Kategori berhasil diubah.');
        return redirect('/category');
    }
    function d_category($id) {
        $category = category::find($id);
        $category->delete();
        Session::flash('success', 'Kategori berhasil dihapus.');
        return redirect('/category');
    }
    function production() {
        $production = production::with('product')->get();
        $product = product::all();
        return view('production', compact('production', 'product'));
    }
    function i_production(Request $request) {
        production::create($request->all());
        Session::flash('success', 'Produk berhasil masuk antrean.');
        return redirect('/production');
    }
    function start($id) {
        $production = production::find($id);
        $production->update([
            'status' => 'start'
        ]);
        Session::flash('success', 'Produksi telah dimulai.');
        return redirect('/production');
    }
    function mad(Request $request, $id) {
        // MENGUBAH STATUS PRODUCTION
        $production = production::find($id);
        $currentTime = Carbon::now();
        $production->update([
            'status' => 'finish',
            'selesai' => $currentTime
        ]);
        // MENGURANGI STOK MATERIALS
        $stokM = $request->input('stokM');
        $materialIds = $request->input('materials_id');
        foreach ($materialIds as $key => $materialId) {
            $material = materials::find($materialId);
            $material->update([
                'stok' => $stokM[$key]
            ]);
        }
        // MENAMBAH STOK PRODUCT
        $product = product::find($request->input('product_id'));
        $product->update([
            'stok' => $request->input('stokP')
        ]);
        Session::flash('success', 'Produksi telah selesai.');
        return redirect('/production');
    }
    function r_production($id) {
        $production = production::find($id);
        return view('production', compact('production'));
    }
    function purchase() {
        
    }
    function i_purchase(Request $request) {
        
    }
    function u_purchase(Request $request) {
        
    }
    function d_purchase($id) {
        
    }
    function vendor() {
        
    }
    function i_vendor(Request $request) {
        
    }
    function u_vendor(Request $request) {
        
    }
    function d_vendor($id) {
        
    }
    function customer() {
        $prov = provinsi::all();
        $customer = customer::all();
        return view('customer', compact('prov', 'customer'));
    }
    function i_customer(Request $request) {
        
    }
    function u_customer(Request $request) {
        
    }
    function d_customer($id) {
        
    }
    function selling() {

    }
    function i_selling(Request $request) {
        
    }
    function u_selling(Request $request) {
        
    }
    function d_selling($id) {
        
    }
    public function kab($id)
    {
        $data = kabupaten::where('prov_id', $id)->pluck('nama', 'id')->toArray();
        return response()->json($data);
    }
}
