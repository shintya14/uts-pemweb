@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.fakultasdata.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fakultasdatas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.id') }}
                        </th>
                        <td>
                            {{ $fakultasdata->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.name') }}
                        </th>
                        <td>
                            {{ $fakultasdata->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.dekan') }}
                        </th>
                        <td>
                            {{ $fakultasdata->dekan }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.fakultasdata.fields.jumlahmahasiswa') }}
                        </th>
                        <td>
                            {{ $fakultasdata->jumlahmahasiswa }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.fakultasdatas.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection