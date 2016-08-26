<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Simple model for holding the Search terms and attaching them to a user.
 * This is so that we can provide a history of recent searches for the user.
 * Users Search Terms
 * Class Search
 * @package App
 */
class Search extends Model
{

    /**
     * @var array
     */
    protected $fillable = ['user','searchTerm','updated_at','created_at'];
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