<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;

class TransaksiController extends BaseController
{
    public function index(){
        return view('index', ['template' => 'transaksi.index']);
    }

    public function store(Request $request)
    {
        $transaksi = Transaksi::updateOrCreate(
            [
            'id' => $request->input('id')
            ],
            [
            'kategori_id' => $request->input('kategori_id'),
            'tanggal' => $request->input('tanggal'),
            'jumlah' => $request->input('jumlah'),
            'deskripsi' => $request->input('deskripsi'),
            'tipe' => $request->input('tipe') ?? 1,
            'created_by' => auth()->user()->id,
            ]
        );

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil disimpan'], 200);
    }

    public function destroy($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil dihapus'], 200);
    }
    
    public function dataTable(Request $request)
    {
        $transactions = Transaksi::with(['kategori']);

        switch ($request->periode) {
            case 'weekly':
                $transactions = $transactions->whereBetween('tanggal', [now()->subDays(28)->startOfDay(), now()->endOfDay()]);
                break;

            case 'monthly':
                $transactions = $transactions->whereBetween('tanggal', [now()->subMonths(6)->startOfMonth(), now()->endOfMonth()]);
                break;
            default:            
                $transactions = $transactions->whereBetween('tanggal', [now()->subDays(6)->startOfDay(), now()->endOfDay()]);
                break;
        }

        $transactions = $transactions->where('created_by', auth()->user()->id);

        if ($request->tipe AND $request->tipe != 'all') {
            $transactions->where('tipe', $request->tipe);
        }
        
        if ($request->search) {
            $transactions->where('deskripsi', 'like', "%{$request->search}%");
        }        

        $summary = $transactions;
        $summary = $summary->get();

        $transactions = $transactions->orderBy('tanggal', 'desc')->get()->groupBy(function($item) {
            return $item->tanggal;
        });

        $pemasukan = $summary->where('tipe', 1)->sum('jumlah');
        $pengeluaran = $summary->where('tipe', 2)->sum('jumlah');
        $summary = [
            'pemasukan' => number_format($pemasukan),
            'pengeluaran' => number_format($pengeluaran),
            'saldo' => number_format($pemasukan - $pengeluaran),
        ];

        return response()->json(
            [
                'transaksi' => $transactions,
                'summary' => $summary
            ]
        );

        $transactions = $transactions->orderBy('id', 'desc')->paginate(5);
        
        $transformed = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'receipt_number' => $transaction->receipt_number,
                'transaction_date' => date('D, d M Y H:i:s', strtotime($transaction->transaction_date)),
                'total_price' => $transaction->total_price,
                'created_name' => $transaction->user->name,
                'details' => $transaction->details->map(function ($detail) {
                    return [
                        'id' => $detail->id,
                        'product_name' => $detail->product->name,
                        'category_name' => $detail->product->category->name ?? 'non category',
                        'qty' => $detail->qty,
                        'unit_price' => $detail->unit_price,
                        'subtotal' => $detail->subtotal,
                    ];
                }),
            ];
        });

        return response()->json([
            'data' => $transformed,
            'summary'=> $summary,
            'current_page' => $transactions->currentPage(),
            'last_page' => $transactions->lastPage(),
            'per_page' => $transactions->perPage(),
            'total' => $transactions->total()
        ]);
            
        return response()->json($transactions);
    }

    public function Chart($tipe, $periode)
    {
        switch ($periode) {
            case 'daily':
            $pemasukan = Transaksi::select(
                DB::raw('DATE(tanggal) as periode'),
                DB::raw('SUM(jumlah) as jumlah')
            )
                ->where('tipe', 1)
                ->whereBetween('tanggal', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                ->where('created_by', auth()->user()->id)
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy(DB::raw('DATE(tanggal)'))
                ->get();

            $pengeluaran = Transaksi::select(
                DB::raw('DATE(tanggal) as periode'),
                DB::raw('SUM(jumlah) as jumlah')
            )
                ->where('tipe', 2)
                ->whereBetween('tanggal', [now()->subDays(6)->startOfDay(), now()->endOfDay()])
                ->where('created_by', auth()->user()->id)
                ->groupBy(DB::raw('DATE(tanggal)'))
                ->orderBy(DB::raw('DATE(tanggal)'))
                ->get();

            $periods = collect();
            for ($i = 6; $i >= 0; $i--) {
                $periods->push(now()->subDays($i)->toDateString());
            }

            $pemasukan = $periods->map(function ($date) use ($pemasukan) {
                $item = $pemasukan->firstWhere('periode', $date);
                return [
                    'periode' => $date,
                    'jumlah' => $item ? $item->jumlah : 0,
                ];
            });

            $pengeluaran = $periods->map(function ($date) use ($pengeluaran) {
                $item = $pengeluaran->firstWhere('periode', $date);
                return [
                    'periode' => $date,
                    'jumlah' => $item ? $item->jumlah : 0,
                ];
            });

            $transactions = [
                'pemasukan' => $pemasukan,
                'pengeluaran' => $pengeluaran,
            ];
            break;

            case 'weekly':
                $pemasukan = Transaksi::select(
                    DB::raw('WEEK(tanggal) as periode'),
                    DB::raw('SUM(jumlah) as jumlah')
                )
                    ->where('tipe', 1)
                    ->whereBetween('tanggal', [now()->subDays(28)->startOfDay(), now()->endOfDay()])
                    ->where('created_by', auth()->user()->id)
                    ->groupBy(DB::raw('WEEK(tanggal)'))
                    ->orderBy(DB::raw('WEEK(tanggal)'))
                    ->get();

                $pengeluaran = Transaksi::select(
                    DB::raw('WEEK(tanggal) as periode'),
                    DB::raw('SUM(jumlah) as jumlah')
                )
                    ->where('tipe', 2)
                    ->whereBetween('tanggal', [now()->subDays(28)->startOfDay(), now()->endOfDay()])
                    ->where('created_by', auth()->user()->id)
                    ->groupBy(DB::raw('WEEK(tanggal)'))
                    ->orderBy(DB::raw('WEEK(tanggal)'))
                    ->get();

                $periods = collect();
                for ($i = 4; $i >= 0; $i--) {
                    $periods->push(now()->subWeeks($i)->weekOfYear);
                }

                $pemasukan = $periods->map(function ($week) use ($pemasukan) {
                    $item = $pemasukan->firstWhere('periode', $week);
                    return [
                        'periode' => $week,
                        'jumlah' => $item ? $item->jumlah : 0,
                    ];
                });

                $pengeluaran = $periods->map(function ($week) use ($pengeluaran) {
                    $item = $pengeluaran->firstWhere('periode', $week);
                    return [
                        'periode' => $week,
                        'jumlah' => $item ? $item->jumlah : 0,
                    ];
                });

                $transactions = [
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                ];
                break;

            case 'monthly':
                $pemasukan = Transaksi::select(
                    DB::raw('DATE_FORMAT(tanggal, "%b") as periode'),
                    DB::raw('SUM(jumlah) as jumlah')
                )
                    ->where('tipe', 1)
                    ->whereBetween('tanggal', [now()->subMonths(6)->startOfMonth(), now()->endOfMonth()])                    
                    ->where('created_by', auth()->user()->id)
                    ->groupBy(DB::raw('DATE_FORMAT(tanggal, "%b")'))
                    ->orderBy(DB::raw('MIN(tanggal)'))
                    ->get();

                $pengeluaran = Transaksi::select(
                    DB::raw('DATE_FORMAT(tanggal, "%b") as periode'),
                    DB::raw('SUM(jumlah) as jumlah')
                )
                    ->where('tipe', 2)
                    ->whereBetween('tanggal', [now()->subMonths(6)->startOfMonth(), now()->endOfMonth()])                    
                    ->where('created_by', auth()->user()->id)
                    ->groupBy(DB::raw('DATE_FORMAT(tanggal, "%b")'))
                    ->orderBy(DB::raw('MIN(tanggal)'))
                    ->get();

                $periods = collect();
                for ($i = 5; $i >= 0; $i--) {
                    $periods->push(now()->subMonths($i)->format('M'));
                }

                $pemasukan = $periods->map(function ($month) use ($pemasukan) {
                    $item = $pemasukan->firstWhere('periode', $month);
                    return [
                        'periode' => $month,
                        'jumlah' => $item ? $item->jumlah : 0,
                    ];
                });

                $pengeluaran = $periods->map(function ($month) use ($pengeluaran) {
                    $item = $pengeluaran->firstWhere('periode', $month);
                    return [
                        'periode' => $month,
                        'jumlah' => $item ? $item->jumlah : 0,
                    ];
                });

                $transactions = [
                    'pemasukan' => $pemasukan,
                    'pengeluaran' => $pengeluaran,
                ];
                break;
        }
        $labels = $transactions['pemasukan']->pluck('periode')->toArray();
        $pemasukanData = $transactions['pemasukan']->pluck('jumlah')->toArray();
        $pengeluaranData = $transactions['pengeluaran']->pluck('jumlah')->toArray();
        $data = [
            'labels' => $labels,
            'pemasukan' => $pemasukanData,
            'pengeluaran' => $pengeluaranData
        ];
        return response()->json($data);
    }
}
