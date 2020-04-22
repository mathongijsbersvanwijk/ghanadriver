<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// TODO: create parent hierarchy for category; if subcategory is indicated, then automatically indicate parent category
class Category extends Model {
		
	public $timestamps = false;

	protected $fillable = ['name','tag'];

}
