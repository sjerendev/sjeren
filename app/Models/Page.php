<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Page extends Model implements HasMedia
{
	use InteractsWithMedia;

	protected $fillable = [
		'title',
		'slug',
		'content',
		'is_published',
		'is_homepage',
		'hero_image',
		'hero_height',
		'hero_headline',
		'hero_subheadline',
		'hero_paragraph',
		'hero_cta_text',
		'hero_cta_url',
		'hero_background_type',
		'hero_background_color',
		'hero_text_color',
		'meta_title',
		'meta_description',
		'headline_text',
		'headline_type',
		'headline',
		'text',
		'parent_id',
		'sort_order'
	];

	protected $casts = [
		'content' => 'array',
		'hero_image' => 'array',
	];

	public function parent()
	{
		return $this->belongsTo(Page::class, 'parent_id');
	}

	public function children()
	{
		return $this->hasMany(Page::class, 'parent_id');
	}

	public function level(): int
	{
		$level = 0;
		$page = $this;
		
		while ($page->parent_id) {
			$level++;
			$page = $page->parent;
		}
		
		return $level;
	}
}
