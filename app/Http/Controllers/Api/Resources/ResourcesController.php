<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2020/1/16 11:46
 */

namespace App\Http\Controllers\Api\Resources;


use App\Http\Controllers\Controller;
use App\Modules\Resources\ErrorCode\ResourcesErrorCode;
use App\Modules\Resources\Service\ResourcesService;
use App\Modules\User\ErrorCode\UserErrorCode;
use Illuminate\Http\Request;

/**
 * Notes: 资源服务器
 *
 * Class ResourcesController
 * @package App\Http\Controllers\Api\Resources
 */
class ResourcesController extends Controller
{
    private $service;

    public function __construct(ResourcesService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: 上传文件（任何类型）
     * User: admin
     * Date: 2020/3/3 16:09
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);

        $result = $this->service->upload();
        if ($result === ResourcesErrorCode::FILE_READ_FAILED) {
            return $this->failed($result, ResourcesErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 批量上传（任何类型）
     * User: admin
     * Date: 2020/3/3 19:53
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uploads(Request $request)
    {
        $this->validate($request, [
            'files' => 'required|array'
        ]);

        $result = $this->service->uploads();
        if ($result === ResourcesErrorCode::NUMBER_OF_FILES_EXCEEDED ||
            $result === ResourcesErrorCode::FILE_UPLOAD_EXCEPTION ||
            $result === ResourcesErrorCode::FILE_READ_FAILED) {
            return $this->failed($result, ResourcesErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 上传截图
     * User: admin
     * Date: 2020/7/20 17:22
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uploadScreenshot(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);

        $result = $this->service->uploadScreenshot();
        if ($result === ResourcesErrorCode::SCREENSHOT_PARSING_ERROR) {
            return $this->failed($result, ResourcesErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 上传用户头像
     * User: admin
     * Date: 2020/3/4 13:00
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function uploadAvatar(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'files' => 'required|array|max:1',
            'files.*' => 'mimes:jpeg,bmp,png,gif',
        ]);

        $result = $this->service->uploadAvatar($request->user_id);
        if ($result === UserErrorCode::USER_DOES_NOT_EXIST) {
            return $this->failed($result, UserErrorCode::getText($result));

        } else if ($result === ResourcesErrorCode::USER_AVATAR_UPLOAD_EXCEPTION ||
                   $result === ResourcesErrorCode::USER_AVATAR_ONLY_UPLOADED_ONCE) {
            return $this->failed($result, ResourcesErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除上传的文件（只能删除一个）
     * User: admin
     * Date: 2020/3/4 13:31
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Exception
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        $result = $this->service->delete($request->id);
        if ($result === ResourcesErrorCode::FILE_HAVE_LINK ||
            $result === ResourcesErrorCode::FILE_DOES_NOT_EXIST) {
            return $this->failed($result, ResourcesErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 下载文件
     * User: admin
     * Date: 2020/8/19 14:23
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|int|\Symfony\Component\HttpFoundation\StreamedResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function download(Request $request)
    {
        $this->validate($request, [
            'id' => 'nullable',
            'path' => 'nullable'
        ]);

        try {
            return $this->service->download($request->path, $request->id);

        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Notes: 获取所有资源列表
     * User: admin
     * Date: 2020/3/4 14:32
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return $this->success($this->service->all());
    }

    /**
     * Notes: 查找资源依赖
     * User: admin
     * Date: 2020/3/4 14:45
     *
     * @param Request $request
     * @return \App\Models\Resources|\Illuminate\Database\Eloquent\Model|mixed|null
     * @throws \Illuminate\Validation\ValidationException
     */
    public function findDepend(Request $request)
    {
        $this->validate($request, [
            'id' => 'required'
        ]);

        return $this->success($this->service->findDepend($request->id));
    }
}
