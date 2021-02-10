<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use DB;
use Auth;
use View;
use Carbon\Carbon;
class NewDataNotification
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::check()){
            $new = [];
            switch (session()->get('nama_jabatan')) {
                case 'Kaprog':
                    $new = DB::table('submissions')
                    ->where([
                        ['status','not like','ACC-B%'],
                        ['id_pengaju','=',Auth::user()->nip],
                    ])
                    ->orderBy('submissions.updated_at', 'desc')
                    ->get();
                    break;
                case 'Staf BOS':
                    $new = DB::table('submissions')
                    ->join('transaksi','transaksi.id_transaksi','=','submissions.id_transaksi')
                    ->where([
                        ['submissions.status','like','ACC-B%'],
                    ])
                    ->orWhere([
                        ['submissions.status','not like','ACC-1%'],
                        ['submissions.id_pengaju','=',Auth::user()->nip],
                    ])
                    ->orWhere([
                        ['submissions.status','like','ACC-3%'],
                        ['transaksi.id_dana','=','BOS'],
                    ])
                    ->orderBy('submissions.updated_at', 'desc')
                    ->get();
                    break;
                case 'Staf APBD':
                    $new = DB::table('submissions')
                    ->join('transaksi','transaksi.id_transaksi','=','submissions.id_transaksi')
                    ->where([
                        ['submissions.status','like','ACC-A%'],
                    ])
                    ->orWhere([
                        ['submissions.status','not like','ACC-1%'],
                        ['submissions.id_pengaju','=',Auth::user()->nip],
                    ])
                    ->orWhere([
                        ['submissions.status','like','ACC-3%'],
                        ['transaksi.id_dana','=','APBD'],
                    ])
                    ->orderBy('submissions.updated_at', 'desc')
                    ->get();
                    break;
                case 'Kepala Keuangan':
                    $new = DB::table('submissions')
                    ->where([
                            ['status','like','ACC-1%'],
                    ])
                    ->orWhere([
                            ['status','like','ACC-3%'],
                    ])
                    ->orderBy('submissions.updated_at', 'desc')
                    ->get();
                    break;
                 case 'Kepala Sekolah':
                    $new = DB::table('submissions')
                    ->where([
                            ['status','like','ACC-2%'],
                    ])
                    ->orWhere([
                            ['status','like','ACC-3%'],
                    ])
                    ->orderBy('submissions.updated_at', 'desc')
                    ->get();
                    break;
                case 'Admin':
                    $new = DB::table('accounts')
                    ->join('detail_accounts','detail_accounts.nip','=','accounts.nip')
                    ->where('accounts.nip','!=',Auth::user()->nip)
                    ->whereBetween('accounts.last_seen', [Carbon::now()->addHours(-24), Carbon::now()])
                    ->select('accounts.status','accounts.updated_at','accounts.last_seen','detail_accounts.nama')
                    ->orderBy('accounts.updated_at','desc')
                    ->get();
                    break;
                default:
                    $new = [];
                    break;
            }
            if(session()->get('notif') != null)
                $notif_now = count(session()->get('notif'));
            else
                $notif_now = 0;
            if($new != session()->get('notif') || count($new) > $notif_now){
                session([
                    'read_notif' => false,
                ]);
                session()->save();
            }
            View::share('notif', $new);
        }

        return $next($request);
    }
}
