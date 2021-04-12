<?php

namespace Bageur\Karir\Model;

use Illuminate\Database\Eloquent\Model;
use Bageur\Indonesia\Model\ind_provinsi;
use Bageur\Indonesia\Model\ind_kota;

class perusahaan extends Model
{
    protected $table   = 'bgr_karir_perusahaan';

    protected $appends = ['avatar','nama_provinsi','nama_kota'];
    
    public function getAvatarAttribute() {
        return \Bageur::g_gambar($this->foto,'perusahaan',false,'solo')['base64'];
    }
    public function getNamaProvinsiAttribute() {
        return ind_provinsi::find($this->provinsi)->nama;
    }
    
    public function getNamaKotaAttribute() {
        return ind_kota::find($this->kota)->nama;
    }

    public function scopeDatatable($query,$request,$page=12)
    {
         $search       = ["perusahaan"];
        $searchqry    = '';

        $searchqry = "(";
        foreach ($search as $key => $value) {
            if($key == 0){
                $searchqry .= "lower($value) like '%".strtolower($request->search)."%'";
            }else{
                $searchqry .= "OR lower($value) like '%".strtolower($request->search)."%'";
            }
        } 

        $searchqry .= ")";
        if(@$request->sort_by){
            if(@$request->sort_by != null){
                $explode = explode('.', $request->sort_by);
                 $query->orderBy($explode[0],$explode[1]);
            }else{
                  $query->orderBy('created_at','desc');
            }

             $query->whereRaw($searchqry);
        }else{
             $query->whereRaw($searchqry);
        }

        if($request->get == 'all'){
            return $query->get();
        }else{
                return $query->paginate($page);
        }

    }
}
