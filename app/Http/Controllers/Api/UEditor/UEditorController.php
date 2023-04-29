<?php
/**
 * Created by PhpStorm
 * User: admin
 * Date: 2020/4/9 12:28
 */

namespace App\Http\Controllers\Api\UEditor;


use App\Http\Controllers\Controller;
use App\Modules\UEditor\Conf\UEditorUploadAction;
use App\Modules\UEditor\Service\UEditorService;
use Illuminate\Http\Request;

/**
 * Notes: UEditor控制器
 *
 * Class UEditorController
 * @package App\Http\Controllers\Api\UEditor
 */
class UEditorController extends Controller
{
    private $service;

    public function __construct(UEditorService $service)
    {
        $this->service = $service;
    }

    /**
     * Notes: UE后端接口
     * User: admin
     * Date: 2020/4/9 15:29
     *
     * @param Request $request
     * @return array
     * @throws \Illuminate\Validation\ValidationException
     */
    public function upload(Request $request)
    {
        if ($request->action === UEditorUploadAction::CONFIG) {
            return $this->service->config();


        } else if ($request->action === UEditorUploadAction::IMAGE ||
            $request->action === UEditorUploadAction::VIDEO ||
            $request->action === UEditorUploadAction::FILE) {

            $this->validate($request, [
                'file' => 'required'
            ]);

            return $this->service->uploadFile();

        } else if ($request->action === UEditorUploadAction::SCRAWL) {
            $this->validate($request, [
                'file' => 'required'
            ]);

            return $this->service->uploadScrawl();
        }

        return $this->service->failed();
    }
}
