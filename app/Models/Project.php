<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'projects';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'path', 'description', 'parent_project_id', 'source_url_template', 'active'];

	protected $guarded = ['id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];


	/**
	 * Get sub projects of a model
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function sub_projects() {
		return self::where('parent_project_id', '=', $this->id )
			->orderBy('active', 'desc')
			->orderBy('id', 'asc')
			->get();
	}



	/**
	 * Get project by path from the url.
	 *
	 * @param  array  $columns
	 * @return \App\Models\Project
	 */
	public static function by_path( $path ) {
		return self::where('path', '=', trim( $path, '/' ))->first();
	}

	/**
	 * Get all parent projects.
	 *
	 * @param  array  $columns
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function top_level($columns = ['*']) {
		return self::whereNull('parent_project_id')->get();
	}

}
