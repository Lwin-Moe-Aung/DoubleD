<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SelectedLog extends Model
{
    protected $table = 'selected_log';
    protected $fillable = [
        'date', 'morning_first_select', 'mfs_stock_id', 'morning_second_select', 'mss_stock_id', 'morning_selected_stock', 'morning_ss_time', 'evening_first_select', 'efs_stock_id', 'evening_second_select', 'evening_ss_time', 'ess_stock_id', 'evening_selected_stock'
    ];
    
}
