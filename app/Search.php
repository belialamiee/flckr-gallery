<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Users Search Terms
 * Class Search
 * @package App
 */
class Search extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['user','searchTerm'];
    /**
     * @var string
     */
    protected $table = 'searches';


    /** A search term belongs to one user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class);
    }


}