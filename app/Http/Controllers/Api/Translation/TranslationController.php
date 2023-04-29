<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/2/28 11:41
 */

namespace App\Http\Controllers\Api\Translation;


use App\Http\Controllers\Controller;
use App\Modules\Translation\Entity\TranslationsVO;
use App\Modules\Translation\Enum\LanguageEnum;
use App\Modules\Translation\ErrorCode\TranslationErrorCode;
use App\Modules\Translation\Service\GoogleTranslate;
use App\Modules\Translation\Service\TranslationService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Notes: 翻译控制器
 *
 * Class TranslationController
 * @package App\Http\Controllers\Api\Translation
 */
class TranslationController extends Controller
{
    private $service;

    private $googleTranslate;

    public function __construct(TranslationService $service, GoogleTranslate  $googleTranslate)
    {
        $this->service =$service;
        $this->googleTranslate =$googleTranslate;
    }

    /**
     * Notes: 创建
     * User: admin
     * Date: 2020/2/28 12:52
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {
        $this->validate($request, [
            'translations' => 'required|array',
            'translations.*.key' => 'required|string|max:255',
            'translations.*.value' => 'required|string|max:255',
            'translations.*.language_enum' => ['required', Rule::in(LanguageEnum::all())],
            'translations.*.remark' => 'nullable',
        ]);

        $result = $this->service->create($request->translations);
        if ($result === TranslationErrorCode::TRANSLATION_CREATE_EXCEPTION) {
            return $this->failed($result, TranslationErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 删除
     * User: admin
     * Date: 2020/2/28 12:53
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
            'ids' => 'required|array'
        ]);

        return $this->success($this->service->delete($request->ids));
    }

    /**
     * Notes: 编辑
     * User: admin
     * Date: 2020/2/28 12:57
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function edit(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'key' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'language_enum' => ['required', Rule::in(LanguageEnum::all())],
            'translations.*.remark' => 'nullable',
        ]);

        $vo = new TranslationsVO();
        $vo->setRequest($request);

        $result = $this->service->edit($request->id, $vo);
        if ($result === TranslationErrorCode::SAME_LANGUAGE_KEY ||
            $result === TranslationErrorCode::No_TRANSLATION ) {
            return $this->failed($result, TranslationErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 批量编辑（只会编辑数据库中已经有的记录）
     * User: admin
     * Date: 2020/3/3 14:05
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function edits(Request $request)
    {
        $this->validate($request, [
            'translations' => 'required|array',
            'translations.*.id' => 'required',
            'translations.*.key' => 'required|string|max:255',
            'translations.*.value' => 'required|string|max:255',
            'translations.*.language_enum' => ['required', Rule::in(LanguageEnum::all())],
            'translations.*.remark' => 'nullable',
        ]);

        $result = $this->service->edits($request->translations);
        if ($result === TranslationErrorCode::TRANSLATION_EDIT_EXCEPTION) {
            return $this->failed($result, TranslationErrorCode::getText($result));

        } else {
            return $this->success($result);
        }
    }

    /**
     * Notes: 导入翻译Excel数据
     * User: admin
     * Date: 2020/11/5 16:21
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required'
        ]);
        $file = $request->file('file');
        return $this->success($this->service->import($file));
    }

    /**
     * Notes: 查找全部
     * User: admin
     * Date: 2020/2/28 12:59
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function all(Request $request)
    {
        return $this->success($this->service->all());
    }

    /**
     * Notes: 获取特定语言所有翻译
     * User: admin
     * Date: 2020/2/28 13:10
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function listByLanguageEnum(Request $request)
    {
        $this->validate($request, [
            'language_enum' => 'required',
        ]);

        return $this->success($this->service->listByLanguageEnum($request->language_enum));
    }

    /**
     * Notes: 获取语言列表
     * User: admin
     * Date: 2020/2/28 11:44
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function languages(Request $request)
    {
        return $this->success($this->service->languages());
    }

    /**
     * Notes: 测试Google翻译
     * User: admin
     * Date: 2021/05/12 12:09
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function testGoogleTranslate (Request $request)
    {
        $this->validate($request, [
        'input' => 'required',
        'language_enum' => 'required',
        'to_language_enum' => 'required',
        ]);
        $originalTag = LanguageEnum::getTag($request->language_enum);
        $toTag = LanguageEnum::getTag($request->to_language_enum);
        return $this->success($this->googleTranslate->translate($request->input, $originalTag, $toTag));
    }
}
