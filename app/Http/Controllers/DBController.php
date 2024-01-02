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
use App\Models\sales;
use App\Models\PurchaseList;
use App\Models\SalesList;

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
        return view('reportPC', compact('production'));
    }
    function purchase() {
        $vendor = vendor::all();
        $materials = materials::all();
        $purchase = purchase::with('materials')->get();
        return view('purchase', compact('materials', 'vendor', 'purchase'));
    }
    function i_purchase(Request $request) {
        $purchase = purchase::create([
            'vendor_id' => $request->input('vendor_id'),
            'total' => $request->input('total'),
            'status' => 'PO'
        ]);
        $materialsID = $request->input('materials_id');
        $jumlahMaterials = $request->input('jumlah');
        $sync_data = [];
        for($i = 0; $i < count($materialsID); $i++){
            $sync_data[$materialsID[$i]] = ['jumlah' => $jumlahMaterials[$i]];
        }
        $purchase->materials()->attach($sync_data);
        Session::flash('success', 'Pemesanan berhasil dibuat.');
        return redirect('/purchase');
    }
    function confirm($id) {
        $purchase = purchase::find($id);
        $currentTime = Carbon::now();
        $purchase->update([
            'status' => 'confirm',
            'updated_at' => $currentTime
        ]);
        Session::flash('success', 'Barang telah dikonfirmasi.');
        return redirect('/purchase');
    }
    function payment(Request $request, $id) {
        $purchase = purchase::find($id);
        $currentTime = Carbon::now();
        $purchase->update([
            'pembayaran' => $request->input('pembayaran'),
            'status' => 'payment',
            'updated_at' => $currentTime
        ]);
        $purchase_id = $purchase->id;
        // Dapatkan data produk yang dibeli dari tabel pivot 'purchaselist'
        $purchaselist = Purchaselist::where('purchase_id', $purchase_id)->get();
        // Loop untuk setiap produk yang dibeli dalam pembelian
        foreach ($purchaselist as $item) {
            $materials_id = $item->materials_id;
            $jumlah = $item->jumlah;
            // Temukan produk sesuai dengan ID
            $materials = materials::find($materials_id);
            // Pastikan produk ditemukan
            if ($materials) {
                // Tambahkan jumlah produk ke dalam stok produk
                $materials->stok += $jumlah;
                $materials->save();
            }
        }
        Session::flash('success', 'Barang telah dibayar.');
        return redirect('/purchase');
    }
    function invoicePurchase($id) {
        $purchase = purchase::find($id);
        return view('invoice', compact('purchase'));
    }
    function vendor() {
        $vendor = vendor::all();
        $prov = provinsi::all();
        return view('vendor', compact('vendor', 'prov'));
    }
    function i_vendor(Request $request) {
        vendor::create($request->all());
        Session::flash('success', 'Pemasok berhasil ditambahkan.');
        return redirect('/vendor');
    }
    function u_vendor(Request $request, $id) {
        $vendor = vendor::find($id);
        $vendor->update($request->all());
        Session::flash('success', 'Pemasok berhasil diubah.');
        return redirect('/vendor');
    }
    function d_vendor($id) {
        $vendor = vendor::find($id);
        $vendor->delete();
        Session::flash('success', 'Pemasok berhasil dihapus.');
        return redirect('/vendor');
    }
    function customer() {
        $prov = provinsi::all();
        $customer = customer::all();
        return view('customer', compact('prov', 'customer'));
    }
    function i_customer(Request $request) {
        customer::create($request->all());
        Session::flash('success', 'Konsumen berhasil ditambahkan.');
        return redirect('/customer');
    }
    function u_customer(Request $request, $id) {
        $customer = customer::find($id);
        $customer->update($request->all());
        Session::flash('success', 'Konsumen berhasil diubah.');
        return redirect('/customer');
    }
    function d_customer($id) {
        $customer = customer::find($id);
        $customer->delete();
        Session::flash('success', 'Konsumen berhasil dihapus.');
        return redirect('/customer');
    }
    function sales() {
        $customer = customer::all();
        $product = product::all();
        $sales = sales::with('product')->get();
        return view('sales', compact('sales', 'product', 'customer'));
    }
    function i_sales(Request $request) {
        $sales = sales::create([
            'customer_id' => $request->input('customer_id'),
            'total' => $request->input('total'),
            'status' => 'order'
        ]);
        $productID = $request->input('product_id');
        $jumlahProduct = $request->input('jumlah');
        $sync_data = [];
        for($i = 0; $i < count($productID); $i++){
            $sync_data[$productID[$i]] = ['jumlah' => $jumlahProduct[$i]];
        }
        $sales->product()->attach($sync_data);
        Session::flash('success', 'Pesanan berhasil dibuat.');
        return redirect('/sales');
    }
    function pay(Request $request, $id) {
        $sales = sales::find($id);
        $currentTime = Carbon::now();
        $sales->update([
            'pembayaran' => $request->input('pembayaran'),
            'status' => 'pay',
            'updated_at' => $currentTime
        ]);
        Session::flash('success', 'Pembayaran telah dikonfirmasi.');
        return redirect('/sales');
    }
    function delivery($id) {
        $sales = sales::find($id);
        $currentTime = Carbon::now();
        $sales->update([
            'status' => 'delivery',
            'updated_at' => $currentTime
        ]);
        $sales_id = $sales->id;
        // Dapatkan data produk yang dibeli dari tabel pivot 'purchaselist'
        $saleslist = SalesList::where('sales_id', $sales_id)->get();
        // Loop untuk setiap produk yang dibeli dalam pembelian
        foreach ($saleslist as $item) {
            $product_id = $item->product_id;
            $jumlah = $item->jumlah;
            // Temukan produk sesuai dengan ID
            $product = product::find($product_id);
            // Pastikan produk ditemukan
            if ($product) {
                // Tambahkan jumlah produk ke dalam stok produk
                $product->stok -= $jumlah;
                $product->save();
            }
        }
        Session::flash('success', 'Barang telah dikirim.');
        return redirect('/sales');
    }
    function cancel($id) {
        $sales = sales::find($id);
        $sales->product()->detach();
        Session::flash('success', 'Pesanan berhasil dibatalkan.');
        return redirect('/sales');
    }
    function struct($id) {
        $sales = sales::find($id);
        return view('struct', compact('sales'));
    }
    public function kab($id)
    {
        $data = kabupaten::where('prov_id', $id)->pluck('nama', 'id')->toArray();
        return response()->json($data);
    }
}
