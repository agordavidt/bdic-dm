<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VendorInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:vendor']);
    }

    /**
     * Display inventory management page (FR_ECO_004)
     */
    public function index(Request $request)
    {
        $query = Product::where('vendor_id', Auth::id())->with('category');

        // Filter by stock level
        if ($request->filled('stock_filter')) {
            switch ($request->stock_filter) {
                case 'low_stock':
                    $query->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0);
                    break;
                case 'out_of_stock':
                    $query->where('stock_quantity', 0);
                    break;
                case 'overstocked':
                    $query->where('stock_quantity', '>', 100);
                    break;
            }
        }

        $products = $query->latest()->paginate(20);

        $stats = [
            'total_items' => Product::where('vendor_id', Auth::id())->sum('stock_quantity'),
            'low_stock_items' => Product::where('vendor_id', Auth::id())->where('stock_quantity', '<=', 10)->where('stock_quantity', '>', 0)->count(),
            'out_of_stock_items' => Product::where('vendor_id', Auth::id())->where('stock_quantity', 0)->count(),
            'total_value' => Product::where('vendor_id', Auth::id())->selectRaw('SUM(price * stock_quantity)')->value('SUM(price * stock_quantity)') ?? 0,
        ];

        return view('vendor.inventory.index', compact('products', 'stats'));
    }

    /**
     * Update individual product stock (FR_ECO_004)
     */
    public function updateStock(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validate([
            'stock_quantity' => 'required|integer|min:0',
            'reason' => 'nullable|string|max:255',
        ]);

        $oldStock = $product->stock_quantity;
        $product->update(['stock_quantity' => $validated['stock_quantity']]);

        // Log the stock change if needed
        // StockMovement::create([
        //     'product_id' => $product->id,
        //     'old_quantity' => $oldStock,
        //     'new_quantity' => $validated['stock_quantity'],
        //     'change_type' => $validated['stock_quantity'] > $oldStock ? 'increase' : 'decrease',
        //     'reason' => $validated['reason'] ?? 'Manual adjustment',
        //     'user_id' => Auth::id(),
        // ]);

        return back()->with('success', 'Stock updated successfully.');
    }

    /**
     * Bulk update stock quantities (FR_ECO_004)
     */
    public function bulkUpdate(Request $request)
    {
        $validated = $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.stock_quantity' => 'required|integer|min:0',
        ]);

        $updated = 0;

        foreach ($validated['products'] as $productData) {
            $product = Product::where('id', $productData['id'])
                ->where('vendor_id', Auth::id())
                ->first();

            if ($product) {
                $product->update(['stock_quantity' => $productData['stock_quantity']]);
                $updated++;
            }
        }

        return back()->with('success', "Updated stock for {$updated} products.");
    }

    /**
     * Get low stock alerts (AJAX)
     */
    public function alerts()
    {
        $lowStockProducts = Product::where('vendor_id', Auth::id())
            ->where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->get(['id', 'name', 'stock_quantity', 'sku']);

        $outOfStockProducts = Product::where('vendor_id', Auth::id())
            ->where('stock_quantity', 0)
            ->get(['id', 'name', 'sku']);

        return response()->json([
            'low_stock' => $lowStockProducts,
            'out_of_stock' => $outOfStockProducts,
        ]);
    }

    /**
     * Get low stock products count (AJAX)
     */
    public function lowStock()
    {
        $count = Product::where('vendor_id', Auth::id())
            ->where('stock_quantity', '<=', 10)
            ->where('stock_quantity', '>', 0)
            ->count();

        return response()->json(['count' => $count]);
    }
} 