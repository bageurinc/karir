<?php
namespace Bageur\Karir\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Karir\Model\karir;
use Bageur\Karir\Model\karir_tag;

class LowonganController extends Controller
{

    public function index(Request $request)
    {
        $query =  karir::query();
        if(\Auth::guard('api_mobile')->check()){
           $query->where('user_id',\Auth::guard('api_mobile')->id());
        }
        return $query->datatable($request);
    }

    public function store(Request $request)
    {
        $rules = [
            'perusahaan'        => 'required',
            'judul'             => 'required',
            'posisi'            => 'required',
            'tags'              => 'required',
            'type_pekerjaan'    => 'required',
            'remote'            => 'required',
            'matauang'          => 'required',
            'kualifikasi'       => 'required',
            'skill'             => 'required',
            'tugas'             => 'required',
            'gaji_max'          => 'required|numeric',
            'gaji_min'          => 'required|numeric',
            'tanggal_mulai'     => 'required|date',
            'tanggal_selesai'   => 'required|date',
        ];
        $validator = \Validator::make($request->all(), $rules);
        if($validator->fails()){
            $errors = $validator->errors();
            $err = [];
            foreach ($rules as $key => $value) {
                if ($errors->has($key)) {
                    $err[$key] = ['text' => $errors->first($key) , 'status' => 'is-danger'];
                }else{
                    $err[$key] = ['text' => '' , 'status' => 'is-success'];
                }
            }
            return ['status' => false , 'err' => $err];
        }else{
            $input                      = new karir;
            $input->perusahaan_id       = $request->perusahaan;
            $input->judul               = $request->judul;
            $input->judul_seo           = \Str::slug($request->judul,'-');
            $input->posisi              = $request->posisi;
            $input->tags                = json_encode($request->tags);
            $input->type_pekerjaan      = $request->type_pekerjaan;
            $input->fresh_graduate      = $request->fresh_graduate;
            $input->pengalaman_mulai    = $request->pengalaman_mulai;
            $input->pengalaman_selesai  = $request->pengalaman_selesai;
            $input->remote              = $request->remote;
            $input->matauang            = $request->matauang;
            $input->kualifikasi         = json_encode($request->kualifikasi);
            $input->skill               = json_encode($request->skill);
            $input->tugas               = json_encode($request->tugas);
            $input->gaji_max            = $request->gaji_max;
            $input->gaji_min            = $request->gaji_min;
            $input->tanggal_mulai       = $request->tanggal_mulai;
            $input->tanggal_selesai     = $request->tanggal_selesai;
            $input->save();
            foreach ($request->tags as $value) {
                karir_tag::firstOrCreate(['tag' => $value]);
            }
            return ['status' => true];
        }
    }

    public function destroy($id)
    {
        $delete = karir::findOrFail($id);
        $delete->delete();
        return response(['status' => true ,'text'    => 'has deleted'], 200);
    }
}
