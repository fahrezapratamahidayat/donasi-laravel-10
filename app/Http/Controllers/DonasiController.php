<?php

namespace App\Http\Controllers;

use App\Models\Donasi;
use App\Models\DonasiDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DonasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Donasi::with(['user', 'donasiDetail'])
            ->where('status', 'active')
            ->where('is_verified', true);

        // Handle search
        if ($request->has('search')) {
            $query->where('judul_donasi', 'like', '%' . $request->search . '%');
        }

        // Handle sorting
        switch ($request->sort) {
            case 'oldest':
                $query->oldest();
                break;
            case 'target_asc':
                $query->orderBy('target_donasi', 'asc');
                break;
            case 'target_desc':
                $query->orderBy('target_donasi', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        $campaigns = $query->paginate(9);

        return view('donasi.index', compact('campaigns'));
    }

    public function create()
    {
        return view('donasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_donasi' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'target_donasi' => 'required|numeric|min:10000',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_berakhir' => 'required|date|after:tanggal_mulai',
            'gambar' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $gambarPath = $gambar->storeAs(
                'public/donasi-images',
                time() . '_' . $gambar->getClientOriginalName()
            );
            $gambarPath = str_replace('public/', '', $gambarPath);
        }

        $donasi = Donasi::create([
            'judul_donasi' => $request->judul_donasi,
            'deskripsi' => $request->deskripsi,
            'target_donasi' => $request->target_donasi,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_berakhir' => $request->tanggal_berakhir,
            'gambar' => $gambarPath,
            'created_by' => auth()->id(),
            'status' => 'pending'
        ]);

        return redirect()
            ->route('donasi.my')
            ->with('success', 'Campaign donasi berhasil dibuat dan menunggu verifikasi admin');
    }

    public function show($id)
    {
        $donasi = Donasi::with(['donasiDetail', 'user'])
            ->findOrFail($id);

        return view('donasi.show', compact('donasi'));
    }

    public function myDonasi()
    {
        $donasi = Donasi::with(['donasiDetail'])
            ->where('created_by', auth()->id())
            ->latest()
            ->paginate(10);

        return view('donasi.my', compact('donasi'));
    }

    public function donate(Request $request, $id)
    {
        $request->validate([
            'jumlah_donasi' => 'required|numeric|min:10000',
            'nama_donatur' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:280',
            'is_anonymous' => 'nullable|boolean'
        ]);

        $donasi = Donasi::findOrFail($id);

        // generated order id
        $orderId = 'DON-' . Str::random(5) . '-' . time();

        $donasiDetail = DonasiDetail::create([
            'order_id' => $orderId,
            'donasi_id' => $donasi->id,
            'user_id' => auth()->id(),
            'nama_donatur' => $request->is_anonymous ? 'Anonim' : $request->nama_donatur,
            'jumlah_donasi' => $request->jumlah_donasi,
            'keterangan' => $request->keterangan,
            'status_pembayaran' => 'pending'
        ]);

        // midtrans config
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $request->jumlah_donasi
            ],
            'customer_details' => [
                'first_name' => $request->is_anonymous ? 'Anonim' : $request->nama_donatur,
                'email' => auth()->user()->email
            ],
            'item_details' => [
                [
                    'id' => $donasi->id,
                    'price' => $request->jumlah_donasi,
                    'quantity' => 1,
                    'name' => "Donasi untuk {$donasi->judul_donasi}"
                ]
            ]
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $donasiDetail->update(['snap_token' => $snapToken]);

            if (config('app.env') === 'local') {
                // simulasi webhook untuk testing di development
                $simulatedNotification = [
                    'transaction_status' => 'settlement',
                    'payment_type' => 'bank_transfer',
                    'order_id' => $orderId,
                    'gross_amount' => $request->jumlah_donasi,
                ];

                // update payment details langsung untuk development
                $donasiDetail->update([
                    'status_pembayaran' => 'settlement',
                    'payment_type' => 'bank_transfer',
                    'payment_details' => json_encode($simulatedNotification)
                ]);

                // update total donasi
                $donasi->increment('donasi_terkumpul', $request->jumlah_donasi);

                // Log untuk debugging
                Log::info('Development mode: Donasi berhasil diupdate', [
                    'order_id' => $orderId,
                    'amount' => $request->jumlah_donasi,
                    'total_terkumpul' => $donasi->fresh()->donasi_terkumpul
                ]);
            }

            return redirect()->back()->with('snap_token', $snapToken);
        } catch (\Exception $e) {
            Log::error('Payment Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran');
        }
    }

    public function payment($id, Request $request)
    {
        $donasi = Donasi::findOrFail($id);
        $amount = $request->query('amount');

        if (!$amount || $amount < 10000) {
            return redirect()->back()->with('error', 'Nominal donasi tidak valid');
        }

        return view('donasi.payment', compact('donasi', 'amount'));
    }

    public function amount($id)
    {
        $donasi = Donasi::findOrFail($id);
        return view('donasi.amount', compact('donasi'));
    }

    public function handleWebhook(Request $request)
    {
        try {
            $notification = json_decode($request->getContent(), true);

            if (!$notification) {
                throw new \Exception('Invalid notification data');
            }

            $orderId = $notification['order_id'];
            $transactionStatus = $notification['transaction_status'];
            $paymentType = $notification['payment_type'] ?? null;

            $donasiDetail = DonasiDetail::where('order_id', $orderId)->firstOrFail();

            // Update payment details
            $donasiDetail->payment_type = $paymentType;
            $donasiDetail->payment_details = json_encode($notification);

            if ($transactionStatus == 'settlement' || $transactionStatus == 'capture') {
                $donasiDetail->status_pembayaran = 'settlement';

                // Update total donasi terkumpul
                $donasi = $donasiDetail->donasi;
                $donasi->increment('donasi_terkumpul', $donasiDetail->jumlah_donasi);

                // Log untuk debugging
                Log::info('Donasi berhasil diupdate', [
                    'order_id' => $orderId,
                    'amount' => $donasiDetail->jumlah_donasi,
                    'total_terkumpul' => $donasi->donasi_terkumpul
                ]);
            } else if ($transactionStatus == 'pending') {
                $donasiDetail->status_pembayaran = 'pending';
            } else {
                $donasiDetail->status_pembayaran = 'failed';
            }

            $donasiDetail->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('Webhook error: ' . $e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
