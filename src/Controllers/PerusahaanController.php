<?php
namespace Bageur\Karir\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Karir\Model\perusahaan;

class PerusahaanController extends Controller
{

    public function index(Request $request)
    {
        return perusahaan::datatable($request);
    }

    public function store(Request $request)
    {
        $rules = [
            'foto'          => 'required',
            'perusahaan'    => 'required',
            'keterangan'    => 'required',
            'email'         => 'required|email',
            'notelp'        => 'required',
            'nowa'          => 'required',
            'provinsi'      => 'required',
            'kota'          => 'required',
            'alamat'        => 'required',
            'web'           => 'nullable|url',
            'fb'            => 'nullable|url',
            'ib'            => 'nullable|url',
            'linkedin'      => 'nullable|url',
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
            $input              = new perusahaan;
            $input->foto      = $request->foto;
            $input->keterangan      = $request->keterangan;
            $input->perusahaan      = $request->perusahaan;
            $input->email       = $request->email;
            $input->notelp      = $request->notelp;
            $input->nowa        = $request->nowa;
            $input->provinsi        = $request->provinsi;
            $input->kota        = $request->kota;
            $input->alamat      = $request->alamat;
            $input->web         = $request->web;
            $input->fb      = $request->fb;
            $input->ib      = $request->ib;
            $input->linkedin        = $request->linkedin;
            $input->save();
             return ['status' => true];
        }
    }

}