<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class ProvisionLog extends Model {
    protected $fillable = ['service_id','provider_id','action','status','request','response','message'];
    public function service() { return $this->belongsTo(Service::class); }
    public function provider() { return $this->belongsTo(Provider::class); }
}
