<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Ticket extends Model
{
  protected $primaryKey = 'TicketId';
  public $timestamps = false;
  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */

  protected $fillable = [
    'TicketSubject',
    'TicketCreaterId',
    'TicketAssetId',
    'TicketPriorityId',
    'TicketDescription',
    'Attachments',

  ];


  public function asset()
  {
    return $this->belongsTo('App\Models\asset', 'TicketAssetId');
  }

  public function customer()
  {
    return $this->belongsTo('App\Models\Customer', 'TicketCreaterId');
  }

  public function priorityticket()
  {
    return $this->belongsTo('App\Models\Priorityticket', 'TicketPriorityId');
  }

  public function statusticket()
  {
    return $this->belongsTo('App\Models\Statusticket', 'TicketStatusId');
  }

  public function allocation()
  {
    return $this->hasOne(Allocation::class, 'TicketId','TicketId');
  }

  public function getAllocationStatusAttribute()
  {
      $isAllocated = $this->allocation()->exists();
      return $isAllocated ? 'Assigned' : 'Unassigned';
  }    
  
}
