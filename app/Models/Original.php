<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;

class Original extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'originals';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['project_id', 'context', 'singular', 'plural', 'references', 'comment', 'status', 'priority', 'date_added'];

	protected $guarded = ['id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];





	/**
	 * Get all parent projects
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function count_by_project_id( $project_id ) {
		//if ( false !== ( $cached = wp_cache_get( $project_id, self::$count_cache_group ) ) ) {
		//	return $cached;
		//}

		$counts = self::where( 'project_id', '=', $project_id )
			->where( 'status', '=', '+active' )
			->count();

		return $counts;
	}

}
