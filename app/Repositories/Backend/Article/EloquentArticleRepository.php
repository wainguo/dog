<?php

namespace App\Repositories\Backend\Article;

//use App\Helpers\Auth\Auth;
use App\Models\Article\Article;
use Illuminate\Support\Facades\DB;
use App\Exceptions\GeneralException;
use App\Events\Backend\Access\Role\RoleCreated;
use App\Events\Backend\Access\Role\RoleDeleted;
use App\Events\Backend\Access\Role\RoleUpdated;
use Illuminate\Support\Facades\Storage;

/**
 * Class EloquentArticleRepository
 */
class EloquentArticleRepository implements ArticleRepositoryContract
{

    public function getCount() {
        return Article::count();
    }

	/**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getForDataTable() {
        return Article::all();
    }

    /**
     * @param  $input
     * @throws GeneralException
     * @return bool
     */
    public function create($input)
    {
        $user = access()->user();
//        $userId = access()->id();
        $article       = new Article();
        $article->user_id = $user->id;
        $article->user_name = $user->name;
        $article->title = $input['title'];
        $article->channel_id = $input['channel_id'];
        if(isset($input['mall_id'])) $article->mall_id = $input['mall_id'];
        $article->type = isset($input['type'])? $input['type'] : 'product';
        $article->subtitle = $input['subtitle'];
        $article->content = $input['content'];
        $article->excerpt = str_limit(strip_tags($article->content), 250);
//        $article->position = $input['position'];
        isset($input['cover'])? $article->cover = $input['cover'] : '';
        $article->url = $input['url'];
//        $result = $this->getAndSaveImageFromContent($article->content, $this->imageUploadPath, $this->imageUploadUrl);
        $result = $this->getAndSaveImageFromContent($article->content, upload_path(), upload_url());
        $article->content = $result['content'];
        if(!$article->cover && count($result['image_urls'])>0){
            $article->cover = $result['image_urls'][0];
        }
        $tagIds = $input['tag_ids'];
		DB::transaction(function() use ($article, $tagIds) {
			if ($article->save()) {
                if(!empty($tagIds)){
                    $article->tags()->sync($tagIds);
//                    foreach($tagIds as $tagId){
//                        $article->tags()->attach($tagId);
//                    }
                }
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.article.create_error'));
		});
    }

    /**
     * @param  Article $article
     * @param  $input
     * @throws GeneralException
     * @return bool
     */
    public function update(Article $article, $input)
    {
        $article->title = $input['title'];
        $article->channel_id = $input['channel_id'];
        if(isset($input['mall_id'])) $article->mall_id = $input['mall_id'];
        $article->type = isset($input['type'])? $input['type'] : 'product';
        $article->subtitle = $input['subtitle'];
        $article->content = $input['content'];
        $article->excerpt = str_limit(strip_tags($article->content), 250);
//        $article->position = $input['position'];
        isset($input['cover'])? $article->cover = $input['cover'] : '';
        $article->url = $input['url'];
//        $result = $this->getAndSaveImageFromContent($article->content, $this->imageUploadPath, $this->imageUploadUrl);
        $result = $this->getAndSaveImageFromContent($article->content, upload_path(), upload_url());
        $article->content = $result['content'];
        if(!$article->cover && count($result['image_urls'])>0){
            $article->cover = $result['image_urls'][0];
        }
        $tagIds = $input['tag_ids'];
		DB::transaction(function() use ($article, $tagIds) {
			if ($article->save()) {
                if(!empty($tagIds)){
                    $article->tags()->sync($tagIds);
//                    foreach($tagIds as $tagId){
//                        $article->tags()->attach($tagId);
//                    }
                }
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.article.update_error'));
		});
    }

    /**
     * @param  Article $article
     * @throws GeneralException
     * @return bool
     */
    public function destroy(Article $article)
    {
		DB::transaction(function() use ($article) {
			if ($article->delete()) {
				return true;
			}

			throw new GeneralException(trans('exceptions.backend.article.delete_error'));
		});
    }

    /**
     * @param $content
     * @param $destPath
     * @param $baseUrl
     * @return array
     */
    public function getAndSaveImageFromContent($content, $destPath, $baseUrl)
    {
        $allowedExtensions = ["png", "jpg", "jpeg", "gif"];
        $imageList = $this->getImageByReg($content);
        $localBaseUrl = url('');
        foreach ($imageList as $key => $val) {
            if ( strpos($val['src'], $localBaseUrl) !== false ) {
                $arr = explode('/', $val['src']);
                $name = array_pop($arr);
                $imageList[$key]['src'] = $name;
                continue;
            }
            $arr = explode('.', $val['src']);
            $ext = array_pop($arr);
            if (!$ext || !in_array($ext, $allowedExtensions)) {
                $ext = 'jpg';
            }
            $name = uniqid().'.'.$ext;
            $imageList[$key]['src'] = $name;

            $file = file_get_contents($val['src']);
            file_put_contents($destPath .'/'. $name, $file);
        }

        $newImgInfo = $this->replaceImageUrl($imageList, $baseUrl);
        $newImgTags = $newImgInfo['newImgTags'];
        $newImgUrls = $newImgInfo['newImgUrls'];

        $patterns = array('/<img\s.*?>/');
        $callback = function( $matches ) use ( &$newImgTags ) {
            $matches[0] = array_shift($newImgTags);
            return $matches[0];
        };

        $res = array();
        $res['content'] = preg_replace_callback($patterns, $callback, $content);
        $res['image_urls'] = $newImgUrls;

        return $res;
    }

    private function getImageByReg($str)
    {
        $imageList = array();
        $c1 = preg_match_all('/<img\s.*?>/', $str, $m1);
        for($i = 0; $i < $c1; $i++) {
            $c2 = preg_match_all('/(\w+)\s*=\s*(?:(?:(["\'])(.*?)(?=\2))|([^\/\s]*))/', $m1[0][$i], $m2);
            for($j = 0; $j < $c2; $j++) {
                $imageList[$i][$m2[1][$j]] = !empty($m2[4][$j]) ? $m2[4][$j] : $m2[3][$j];
            }
        }

        return $imageList;
    }
    // baseUrl with postfix '/'
    private function replaceImageUrl($imageList, $baseUrl)
    {
        $newImgTags = array();
        $newImgUrls = array();

        foreach ($imageList as $key => $val) {
            $imgTag = '<img ';
            foreach ($val as $attr => $v) {
                if ($attr === 'src') {
                    $imgTag .= $attr . '="' . $baseUrl .'/'. $v . '" ';
                    $newImgUrls[] = $baseUrl .'/' . $v;
                } else {
                    $imgTag .= $attr . '="' . $v . '" ';
                }
            }
            $imgTag .= ' >';

            $newImgTags[$key] = $imgTag;
        }

        return array('newImgTags' => $newImgTags, 'newImgUrls' => $newImgUrls);
    }
}