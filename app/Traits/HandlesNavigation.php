<?php

namespace App\Traits;

use App\Models\Navigation;
use App\Models\Category;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Seller;
use App\Models\Book;

trait HandlesNavigation
{
	protected static function bootHandlesNavigation()
	{
		static::created(function ($model) {
			$model->createNav();
		});

		static::deleted(function ($model) {
			$model->deleteNav();
		});
	}

	protected function deleteNav()
	{
		$reference = $this->getReference();

		$navigation = Navigation::where('reference', $reference)
			->where('foreign_id', $this->id)
			->first();

		if ($navigation) {
			$navigation->delete();
		}
	}

	protected function getReference()
	{
		if ($this instanceof Category) {
			$reference = 'category';
		} else if ($this instanceof Author) {
			$reference = 'author';
		} else if ($this instanceof Publisher) {
			$reference = 'publisher';
		} else if ($this instanceof Seller) {
			$reference = 'seller';
		} else if ($this instanceof Book) {
			$reference = 'book';
		} else {
			$reference = 'unknown';
		}

		return $reference;
	}

	protected function createNav()
	{
		$reference = $this->getReference();

		Navigation::create([
			'name' => $this->name,
			'reference' => $reference,
			'foreign_id' => $this->id
		]);
	}

	protected function resolve($slug)
	{
		$instance = Navigation::where('slug', $slug)->first();

		if(is_null($instance)) {
			return null;
		}

		switch ($instance->reference) {
			case 'category':
				return [
					'type' => 'category',
					'instance' => Category::find($instance->foreign_id)
				];
				break;

			case 'author':
				return [
					'type' => 'author',
					'instance' => Author::find($instance->foreign_id)
				];
				break;

			case 'publisher':
				return [
					'type' => 'publisher',
					'instance' => Publisher::find($instance->foreign_id)
				];
				break;

			case 'book':
				return [
					'type' => 'book',
					'instance' => Book::find($instance->foreign_id)
				];
				break;

			case 'seller':
				return [
					'type' => 'seller',
					'instance' => Seller::find($instance->foreign_id)
				];
				break;
			
			default:
				return [
					'type' => 'unknown',
					'instance' => null
				];
				break;
		}
	}
}
