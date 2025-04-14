<?php

namespace App\Jobs;

use App\Exports\ProductsExport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class ExportProductsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $filename = 'exports/products_' . now()->format('Ymd_His') . '.xlsx';
        Excel::store(new ProductsExport, $filename, 'local');
    }
}
