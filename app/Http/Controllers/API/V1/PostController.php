<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Post;
use App\Http\Resources\V1\PostResource;
use App\Http\Resources\V1\PostCollection;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;

class PostController extends Controller
{
    protected $post;

    /**
     * @param $post.
     */
    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = $this->post->paginate(5);

        // Đối với sử dụng PostResource
        // Nếu muốn trả kèm các link paginate và các meta thì ta sẽ trỏ đến response()->getData(true).
        // Còn nếu chỉ muốn trả ra mỗi collection thì không cần trỏ đến response()->getData(true)
        // $postResource = PostResource::collection($posts)->response()->getData(true);

        // Đối với sử dụng PostCollection
        $postCollection = new PostCollection($posts);
        return $this->sentSuccessResponse($postCollection, 'get list post success', Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->only(['name', 'description', 'like', 'dislike', 'view', 'active']);

        // Destructuring Array
        ['name' => $name, 'description' => $description, 'like' => $like, 'dislike' => $dislike, 'view' => $view, 'active' => $active] = $data;
        // dd($name, $description, $like, $dislike, $view, $active);

        $newPost = $this->post->create($data);

        $postResource = new PostResource($newPost);
        return $this->sentSuccessResponse($postResource, 'add post success', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // $post = $this->post->findOrFail($id);
        // $postResource = new PostResource($post);
        // return $this->sentSuccessResponse($postResource, 'get post ' . $id . ' success', Response::HTTP_OK);

        // Add Field With Map (Thêm field trả về với phương thức Map)
        $data = Post::find($id)->select(['id', 'name', 'like', 'dislike', 'view', 'active', 'created_at', 'updated_at'])->get()->map(function ($post) {
            // Trong đối tượng Post trả về luôn luôn trả thêm 2 field registered, updated do ta tự cấu hình
            $post->registered = $post->created_at->diffForHumans();
            $post->updated = $post->updated_at->diffForHumans();
            return $post;
        });

        return $this->sentSuccessResponse($data, 'get post ' . $id . ' success', Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePostRequest $request, string $id)
    {
        $post = $this->post->findOrFail($id);

        $originalName = $post->getOriginal('name');
        $originalDescription = $post->getOriginal('description');

        $data = $request->only(['name', 'description', 'like', 'dislike', 'view', 'active']);

        if (isset($data['name'])) {
            $name = $data['name'];
        }
        if (isset($data['description'])) {
            $description = $data['description'];
        }
        if (isset($data['like'])) {
            $like = $data['like'];
        }
        if (isset($data['dislike'])) {
            $dislike = $data['dislike'];
        }
        if (isset($data['view'])) {
            $view = $data['view'];
        }
        if (isset($data['active'])) {
            $active = $data['active'];
        }

        $post->update($data);

        if ($post->wasChanged(['name', 'description'])) {
            dd('Name And Description Were Changed: Name From ' . $originalName . ' To ' . $name . ' And Description From ' . $originalDescription . ' To ' . $description);
        }

        $postResource = new PostResource($post);
        return $this->sentSuccessResponse($postResource, 'update post success', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();
        $postResource = new PostResource($post);
        return $this->sentSuccessResponse($postResource, 'delete post success', Response::HTTP_OK);
    }

    /**
     * Statistical information related to Post
     */
    public function statistics()
    {
        // Min Max
        $postLikeMax = Post::max('like');
        $postLikeMin = Post::min('like');
        $postDisLikeMax = Post::max('dislike');
        $postDisLikeMin = Post::min('dislike');
        $postViewMax = Post::max('view');
        $postViewMin = Post::min('view');

        // Sum
        $postLikeSum = Post::sum('like');
        $postDislikeSum = Post::sum('dislike');
        $postViewSum = Post::sum('view');

        // Avg
        $postLikeAvg = Post::avg('like');
        $postDislikeAvg = Post::avg('dislike');
        $postViewAvg = Post::avg('view');

        $data = [
            // Max Min
            'post_like_max' => $postLikeMax,
            'post_like_min' => $postLikeMin,
            'post_dislike_max' => $postDisLikeMax,
            'post_dislike_min' => $postDisLikeMin,
            'post_view_max' => $postViewMax,
            'post_view_min' => $postViewMin,
            // Sum
            'post_like_sum' => $postLikeSum,
            'post_dislike_sum' => $postDislikeSum,
            'post_view_sum' => $postViewSum,
            // Avg
            'post_like_avg' => $postLikeAvg,
            'post_dislike_avg' => $postDislikeAvg,
            'post_view_avg' => $postViewAvg,
        ];

        return $this->sentSuccessResponse($data, 'get list static post success', Response::HTTP_OK);
    }

    /**
     * Test Sql Injection
     */
    public function testSqlInjectionPost(Request $request)
    {
        $data = $request->only(['like', 'dislike', 'view']);

        $like = $dislike = $view = 1;

        if (isset($data['like'])) {
            $like = $data['like'];
        }
        if (isset($data['dislike'])) {
            $dislike = $data['dislike'];
        }
        if (isset($data['view'])) {
            $view = $data['view'];
        }

        $post = Post::selectRaw('like * ? as post_like, dislike * ? as post_dislike, view * ? as post_view', [$like, $dislike, $view])->get();
        return $this->sentSuccessResponse($post, 'success', Response::HTTP_OK);
    }
}
