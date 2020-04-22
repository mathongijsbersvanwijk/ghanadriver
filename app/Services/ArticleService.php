<?php
namespace App\Services;

use App\Models\Article;
use App\Models\Category;
use App\Models\Categorization;
use App\Support\Helpers\Utils;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ArticleService {
	public function findAll($ob = 'created_at', $dir = 'desc') {
		return Article::orderBy($ob, $dir)->get();
	}

	public function find($id) {
		return Article::findOrFail($id);
	}

	public function findByTitle($title) {
		return Article::where('title', $title)->first();
	}
	
	public function findBySingleCategory($catId) {
		return $this->findByCategoryImpl($catId, 0, 0, null);
	}
	
	public function findBySingleCategoryTitle($title) {
		$cat = Category::where('name', $title)->first();
		return $this->findByCategoryImpl($cat->id, 0, 0, null);
	}
	
	public function findByCategory($cats, $updated = null) {
		return $this->findByCategoryImpl($cats, 0, 0, $updated);
	}
	
	public function search($untypedArr) {
		$uri = isset($untypedArr['uri']) ? $untypedArr['uri'] : '';
		return Article::search($uri)->get();
	}
	
	public function save($untypedArr) {
		$art = new Article();
		return $this->saveArticle($untypedArr, $art);
	}
	
	public function update($untypedArr) {
		$art = new Article();
		$art->exists = true;
		return $this->saveArticle($untypedArr, $art);
	}
	
	public function selectAndUpdate($untypedArr) {
		$id = isset($untypedArr['id']) ? $untypedArr['id'] : null;
		$art = $this->find($id);
		return $this->saveArticle($untypedArr, $art, null);
	}
	
	public function saveActive($untypedArr, $id) {
		$art = $this->find($id);
		$art->active = $untypedArr['active'] == 'true';
		$art->save();
	}
	
	private function findByCategoryImpl($catId, $lastid, $limit, $updated) {
		$ca = array();
		$ca[] = $catId;
		
		$arts = DB::table('articles')->select('articles.id as artid', 'title', 'uri', 'created_at', 'updated_at');
		for ($i = 0; $i < sizeof($ca); $i++) {
			$arts = $arts
			->join('categorizations as c'.$i, function ($join) use ($ca, $i, $updated) {
				$join->on('c'.$i.'.categorizable_id', '=', 'articles.id')
				->where('c'.$i.'.categorizable_type', '=', 'App\Models\Article')
				->where('c'.$i.'.category_id', '=', $ca[$i]);
				if ($updated != null) {
					$join = $join->where('articles.updated_at', '>', $updated);
				}
			});
		}
		if ($limit > 0) {
			$arts = $arts->where('articles.id', '>', $lastid)->take($limit)->get();
		} else {
			$arts = $arts->get();
		}
		
		/* 		$artsnew = new Collection();
		 for ($i = 0; $i < sizeof($arts); $i++) {
		 $art = new Article();
		 $art->id = $arts[$i]->artid;
		 $art->title = $arts[$i]->title;
		 $art->uri = $arts[$i]->uri;
		 $art->created_at = $arts[$i]->created_at;
		 $art->updated_at = $arts[$i]->updated_at;
		 $artsnew->put($art->id, $art);
		 }
		 */
		return $arts;
	}
	
	public function saveArticle($untypedArr, $art) {
		$art->id = isset($untypedArr['id']) ? $untypedArr['id'] : null;
		$art->title = $untypedArr['title'];
		$art->uri = $untypedArr['uri'];
		$art->save();

		$catids = isset($untypedArr['category']) ? $untypedArr['category'] : null;
		if ($catids != null) {
			$this->saveCategorizations($art, $catids);
		}
		
		return $art;
	}
	
	public function saveCategorizations($art, $catids) {
		$cgns = $art->categorizations;
		if (sizeof($cgns) == 1 && sizeof($catids) == 1) {
			// just an optimization to prevent needless deletes and inserts
			$cgn = $cgns->first();
			$cgn->category_id = array_values($catids)[0];
			$cgn->categorizable_id = $art->id;
			$cgn->categorizable_type = 'App\Models\Article';
			$cgn->exists = true;
			$art->categorizations()->save($cgn);
		} else  {
			$art->categorizations()->delete();
			foreach ($catids as $catid) {
				$cgn = new Categorization;
				$cgn->category_id = $catid;
				$cgn->categorizable_id = $art->id;
				$cgn->categorizable_type = 'App\Models\Article';
				$art->categorizations()->save($cgn);
			}
		}
	}
	
	// NOT USED
	private function saveCategories($art, $cats) {
		$cgns = $art->categorizations;
		if (sizeof($cgns) == 1 && sizeof($cats) == 1) {
			// just an optimization to prevent needless deletes and inserts
			$cgn = $cgns->first();
			$cgn->category()->associate($cats->first());
			$art->categorizations()->save($cgn);
		} else  {
			$art->categorizations()->delete();
			foreach ($cats as $cat) {
				$cgn = new Categorization;
				$cgn->category()->associate($cat);
				$art->categorizations()->save($cgn);
			}
		}
	}
}