<?php
namespace App\Services;

use App\Models\DvlaApplication;

class DvlaApplicationService
{
    public function create($untypedArr) {
        $dva = new DvlaApplication();
        $dva->name = $untypedArr['name'];
        $dva->license_class = $untypedArr['license_class'];
        $dva->dvla_center = $untypedArr['dvla_center'];
        $dva->service_type = $untypedArr['service_type'];
        $dva->payment_option = $untypedArr['payment_option'];
        $dva->comments = $untypedArr['comments'];
        return $dva;
    }
        
    public function saveNew($dva) {
        $dva->save();
        return $dva;
    }
    
    public function update($dva) {
        $dva->exists = true;
        $dva->save();
        return $dva;
    }

    public function saveNewRaw($untypedArr) {
        $dva = $this->create($untypedArr);
        $dva->save();
        return $dva;
    }
    
    public function updateRaw($untypedArr) {
        $dva = $this->create($untypedArr);
        $dva->exists = true;
        $dva->save();
        return $dva;
    }
    
}