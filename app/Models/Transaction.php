<?php

namespace App\Models;
use Carbon\Carbon;

/**
 * Class Transaction
 * @package App\Models
 */
class Transaction extends BaseModel
{
    /**
     * @var array
     */
    protected $fillable = ['amount', 'date'];

    /**
     * @var string
     */
    const DATE_FORMAT_SET = 'Y-m-d';

    /**
     * @var string
     */
    const DATE_FORMAT_GET = 'd.m.Y';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @param $value
     */
    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::parse($value)->format(self::DATE_FORMAT_SET);
    }

    /**
     * @return mixed
     */
    public static function getYesterdayAmountSum() {
        $sum = self::whereBetween('date', [
            Carbon::yesterday()->format(self::DATE_FORMAT_SET),
            Carbon::now()->format(self::DATE_FORMAT_SET)
        ])->sum('amount');

        return $sum;
    }

    /**
     * @param $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        return Carbon::parse($value)->format(self::DATE_FORMAT_GET);
    }

    /**
     * @param $query
     * @param $user_id
     * @return mixed
     */
    public function scopeByUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /**
     * @param $query
     * @param $amount
     * @return mixed
     */
    public function scopeByAmount($query, $amount)
    {
        return $query->where('amount', $amount);
    }

    /**
     * @param $query
     * @param $date
     * @return mixed
     */
    public function scopeByDate($query, $date)
    {
        return $query->where('date', $date);
    }

    /**
     * @param $query
     * @param $offset
     * @return mixed
     */
    public function scopeByOffset($query, $offset)
    {
        return $query->offset($offset);
    }

    /**
     * @param $query
     * @param $limit
     * @return mixed
     */
    public function scopeByLimit($query, $limit)
    {
        return $query->limit($limit);
    }
}
