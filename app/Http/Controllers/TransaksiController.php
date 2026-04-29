<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return Transaksi::with('user')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'status' => 'required|string|max:50',
        ]);

        $transaksi = $request->user()->transaksis()->create($data);

        return response()->json($transaksi->load('user'), 201);
    }

    public function show(Transaksi $transaksi)
    {
        $this->authorizeCustomerOwnership($transaksi, request()->user());

        return $transaksi->load('user');
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $this->authorizeCustomerOwnership($transaksi, $request->user());

        $data = $request->validate([
            'product_name' => 'sometimes|required|string|max:255',
            'quantity' => 'sometimes|required|integer|min:1',
            'total' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|string|max:50',
        ]);

        $transaksi->update($data);

        return $transaksi->load('user');
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return response()->json(['message' => 'Transaksi deleted successfully.'], 200);
    }

    private function authorizeCustomerOwnership(Transaksi $transaksi, $user): void
    {
        if ($transaksi->user_id !== $user->id) {
            abort(403, 'Forbidden: you may only access your own transaksi.');
        }
    }
}
