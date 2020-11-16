<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(){
        $title = "Submission - Sistem Keuangan";
        switch (session()->get('nama_jabatan')) {
            case 'Admin':
                return view('kepsek.submission',[ 'title' => $title ]);
                break;
            case 'Kepala Sekolah':
                return view('kepsek.submission',[ 'title' => $title ]);
                break;
            case 'Kepala Keuangan':
                //return view('',[ 'title' => $title ]);
                break;
            case 'Staf BOS':
                //return view('',[ 'title' => $title ]);
                break;
            case 'Staf Dana':
                //return view('',[ 'title' => $title ]);
                break;
            case 'Kaprog':
                //return view('',[ 'title' => $title ]);
                break;
            default:
                $title = "Sistem Informasi Keuangan";
                return view('login',['title' => $title]);
                break;
        }
        
    }
}
