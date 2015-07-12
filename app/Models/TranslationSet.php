<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Original;
use Cache;
use DB;
use GP_Locales;

class TranslationSet extends Model
{
	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'translation_sets';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'slug', 'project_id', 'locale'];

	protected $guarded = ['id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];


	public function name_with_locale( $separator = '&rarr;') {
		$locale = GP_Locales::by_slug( $this->locale );
		$parts = array( $locale->english_name );

		if ( 'default' != $this->slug ) {
			$parts[] = $this->name;
		}

		return implode( '&nbsp;' . $separator . '&nbsp;', $parts );
	}

	public function waiting_count() {
		if ( ! isset( $this->waiting_count ) ) {
			$this->update_status_breakdown();
		}

		return $this->waiting_count;
	}

	public function untranslated_count() {
		if ( ! isset( $this->untranslated_count ) ) {
			$this->update_status_breakdown();
		}

		return $this->untranslated_count;
	}

	public function fuzzy_count() {
		if ( ! isset( $this->fuzzy_count ) ) {
			$this->update_status_breakdown();
		}

		return $this->fuzzy_count;
	}

	public function current_count() {
		if ( ! isset( $this->current_count ) ) {
			$this->update_status_breakdown();
		}

		return $this->current_count;
	}

	public function warnings_count() {
		if ( ! isset( $this->warnings_count ) ) {
			$this->update_status_breakdown();
		}

		return $this->warnings_count;
	}

	public function all_count() {
		if ( ! isset( $this->all_count ) ) {
			$this->all_count = Original::count_by_project_id( $this->project_id );
		}

		return $this->all_count;
	}

	public function percent_translated() {
		$original_count = $this->all_count();

		return $original_count ? floor( $this->current_count() / $original_count * 100 ) : 0;
	}

	function last_modified() {
		return GP::$translation->last_modified( $this );
	}



	/**
	 * Get translation sets by slug and locale
	 *
	 * @param  int     $project_id
	 * @param  string  $slug
	 * @param  string  $locale_slug
	 * @return \App\Models\TranslationSet
	 */
	public static function by_project_id_slug_and_locale( $project_id, $slug, $locale_slug ) {
		return self::where('slug', '=', $slug)
			->where('project_id', '=', $project_id)
			->where('locale', '=', $locale_slug)
			->first();
	}

	/**
	 * Get translation sets by locale
	 *
	 * @param  string  $locale_slug
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function by_locale( $locale_slug ) {
		return self::where('locale', '=', $locale_slug)->get();
	}

	/**
	 * Get all used locales
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function existing_locales() {
		return self::distinct()->select('locale')->lists('locale');
	}

	/**
	 * Get all translation sets of a project
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public static function by_project_id( $project_id ) {
		return self::where('project_id', '=', $project_id)->orderBy('name')->get();
	}



	private function update_status_breakdown() {
		$counts = Cache::tags('translation_set_status_breakdown')->rememberForever( $this->id, function() {
			/*
			 * TODO:
			 *  - calculate weighted coefficient by priority to know how much of the strings are translated
			 * 	- calculate untranslated
			 */
			$t = 'translations';
			$o = 'originals';

			$counts = DB::table( $t )
				->select( DB::raw('COUNT(*) as n, gp_' . $t .'.status as translation_status') )
				->join( $o, $t . '.original_id', '=', $o . '.id' )
				->where( $t . '.translation_set_id', '=', $this->id )
				->where( $o . '.status', 'like', '+%%' )
				->groupBy( $t . '.status' )
				->get();

			$warnings_count = DB::table( $t )
				->select( DB::raw('COUNT(*)' ) )
				->join( $o, $t . '.original_id', '=', $o . '.id' )
				->where( $t . '.translation_set_id', '=', $this->id )
				->where( $o . '.status', 'like', '+%%' )
				->whereNotNull( 'warnings' )
				->whereIn( $t . '.status', ['current', 'waiting'] )
				->lists('*');

			$counts[] = (object)array( 'translation_status' => 'warnings', 'n' => $warnings_count );
			$counts[] = (object)array( 'translation_status' => 'all', 'n' => $this->all_count() );

			return $counts;
		});

		$statuses = array( 'current', 'waiting', 'rejected', 'fuzzy', 'old', ); //TODO: GP::$translation->get_static( 'statuses' );
		$statuses[] = 'warnings';
		$statuses[] = 'all';

		foreach ( $statuses as $status ) {
			$this->{$status.'_count'} = 0;
		}

		$this->untranslated_count = 0;
		foreach ( $counts as $count ) {
			if ( in_array( $count->translation_status, $statuses ) ) {
				$this->{$count->translation_status.'_count'} = $count->n;
			}
		}

		$this->untranslated_count = $this->all_count() - $this->current_count;
	}

}
