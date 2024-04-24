<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;


class Asset extends Model
{

    protected $primaryKey = 'AssetId';
    public $timestamps = false;



    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    protected $fillable = [
        'AssetCusId',
        'AssetName',
        'AssetSerialNum',
        'AssetTypeId',
        'AssetDescription',
        'AssetDepartmentId',
        'AssetOrganizationId',
        'AssetLocation',
        'AssetManagedBy',
        'AssetPurchaseDate',
        'AssetWarrantyExpiryDate',
        'AssetServiceTypeId',
        'NumberOfServices',
        'AssetImage',
        'ServiceDateId',

    ];

    public function assettype()
    {
        return $this->belongsTo('App\Models\Assettype', 'AssetTypeId');
    }

    public function servicetype()
    {
        return $this->belongsTo('App\Models\Servicetype', 'AssetServiceTypeId');
    }
    public function servicedate()
    {
        return $this->belongsTo('App\Models\Servicedate', 'ServiceDateId');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'AssetDepartmentId');
    }

    public function organization()
    {
        return $this->belongsTo('App\Models\Organization', 'AssetOrganizationId');
    }

    public function staff()
    {
        return $this->belongsTo('App\Models\Staff', 'AssetManagedBy');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer', 'AssetCusId');
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'AssetId', 'AssetId');
    }

    public function getMaintenanceStatusAttribute()
    {
        $schedule = $this->schedules()->first();

        if (!$schedule) {
            return 'Unscheduled';
        }

        switch ($schedule->MaintenanceStatusId) {
            case 1:
                return 'Completed';
            case 2:
                return 'Scheduled';
            default:
                return 'Unscheduled';
        }
    }
}
