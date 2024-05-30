<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyFakultasdataRequest;
use App\Http\Requests\StoreFakultasdataRequest;
use App\Http\Requests\UpdateFakultasdataRequest;
use App\Models\Fakultasdata;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class FakultasdataController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('fakultasdata_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fakultasdatas = Fakultasdata::with(['media'])->get();

        return view('admin.fakultasdatas.index', compact('fakultasdatas'));
    }

    public function create()
    {
        abort_if(Gate::denies('fakultasdata_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.fakultasdatas.create');
    }

    public function store(StoreFakultasdataRequest $request)
    {
        $fakultasdata = Fakultasdata::create($request->all());

        if ($request->input('image', false)) {
            $fakultasdata->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $fakultasdata->id]);
        }

        return redirect()->route('admin.fakultasdatas.index');
    }

    public function edit(Fakultasdata $fakultasdata)
    {
        abort_if(Gate::denies('fakultasdata_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.fakultasdatas.edit', compact('fakultasdata'));
    }

    public function update(UpdateFakultasdataRequest $request, Fakultasdata $fakultasdata)
    {
        $fakultasdata->update($request->all());

        if ($request->input('image', false)) {
            if (! $fakultasdata->image || $request->input('image') !== $fakultasdata->image->file_name) {
                if ($fakultasdata->image) {
                    $fakultasdata->image->delete();
                }
                $fakultasdata->addMedia(storage_path('tmp/uploads/' . basename($request->input('image'))))->toMediaCollection('image');
            }
        } elseif ($fakultasdata->image) {
            $fakultasdata->image->delete();
        }

        return redirect()->route('admin.fakultasdatas.index');
    }

    public function show(Fakultasdata $fakultasdata)
    {
        abort_if(Gate::denies('fakultasdata_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.fakultasdatas.show', compact('fakultasdata'));
    }

    public function destroy(Fakultasdata $fakultasdata)
    {
        abort_if(Gate::denies('fakultasdata_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $fakultasdata->delete();

        return back();
    }

    public function massDestroy(MassDestroyFakultasdataRequest $request)
    {
        $fakultasdatas = Fakultasdata::find(request('ids'));

        foreach ($fakultasdatas as $fakultasdata) {
            $fakultasdata->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('fakultasdata_create') && Gate::denies('fakultasdata_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Fakultasdata();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
