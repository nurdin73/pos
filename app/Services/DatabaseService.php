<?php
namespace App\Services;

use App\Helpers\CreatePaginationLink;
use App\Models\HistoryExportDb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\DbDumper\Databases\MySql;
use Illuminate\Support\Str;

class DatabaseService
{
    public function export($namefile)
    {
        $dumpname = Str::slug($namefile) . ".sql";
        $who = Auth::user()->name;
        $createHistory = HistoryExportDb::create([
            'whoExport' => $who,
            'nama_file' => $dumpname
        ]);
        if(!$createHistory) {
            return response()->json(['message' => 'terjadi kesalahan'], 500);
        }
        Mysql::create()
        ->setDbName(env('DB_DATABASE'))
        ->setUserName(env('DB_USERNAME'))
        ->setPassword(env('DB_PASSWORD'))
        ->dumpToFile($dumpname);
        // echo json_encode(['message' => 'Export Database berhasil']);
        return response(['message' => 'Export database berhasil']);
    }

    public function all($who, $rangeTime, $sorting)
    {
        $results = HistoryExportDb::select('*');
        if($who != "") {
            if($rangeTime != "") {
                $rangeExplode = explode(' - ', $rangeTime);
                $dateStart = $rangeExplode[0] . " 00:00:00";
                $dateEnd = $rangeExplode[1] . " 23:59:59";
                $results = $results->where('created_at', '>=', "$dateStart")->where('created_at', '<=', "$dateEnd")->where('created_at', 'like', "%$dateEnd%")->paginate($sorting);
            } else {
                $results = $results->where('whoExport', 'like', "%$who%")->paginate($sorting);
            }
        } elseif($rangeTime != "") {
            $rangeExplode = explode(' - ', $rangeTime);
            $dateStart = $rangeExplode[0] . " 00:00:00";
            $dateEnd = $rangeExplode[1] . " 23:59:59";
            $results = $results->where('created_at', '>=', "$dateStart")->where('created_at', '<=', "$dateEnd")->paginate($sorting);
        } else {
            $results = $results->paginate($sorting);
        }
        $createData = new CreatePaginationLink($results->getCollection(), $results->links(), $results->currentPage());
        return $createData->crafting();
    }
}