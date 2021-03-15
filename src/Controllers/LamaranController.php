<?php
namespace Bageur\Karir\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Karir\Model\lamaran;
use Auth;
class LamaranController extends Controller
{

    public function index(Request $request)
    {
        $query =  lamaran::query();
        if(Auth::guard('api_mobile')->check()){
           $query->where('bgr_karir_lamaran.user_id',Auth::guard('api_mobile')->id()); 
           return $query->datatable($request); 
        }
    }
}